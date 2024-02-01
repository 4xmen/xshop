<?php

namespace App\Helpers;

use App\Models\Cat;
use App\Models\Product;
use App\Models\Prop;
use App\Models\Setting;
use Xmen\StarterKit\Helpers\TDate;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Menu;
use Xmen\StarterKit\Models\MenuItem;
use Xmen\StarterKit\Models\Post;
use Illuminate\Support\Facades\Route;

/***
 * get setting by key
 * @param string $key setting key
 * @return false|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string|null
 */
function getSetting($key)
{
    if (!isset($_SERVER['SERVER_NAME']) || !\Schema::hasTable('settings')) {
        return false;
    }
    $x = Setting::where('key', $key)->first();
    if ($x == null) {
        $a = new \stdClass();
        return '';
    }
    return $x->value;
}

/***
 * get category form setting by key
 * @param string $key setting key
 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|string|Category|null
 */
function getSettingCategory($key)
{
    $x = Setting::where('key', $key)->first();
    if ($x == null) {
        $a = new \stdClass();
        return '';
    }
    return Category::where('id', $x->value)->first();
}

/***
 * get product category by setting key
 * @param string $key setting key
 * @return Cat|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|string|null
 */
function getSettingCat($key)
{
    $x = Setting::where('key', $key)->first();
    if ($x == null) {
        $a = new \stdClass();
        return '';
    }
    return Cat::where('id', $x->value)->first();
}

/***
 * get stock types
 * @return array
 */
function stockTypes()
{
    return ["IN_STOCK" => __("In stock"), "OUT_STOCK" => __("Out stock"), "BACK_ORDER" => __("Back order")];
}

/***
 * make meta with key and value
 * @param $metaz
 * @return array
 */
function metaing($metaz)
{
    $out = [];
    if ($metaz == null) {
        return $out;
    }
    foreach ($metaz as $k => $meta) {
        $out[$k] = $meta->value;
    }
    return $out;
}

/***
 * get just pricable meta of product
 * @param Product $pro
 * @return array
 */
function getPriceableMeta(Product $pro)
{
    $metas = $pro->getAllMeta()->toArray();
    if (count($metas) == 0) {
        return [];
    }
    $pricables = $pro->category->props()->where('priceable', 1)->pluck('name')->toArray();
    $result = [];
    if (is_array($pricables)) {
        foreach ($pricables as $price) {
            if (isset($metas[$price])) {
                $result[$price] = $metas[$price];
            }
        }
    }
    return $result;
}

/***
 * show product categories in node with ul-li
 * @param $cats category node
 * @param $liClass class of lis
 * @param $ulClass class of uls
 * @return string
 */
function showCats($cats = [], $liClass = '', $ulClass = '')
{
    if ($cats == []) {
        $cats = Cat::whereNull('parent_id')->get();
    }
    $txt = '';
    foreach ($cats as $cat) {
        $txt .= '<li class="' . $liClass . '">
        <a href="' . route('cat', $cat->slug) . '">' . $cat->name . '</a>';
        if ($cat->children()->count() > 0) {
//            $txt .='<li> '.$cat->name;
            $txt .= '<ul class="' . $ulClass . '">';
            $txt .= showCats($cat->children, $liClass, $ulClass);
            $txt .= '</ul>';
        } else {

        }
        $txt .= '</li>';
    }
    return $txt;
}

/***
 * show menu node for manage
 * @param $arr
 * @return string
 */
function showMenuMange($arr)
{
    $back = '';
    foreach ($arr as $menu) {
        $ol = '';
        if ($menu->children()->count() > 0) {
            $ol = '<ol>' . showMenuMange($menu->children()->orderBy('sort')->get()) . '</ol>';
        }
        $back .= <<<LI
        <li class="list-group-item"
        data-menuabletype="$menu->menuable_type"
        data-menuableid="$menu->menuable_id"
        data-meta="$menu->meta"
        data-kind="$menu->kind"
        data-title="$menu->title"
        >
            <span>
                $menu->title
            </span>
            $ol
        </li>
LI;
    }
    return $back;
}

