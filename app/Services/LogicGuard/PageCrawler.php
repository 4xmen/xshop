<?php

namespace App\Services\LogicGuard;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\Route;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionProperty;
use Throwable;

class PageCrawler
{
    use MakesHttpRequests, InteractsWithAuthentication;

    private const UNSAFE_METHODS = '/^(destroy|delete|restore|remove\w*|detach|toggle\w*|logout|switchTheme|cacheClear|status|bulk\w*|download|ai|translateModelAi|build|image)$/i';

    private const GUEST_ROUTES = [
        'login' => [],
        'register' => [],
        'password.request' => [],
        'password.reset' => ['token' => 'logic-guard-token'],
    ];

    public Application $app;

    private array $hookClasses;

    public function __construct(Application $app, array $hookClasses)
    {
        $this->app = $app;
        $this->hookClasses = $hookClasses;
    }

    public function crawl(?string $only = null): array
    {
        $pages = [];
        $skipped = [];

        foreach ($this->targets() as $key => $target) {
            if ($only !== null && !str_contains($key, $only)) {
                continue;
            }
            if (isset($target['skip'])) {
                $skipped[$key] = $target['skip'];
                continue;
            }
            $pages[$key] = $this->visit($target);
        }

        ksort($pages);
        ksort($skipped);
        return compact('pages', 'skipped');
    }

    private function visit(array $target): array
    {
        $this->app['session']->forgetDrivers();
        $this->app->forgetInstance('session.store');
        $this->app['auth']->forgetGuards();

        $this->app['view']->flushState();
        if ($target['user'] !== null) {
            $this->actingAs($target['user']);
        }

        try {
            $response = $this->get($target['url']);
        } catch (Throwable $e) {
            return ['url' => $target['url'], 'status' => 'exception', 'error' => get_class($e) . ': ' . $e->getMessage()];
        }

        $base = $response->baseResponse;
        $page = [
            'url' => $target['url'],
            'status' => $base->getStatusCode(),
        ];

        if ($base->isRedirection()) {
            $page['location'] = $base->headers->get('Location');
            return $page;
        }
        if (isset($response->exception) && $response->exception !== null) {
            $page['error'] = get_class($response->exception) . ': ' . $response->exception->getMessage();
        }

        $type = (string)$base->headers->get('Content-Type');
        $content = $base instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse ? '' : (string)$base->getContent();

        if (!str_contains($type, 'html') || stripos($content, '<html') === false) {
            $page['type'] = $type;
            $page['body'] = md5(PageFingerprint::normalizeHtml($content));
            return $page;
        }

        $page['type'] = 'html';
        $page['fp'] = PageFingerprint::fromHtml($content, $this->hookClasses);
        return $page;
    }

    private function targets(): array
    {
        $developer = User::where('role', 'DEVELOPER')->orderBy('id')->first();
        $targets = [];

        foreach (self::GUEST_ROUTES as $name => $params) {
            if (Route::has($name)) {
                $targets['guest:' . $name] = ['user' => null, 'url' => route($name, $params, false)];
            }
        }

        foreach (Route::getRoutes()->getRoutes() as $route) {
            $name = $route->getName();
            if ($name === null || !str_starts_with($name, 'admin.') || !in_array('GET', $route->methods(), true)) {
                continue;
            }
            $key = 'admin:' . $name;
            $method = $route->getActionMethod();

            if (preg_match(self::UNSAFE_METHODS, $method)) {
                continue;
            }
            if ($developer === null) {
                $targets[$key] = ['skip' => 'no DEVELOPER user in the database'];
                continue;
            }

            try {
                $params = $this->resolveParameters($route);
            } catch (Throwable $e) {
                $targets[$key] = ['skip' => 'parameter resolution failed: ' . $e->getMessage()];
                continue;
            }
            if (is_string($params)) {
                $targets[$key] = ['skip' => $params];
                continue;
            }

            $targets[$key] = ['user' => $developer, 'url' => route($name, $params, false)];
        }

        ksort($targets);
        return $targets;
    }

    private function resolveParameters(LaravelRoute $route): array|string
    {
        $names = $route->parameterNames();
        if ($names === []) {
            return [];
        }

        $override = $this->overrides()[$route->getName()] ?? null;
        if ($override !== null) {
            return $override();
        }

        $controller = $route->getControllerClass();
        $method = $route->getActionMethod();
        $types = [];
        if ($controller && method_exists($controller, $method)) {
            foreach ((new ReflectionMethod($controller, $method))->getParameters() as $p) {
                $t = $p->getType();
                if ($t instanceof ReflectionNamedType && !$t->isBuiltin() && is_subclass_of($t->getName(), Model::class)) {
                    $types[$p->getName()] = $t->getName();
                }
            }
        }

        $params = [];
        foreach ($names as $i => $param) {
            $optional = str_contains($route->uri(), '{' . $param . '?}');
            $modelClass = $types[$param] ?? (array_values($types)[$i] ?? null);
            if ($modelClass === null && $param === 'item') {
                $modelClass = $this->controllerModel($controller);
            }

            if ($modelClass !== null) {
                $model = $modelClass::query()->orderBy((new $modelClass)->getKeyName())->first();
                if ($model === null) {
                    if ($optional) {
                        continue;
                    }
                    return 'no ' . class_basename($modelClass) . ' record to render';
                }
                $params[$param] = $model->getRouteKey();
                continue;
            }

            if (!$optional) {
                return 'cannot resolve required parameter {' . $param . '}';
            }
        }
        return $params;
    }

    private function controllerModel(?string $controller): ?string
    {
        if ($controller === null || !property_exists($controller, '_MODEL_')) {
            return null;
        }
        $value = (new ReflectionProperty($controller, '_MODEL_'))->getValue($this->app->make($controller));
        return is_string($value) && is_subclass_of($value, Model::class) ? $value : null;
    }

    private function overrides(): array
    {
        $first = function (string $class, string $column): ?string {
            $value = $class::query()->orderBy('id')->value($column);
            return $value === null ? null : (string)$value;
        };

        return [
            'admin.contact.show' => fn() => ($h = $first(\App\Models\Contact::class, 'hash')) ? ['item' => $h] : 'no Contact record to render',
            'admin.invoice.show' => fn() => ($h = $first(\App\Models\Invoice::class, 'hash')) ? ['item' => $h] : 'no Invoice record to render',
            'admin.post.group-edit' => fn() => ($id = $first(\App\Models\Post::class, 'id')) ? ['id' => $id] : 'no Post record to render',
            'admin.product.category-edit' => fn() => ($id = $first(\App\Models\Product::class, 'id')) ? ['id' => $id] : 'no Product record to render',
            'admin.lang.model' => fn() => ($id = $first(\App\Models\Product::class, 'id')) ? ['id' => $id, 'model' => \App\Models\Product::class] : 'no Product record to render',
            'admin.lang.onlineEdit' => fn() => ($tag = $first(\App\Models\XLang::class, 'tag')) ? ['tag' => $tag] : 'no XLang record to render',
            'admin.area.design.model' => function () use ($first) {
                $area = \App\Models\Area::query()->orderBy('id')->first();
                $group = $first(\App\Models\Group::class, 'id');
                return $area && $group ? ['area' => $area->getRouteKey(), 'model' => 'Group', 'id' => $group] : 'no Area/Group record to render';
            },
            'admin.setting.live' => fn() => 'live editor needs a client page slug; checked by hand',
        ];
    }
}
