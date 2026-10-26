<?php

namespace App\Console\Commands;

use App\Services\LogicGuard\PageCrawler;
use App\Services\LogicGuard\PageDiffer;
use App\Services\LogicGuard\StaticChecker;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LogicGuard extends Command
{
    protected $signature = 'logic:guard
        {mode : snapshot | check}
        {--base=master : git ref the static check compares against}
        {--only= : only crawl pages whose key contains this text}
        {--static-only : skip the page crawl}
        {--pages-only : skip the git-based static check}';

    protected $description = 'Snapshot the panel\'s behaviour, then verify a redesign left it unchanged.';

    private const BOOTSTRAP_HOOKS = [
        'dropdown', 'dropdown-menu', 'dropdown-toggle', 'dropdown-item', 'collapse', 'navbar-collapse', 'navbar-toggler',
        'modal', 'modal-dialog', 'modal-content', 'tab-pane', 'nav-link', 'nav-tabs', 'nav-pills', 'accordion-collapse',
        'accordion-button', 'btn-close', 'offcanvas', 'toast', 'carousel', 'carousel-item', 'form-check-input', 'is-invalid',
        'invalid-feedback',
    ];

    private string $dir;

    public function handle(): int
    {
        $this->dir = storage_path('logic-guard');
        File::ensureDirectoryExists($this->dir);
        if (!File::exists($this->dir . '/.gitignore')) {
            File::put($this->dir . '/.gitignore', "*\n!.gitignore\n");
        }

        return match ($this->argument('mode')) {
            'snapshot' => $this->snapshot(),
            'check' => $this->check(),
            default => $this->invalidMode(),
        };
    }

    private function snapshot(): int
    {
        $frozenAt = now()->toIso8601String();
        $frozenDb = $this->freezeDatabase();
        $hooks = $this->hookClasses();

        $this->info('Crawling the panel twice to separate real behaviour from per-request noise…');
        $first = $this->crawl($frozenDb, $frozenAt, $hooks);
        $second = $this->crawl($frozenDb, $frozenAt, $hooks);
        $volatile = PageDiffer::volatility($first['pages'], $second['pages']);

        $baseline = [
            'created_at' => $frozenAt,
            'git_head' => trim((string)shell_exec('git -C ' . escapeshellarg(base_path()) . ' rev-parse HEAD')),
            'database' => $frozenDb,
            'hook_classes' => $hooks,
            'pages' => $first['pages'],
            'skipped' => $first['skipped'],
            'volatile' => $volatile,
        ];
        File::put($this->dir . '/baseline.json', json_encode($baseline, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $broken = array_filter($first['pages'], fn($p) => !in_array($p['status'], [200, 302], true) || isset($p['error']));
        $this->newLine();
        $this->table(['', 'count'], [
            ['pages fingerprinted', count($first['pages'])],
            ['pages skipped (unsafe or unresolvable)', count($first['skipped'])],
            ['pages with volatile parts (ignored in checks)', count($volatile)],
            ['pages already failing before the redesign', count($broken)],
            ['JavaScript hook classes tracked', count($hooks)],
        ]);
        foreach ($broken as $key => $page) {
            $this->warn("  already failing: {$key} → {$page['status']} " . ($page['error'] ?? ''));
        }
        $this->info('Baseline written to ' . $this->relative($this->dir . '/baseline.json'));
        return self::SUCCESS;
    }

    private function check(): int
    {
        $issues = [];

        if (!$this->option('pages-only')) {
            $this->info('Static check against ' . $this->option('base') . '…');
            foreach ((new StaticChecker(base_path(), $this->option('base')))->check() as $i) {
                $issues[] = ['severity' => $i['severity'], 'where' => $i['file'], 'area' => $i['area'], 'message' => $i['message']];
            }
        }

        if (!$this->option('static-only')) {
            $path = $this->dir . '/baseline.json';
            if (!File::exists($path)) {
                $this->error('No baseline yet. Run `php artisan logic:guard snapshot` on the code you trust first.');
                return self::FAILURE;
            }
            $baseline = json_decode(File::get($path), true);
            $this->info('Crawling the panel against the frozen baseline data…');
            $current = $this->crawl($baseline['database'], $baseline['created_at'], $baseline['hook_classes']);

            $before = $baseline['pages'];
            if ($only = $this->option('only')) {
                $before = array_filter($before, fn($k) => str_contains($k, $only), ARRAY_FILTER_USE_KEY);
            }
            foreach (PageDiffer::diff($before, $current['pages'], $baseline['volatile'] ?? []) as $i) {
                $issues[] = ['severity' => $i['severity'], 'where' => $i['page'], 'area' => $i['area'], 'message' => $i['message']];
            }
        }

        $this->writeReport($issues);
        return $this->summarize($issues);
    }

    private function crawl(?string $frozenDb, string $frozenAt, array $hooks): array
    {
        $restore = null;
        if ($frozenDb !== null) {
            $run = $this->dir . '/run.sqlite';
            File::copy($frozenDb, $run);
            $conn = config('database.default');
            $restore = config("database.connections.{$conn}.database");
            config(["database.connections.{$conn}.database" => $run]);
            DB::purge($conn);
        }

        Carbon::setTestNow($frozenAt);
        CarbonImmutable::setTestNow($frozenAt);

        config(['minify.enabled' => false, 'minify.obfuscate' => false]);
        try {
            return (new PageCrawler($this->laravel, $hooks))->crawl($this->option('only') ?: null);
        } finally {
            Carbon::setTestNow();
            CarbonImmutable::setTestNow();
            if ($restore !== null) {
                $conn = config('database.default');
                config(["database.connections.{$conn}.database" => $restore]);
                DB::purge($conn);
            }
        }
    }

    private function freezeDatabase(): ?string
    {
        $conn = config('database.default');
        $cfg = config("database.connections.{$conn}");
        if (($cfg['driver'] ?? null) !== 'sqlite' || !File::exists($cfg['database'] ?? '')) {
            $this->warn("Database '{$conn}' is not a SQLite file; the check will run against live data.");
            return null;
        }
        $target = $this->dir . '/baseline.sqlite';
        File::copy($cfg['database'], $target);
        return $target;
    }

    private function hookClasses(): array
    {
        $classes = self::BOOTSTRAP_HOOKS;
        foreach (File::allFiles(resource_path('js')) as $file) {
            if (!in_array($file->getExtension(), ['js', 'vue'], true) || str_contains($file->getPathname(), '/client')) {
                continue;
            }
            $src = $file->getContents();
            preg_match_all('/(?:querySelector(?:All)?|closest|matches)\(\s*([\'"`])(.*?)\1/s', $src, $sel);
            foreach ($sel[2] as $selector) {
                preg_match_all('/\.([A-Za-z_][\w-]*)/', $selector, $c);
                array_push($classes, ...$c[1]);
            }
            preg_match_all('/(?:classList\.(?:add|remove|toggle|contains)|getElementsByClassName)\(([^)]*)\)/', $src, $lists);
            foreach ($lists[1] as $args) {
                preg_match_all('/[\'"]([A-Za-z_][\w-]*)[\'"]/', $args, $c);
                array_push($classes, ...$c[1]);
            }
        }
        $classes = array_values(array_unique($classes));
        sort($classes);
        return $classes;
    }

    private function writeReport(array $issues): void
    {
        File::put($this->dir . '/report.json', json_encode($issues, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $md = "# Logic guard report\n\n" . now()->toDateTimeString() . "\n\n";
        foreach (['error', 'warning'] as $severity) {
            $rows = array_filter($issues, fn($i) => $i['severity'] === $severity);
            $md .= '## ' . ucfirst($severity) . 's (' . count($rows) . ")\n\n";
            foreach ($rows as $i) {
                $md .= "- **{$i['where']}** `{$i['area']}` " . str_replace("\n", ' ', $i['message']) . "\n";
            }
            $md .= "\n";
        }
        File::put($this->dir . '/report.md', $md);
    }

    private function summarize(array $issues): int
    {
        $errors = array_filter($issues, fn($i) => $i['severity'] === 'error');
        $warnings = array_filter($issues, fn($i) => $i['severity'] === 'warning');

        foreach ([[$errors, 'error'], [$warnings, 'warn']] as [$rows, $style]) {
            $shown = 0;
            foreach ($rows as $i) {
                if ($shown++ >= 60) {
                    $this->line('  … ' . (count($rows) - 60) . ' more in the report');
                    break;
                }
                $this->{$style}("  [{$i['area']}] {$i['where']}: {$i['message']}");
            }
        }

        $this->newLine();
        $this->table(['errors', 'warnings', 'report'], [[count($errors), count($warnings), $this->relative($this->dir . '/report.md')]]);
        if ($errors) {
            $this->error('Logic changed. Fix the errors above, or re-snapshot only if the change is intended.');
            return self::FAILURE;
        }
        $this->info('No logic changes detected.');
        return self::SUCCESS;
    }

    private function invalidMode(): int
    {
        $this->error('Mode must be "snapshot" or "check".');
        return self::INVALID;
    }

    private function relative(string $path): string
    {
        return ltrim(str_replace(base_path(), '', $path), '/');
    }
}