/***
 * show menu node
 * @param array $arr
 * @return string
 */
function showMenu($arr)
{
    $back = '';
    foreach ($arr as $menu) {
        $ol = '';
        if ($menu->children()->count() > 0) {
            $ol = '<ol>' . showMenu($menu->children()->orderBy('sort')->get()) . '</ol>';
        }
        switch ($menu->kind) {
            case "empty":

                $back .= <<<LI
                <li class="nav-item">
                        <li class="nav-item">
                                <a class="nav-link" >$menu->title</a>
                        </li>
                    $ol
                </li>
LI;
                break;
            case "link":
                $back .= <<<LI
                <li class="nav-item">
                        <li class="nav-item">
                                <a class="nav-link" href="$menu->meta">$menu->title</a>
                        </li>
                    $ol
                </li>
LI;
                break;
            case "news":

                break;
            case "cat":

                break;
            case "cat-sub":

                break;
            case "cat-news":

                break;
            case "tag":

                break;
            case "tag-sub":

                break;
            default:

        }
    }
    return $back;
}


/***
 * show input products categories node
 * @param Cat[] $arr
 * @return string
 */
function showCatNode($arr)
{
    $ret = '';
    foreach ($arr as $cat) {
        $ret .= "<li data-id='$cat->id' > $cat->name <ol>  ";
        if ($cat->children()->count() > 0) {
            $ret .= showCatNode($cat->children);
        }
        $ret .= " </ol> </li> ";
    }
    return $ret;
}

/***
 * show menu items as types
 * @param MenuItem[] $items
 * @return string
 */
function MenuShowItems($items)
{
    $out = '';
    foreach ($items as $item) {
        $out .= '<li>';
        switch ($item->kind) {
            case "tag":
                $out .= '<a href="' . route('n.tag', $item->meta) . '" >' . $item->title . '</a>';
                break;
            case "link":
                $out .= '<a href="' . $item->meta . '" >' . $item->title . '</a>';
                break;
            case "news":
                $n = Post::whereId($item->menuable_id)->firstOrFail();
                $out .= '<a href="' . route('n.show', $n->slug) . '" >' . $item->title . '</a>';
                break;
            case "tag-sub":
                $out .= $item->title;
                $news = Post::withAnyTag($item->meta)->limit(10)->get(['title', 'slug']);
                $out .= '<ul>';
                foreach ($news as $new) {
                    $out .= '<li><a href="' . route('n.show', $new->slug) . '" >' . $new->title . '</a></li>';
                }
                $out .= '</ul>';
                break;
            case "cat":
                $cat = Category::whereId($item->menuable_id)->firstOrFail();
                $out .= '<a href="' . route('n.cat', $cat->slug) . '" >' . $item->title . '</a>';
                break;
            case "cat-sub":
                $out .= $item->title;
                $cats = Category::where('parent_id', $item->menuable_id)->limit(20)->get(['name', 'slug']);
                $out .= '<ul>';
                foreach ($cats as $c) {
                    $out .= '<li><a href="' . route('n.cat', $c->slug) . '" >' . $c->name . '</a></li>';
                }
                $out .= '</ul>';
                break;
            case "cat-news":
                $out .= '<a class="menu-link">' . $item->title . '</a>';
                $cat = Category::whereId($item->menuable_id)->firstOrFail();
                $news = $cat->posts()->limit(10)->get(['slug', 'title']);
                $out .= '<ul>';
                foreach ($news as $new) {
                    $out .= '<li><a href="' . route('n.show', $new->slug) . '" >' . $new->title . '</a></li>';
                }
                $out .= '</ul>';
                break;
            default:
                $out .= $item->title;
                if ($item->children()->count() > 0) {
                    $out .= '<ul>' . MenuShowItems($item->children) . '</ul>';
                }
        }
        $out .= '</li>';
    }
    $out .= '';
    return $out;
}

/***
 * show menu by name
 * @param $menu_name
 * @return string
 */
function MenuShowByName($menu_name)
{
    $menu = Menu::whereName($menu_name)->firstOrFail();
    return MenuShowItems($menu->menuItems()->whereNull('parent')->get());
}

/***
 * make breadcrumbs for admin panel
 * @return void
 */
function lastCrump()
{
    $routes = explode('.', Route::currentRouteName());
    if (count($routes) != 3) {
        echo '<li class="step">
        <a>
            <i class="fa fa-cube" ></i>
            ' . __(ucfirst($routes[count($routes) - 1])) . '
        </a>
    </li>';
        return;
    }
    $route = $routes[count($routes) - 1];
    if ($route == 'home') {
        return;
    }

    if ($route == 'all' || $route == 'index' || $route == 'list') {
        echo '<li class="step">
        <a>
            <i class="fa fa-list" ></i>
            ' . __(ucfirst($routes[count($routes) - 2])) . '
        </a>
    </li>';
    } else {
        $link = '#';
        $temp = $routes;
        array_pop($temp);
        $temp = implode('.', $temp) . '.';
        if (Route::has($temp . 'index')) {
            $link = \route($temp . 'index');
        } elseif (Route::has($temp . 'all')) {
            $link = \route($temp . 'all');
        } elseif (Route::has($temp . 'list')) {
            $link = \route($temp . 'list');
        }
        echo '<li class="step">
        <a href="' . $link . '">
            <i class="fa fa-list" ></i>
            ' . __(ucfirst($routes[count($routes) - 2])) . '
        </a>
    </li>';
        switch ($route) {
            case 'create':
                $title = __('Add') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'fa fa-add';
                break;
            case 'edit':
                $title = __('Edit') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'fa fa-edit';
                break;
            case 'show':
                $title = __('Show') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'fa fa-eye';
                break;
            case 'sort':
                $title = __('Sort') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'fa fa-sort';
                break;
            default:
                $title = __('') . ' ' . __(ucfirst($routes[count($routes) - 1]));
                $icon = 'fa fa-cube';
                break;
        }
        echo '<li class="step">
            <a>
                <i class="' . $icon . '" ></i>
                ' . $title . '
            </a>
        </li>';
    }
}


/***
 * get main product categories
 * @param int $limit
 * @return Cat[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|\LaravelIdea\Helper\App\Models\_IH_Cat_C
 */
function getMainCats($limit = 10)
{
    return Cat::whereNull('parent_id')->limit($limit)->get();
}

/***
 * get products by category id
 * @param int $id
 * @param string $order
 * @param string $orderMethod
 * @param int $limit
 * @return Product[]|array|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Product_C
 */
function getProductByCat($id, $order = 'id', $orderMethod = 'desc', $limit = 10)
{
    $cat = Cat::where('id', $id)->first();

    if ($cat == null) {
        return [];
    }
    return $cat->active_products()->where('active', 1)
        ->orderBy($order, $orderMethod)->limit($limit)->get();
}

/***
 * get product by category id where `stock_quantity` more than 0
 * @param int $id
 * @param string $order
 * @param int $limit
 * @return Product[]|array|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Product_C
 */
function getProductByCatQ($id, $order = 'id', $limit = 10)
{
    $cat = Cat::where('id', $id)->first();

    if ($cat == null) {
        return [];
    }
    return $cat->products()->where('active', 1)->where('stock_quantity', '>', 0)
        ->orderByDesc('id')->limit($limit)->get();
}

/***
 * get sub product categories by id
 * @param $id
 * @return Cat[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Cat_C
 */
function getSubCats($id,$limit = 99)
{
    return Cat::where('parent_id', $id)->limit($limit)->get();
}

/***
 * get products with sort
 * @param string $order
 * @param string $orderMethod
 * @param int $limit
 * @return Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|\LaravelIdea\Helper\App\Models\_IH_Product_C
 */
function getProducts($order = 'id', $orderMethod = 'desc', $limit = 10)
{
    return Product::orderBy($order, $orderMethod)->limit($limit)->get();
}

/***
 * get property by name
 * @param string $name
 * @return Prop|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
 */
function getProp($name)
{
    return Prop::where('name', $name)->first();
}

/***
 * get unit of property by name
 * @param string $name
 * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string|null
 */
function getPropUnit($name)
{
    if (Prop::where('name', $name)->count() == 0) {
        return '';
    }
    return Prop::where('name', $name)->first()->unit;
}

/***
 * get label of property by name
 * @param string $name
 * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string|null
 */
function getPropLabel($name)
{
    if (Prop::where('name', $name)->count() == 0) {
        return '';
    }
    $n = Prop::where('name', $name)->first();
    if ($n != null) {
        return Prop::where('name', $name)->first()->label;
    } else {
        if ($name == 'weight') {
            return __('weight');
        } else {
            return $name;
        }
    }
}

/***
 * check is json or not
 * @param string $str
 * @return bool
 */
function isJson($str)
{
    $json = json_decode($str);
    return $json && $str != $json;
}

/***
 * json decode and sort
 * @param array $json
 * @return mixed
 */
function jsonOrder($json)
{
    $data = json_decode($json, true);
    asort($data);
    return $data;
}

/***
 * get meta value
 * @param string $key
 * @param string $value
 * @return void
 */
function getMetaValue($key, $value)
{
    $p = Prop::whereName($key)->first();
    foreach (json_decode($p->options) as $n) {
        if ($n->value == $value) {
            return $n->title;
        }
    }
}

/***
 * show meta with values
 * @param string $key
 * @param string $value
 * @return string
 */
function showMeta($key, $value)
{

    if (Prop::whereName('warranty')->count() == 0 && $key == 'warranty') {
        return '';
    }

    if ($key == 'weight') {
        return $value . ' ' . __('Gram(s)');
    }
    if ($key == 'warranty') {
        $p = Prop::whereName('warranty')->first();
        foreach (json_decode($p->options) as $n) {
            if ($n->value == $value) {
                return $n->title;
            }
        }
    }

    if ($key == 'color') {
        return '<div style="background: ' . $value . ';min-width: 15px; height:15px; display: inline-block; margin-right: 4px; margin-left: 4px" ></div><b style="position: relative;top: -3px;padding:2px;display: inline-block">' . getColorName($value) . '</b>';
    }

    $txt = $value;
    if (isJson($value)) {
        $txt = '';
        foreach (json_decode($value, true) as $item) {
            $txt .= '<div class="badge p-1 ps-2 pe-2 m-1 bg-primary mb-0" > ' . $item['title'] . ' </div>';
        }
    }
    return trim($txt . ' ' . getPropUnit($key));
}

/***
 * time to persian date
 * @param $date
 * @param $format
 * @return float|int|string|\Xmen\StarterKit\Helpers\timestamp
 */
function time2persian($date, $format = 'Y/m/d')
{
    if ($date == null){
        return  '-';
    }
    $dt = new TDate();
    return $dt->PDate($format, $date);
}

/***
 * get colors
 * @return array
 */
function getColors()
{
    $colors = Prop::where('name', 'color')->first();
    if ($colors == null) {
        return [];
    }
    $data = json_decode($colors->options, true);
    $result = [];
    foreach ($data as $color) {
        $result[$color['value']] = $color['title'];
    }
    return $result;
}

/***
 * get color name
 * @param $colorVal
 * @return mixed|string
 */
function getColorName($colorVal)
{
    $colors = Prop::where('name', 'color')->first();
    if ($colors == null) {
        return 'رنگ';
    }
    $data = json_decode($colors->options, true);
    foreach ($data as $color) {
        if ($colorVal == $color['value']) {
            return $color['title'];
        }
    }
    return 'رنگ';
}

/***
 * make chartjs
 * @param $pro
 * @return string
 */
function makeChart($pro)
{
    $times = $pro->prices_history()->pluck('created_at')->toArray();
    $dates = [];
    foreach (array_reverse($times) as $time) {
        $dates[] = \App\Helpers\time2persian($time->timestamp, 'd F Y');
    }
    $dts = json_encode($dates);

    $prs = json_encode(array_reverse($pro->prices_history()->pluck('price')->toArray()));
    $text = <<<TXT
 <canvas  id="canvas" style="display: block; height: 400px;"  height="400" class="chartjs-render-monitor"></canvas>
 <input type="hidden" id="labels" value='$dts'>
 <input type="hidden" id="prices" value='$prs'>
TXT;
    return $text;
}

/***
 * make breadcrumb
 * @param Product $p
 * @param Cat $c
 * @return array[]
 */
function makeProductBreadcrumb(Product $p, Cat $c)
{
    $items = [
        [
            'name' => $c->name,
            'link' => \route('cat', $c->slug)
        ]
    ];
    while ($c->parent_id != null) {
        $c = Cat::where('id', $c->parent_id)->first();
        $items[] = [
            'name' => $c->name,
            'link' => \route('cat', $c->slug)
        ];
    }

    $items = array_reverse($items);
    $items[] = [
        'name' => $p->name,
        'link' => \route('product', $p->slug)
    ];
    return $items;
}

/***
 * show markup breadcrumb
 * @param $itemz
 * @return void
 */
function showBreadcrumb($itemz = [])
{
    $text = <<<DOC
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "BreadcrumbList",
  "itemListElement": [
  ITEMS
  ]
}
</script>
DOC;
    $items = '{
      "@type": "ListItem",
      "position": 1,
      "name": "' . config('app.name') . '",
      "item": "' . route('welcome') . '"
    },';
    foreach ($itemz as $k => $item) {
        $items .= '{
      "@type": "ListItem",
      "position": ' . ($k + 2) . ',
      "name": "' . $item['name'] . '",
      "item": "' . $item['link'] . '"
    },';
    }
    $items = ltrim($items);
    echo str_replace('ITEMS', $items, $text);
}

/***
 * get items count in shoppig card
 * @return int
 */
function cardCount()
{
    return count(array_merge(unserialize(session('card', serialize([]))), unserialize(session('qcard', serialize([])))));
}


/***
 * send sms
 * @param string $number phone number
 * @param string $content sms content
 * @return bool|string
 */
function sendSMSText($number, $content)
{

    $url = config('app.sms_url');

    $options = array(
        'content-type' => 'application/x-www-form-urlencoded',
        'postman-token' => '3e37c158-2c35-75aa-1ae7-f76d90ebbe8f',
        'cache-control' => 'no-cache'
    );
    $fields_string = http_build_query(array(
        'username' => config('app.sms_user'),
        'password' => config('app.sms_pass'),
        'to' => $number,
        'from' => config('app.sms_number'),
        'text' => $content,
        'isflash' => 'false'
    ));

//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
    $result = curl_exec($ch);
    return $result;
}

/***
 * send sms
 * @param string $number phone number
 * @param string $content sms content
 * @return bool|string
 */
function sendSMSText2($number, $content)
{

    $url = config('app.sms_url');

    $options = array(
        'content-type' => 'application/x-www-form-urlencoded',
        'cache-control' => 'no-cache'
    );
    $fields_string = http_build_query(array(
        'user' => config('app.sms_user'),
        'password' => config('app.sms_pass'),
        'number' => $number,
        'text' => $content,
        'isflash' => 'false'
    ));

//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
    $result = curl_exec($ch);
    return json_decode($result,true);
}

/***
 * remove title of html code
 * @param $str
 * @return array|string|string[]|null
 */
function remTitle($str)
{
    $re = '/<title>(.*?)<\/title>/m';
    return preg_replace($re, '', $str);
}

/***
 * show json by key
 * @param $json
 * @param $key
 * @return mixed|string
 */
function showJsonByKey($json, $key)
{
    $x = json_decode($json);
    $x = json_decode($x->data, true);
    $items = json_decode(\App\Helpers\getProp('size')->options, true);
    foreach ($items as $item) {
        if ($x[$key] == $item['value']) {
            return $item['title'];
        }
    }
    return 'x';
}

/***
 * find html links
 * @param $html
 * @return string|null
 */
function findLink($html)
{

    $url = preg_match('/<a href="(.+)">/', $html, $match);

    if (!isset($match[1])) {
        return null;
    }

    return $match[1];

}
