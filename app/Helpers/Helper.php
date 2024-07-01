<?php

use App\Helpers;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;


/**
 * @param $lang code like fa
 * @return string
 */
function getEmojiLanguagebyCode($lang): string
{
    $languages = [
        "af" => "🇿🇦", // Afrikaans
        "sq" => "🇦🇱", // Albanian
        "am" => "🇪🇹", // Amharic
        "ar" => "🇸🇦", // Arabic
        "hy" => "🇦🇲", // Armenian
        "az" => "🇦🇿", // Azerbaijani
        "eu" => "🇪🇸", // Basque
        "be" => "🇧🇾", // Belarusian
        "bn" => "🇧🇩", // Bengali
        "bs" => "🇧🇦", // Bosnian
        "bg" => "🇧🇬", // Bulgarian
        "ca" => "🇪🇸", // Catalan
        "zh" => "🇨🇳", // Chinese
        "hr" => "🇭🇷", // Croatian
        "cs" => "🇨🇿", // Czech
        "da" => "🇩🇰", // Danish
        "nl" => "🇳🇱", // Dutch
        "en" => "🇺🇸", // English
        "et" => "🇪🇪", // Estonian
        "fi" => "🇫🇮", // Finnish
        "fr" => "🇫🇷", // French
        "gl" => "🇪🇸", // Galician
        "ka" => "🇬🇪", // Georgian
        "de" => "🇩🇪", // German
        "el" => "🇬🇷", // Greek
        "gu" => "🇮🇳", // Gujarati
        "ht" => "🇭🇹", // Haitian
        "he" => "🇮🇱", // Hebrew
        "hi" => "🇮🇳", // Hindi
        "hu" => "🇭🇺", // Hungarian
        "is" => "🇮🇸", // Icelandic
        "id" => "🇮🇩", // Indonesian
        "ga" => "🇮🇪", // Irish
        "it" => "🇮🇹", // Italian
        "ja" => "🇯🇵", // Japanese
        "kk" => "🇰🇿", // Kazakh
        "ko" => "🇰🇷", // Korean
        "lv" => "🇱🇻", // Latvian
        "lt" => "🇱🇹", // Lithuanian
        "mk" => "🇲🇰", // Macedonian
        "ms" => "🇲🇾", // Malay
        "ml" => "🇮🇳", // Malayalam
        "mt" => "🇲🇹", // Maltese
        "mn" => "🇲🇳", // Mongolian
        "no" => "🇳🇴", // Norwegian
        "ps" => "🇦🇫", // Pashto
        "fa" => "🇮🇷", // Persian
        "pl" => "🇵🇱", // Polish
        "pt" => "🇵🇹", // Portuguese
        "ro" => "🇷🇴", // Romanian
        "ru" => "🇷🇺", // Russian
        "sr" => "🇷🇸", // Serbian
        "sk" => "🇸🇰", // Slovak
        "sl" => "🇸🇮", // Slovenian
        "es" => "🇪🇸", // Spanish
        "sw" => "🇰🇪", // Swahili
        "sv" => "🇸🇪", // Swedish
        "ta" => "🇮🇳", // Tamil
        "te" => "🇮🇳", // Telugu
        "th" => "🇹🇭", // Thai
        "tr" => "🇹🇷", // Turkish
        "uk" => "🇺🇦", // Ukrainian
        "ur" => "🇵🇰", // Urdu
        "uz" => "🇺🇿", // Uzbek
        "vi" => "🇻🇳", // Vietnamese
        "cy" => "🇬🇧"  // Welsh
    ];
    $lang = strtolower($lang);
    if (array_key_exists($lang, $languages)) {
        return $languages[$lang];
    } else {
        return "❓";
    }
}

/**
 * has route as named we want this model?
 * @param $name string
 * @param $endRoute string 'index' or alt list
 * @return bool
 */

function hasRoute($name): bool
{
    // create route
    $routes = explode('.', request()->route()->getName());
    $routes[count($routes) - 1] = $name;
    $cRuote = implode('.', $routes);

    if (\Illuminate\Support\Facades\Route::has($cRuote)) {
        return true;
    } else {
        return false;
    }
}

/**
 * get named route url
 * @param $name string
 * @param $args array
 * @return string|null
 */
function getRoute($name, $args = []): string|null
{
    // create route
    $routes = explode('.', request()->route()->getName());
    $routes[count($routes) - 1] = $name;
    $cRuote = implode('.', $routes);

    if (\Illuminate\Support\Facades\Route::has($cRuote)) {
        return \route($cRuote, $args);
    } else {
        return null;
    }
}


/**
 * make sort link suffix
 * @param $col string
 * @return string
 */
function sortSuffix($col): string
{
    if (request()->sort == $col) {
        if (request('sortType', 'asc') == 'desc') {
            return '&sortType=asc';
        } else {
            return '&sortType=desc';
        }
    } else {
        return '';
    }
}


/**
 * make array compatible | help us to translate
 * @param $array
 * @param $translate
 * @return false|string
 */
function arrayNormolizeVueCompatible($array, $translate = false): false|string
{
    $result = [];
    foreach ($array as $index => $item) {
        $result[] = ['id' => $index, 'name' => ($translate ? __($item) : $item)];
    }
    return json_encode($result);
}


/**
 * check string is json or not
 * @param $string
 * @return bool
 */
function isJson($string): bool
{
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}


/**
 * save admin batch log
 * @param $method
 * @param $cls class
 * @param $ids
 * @return void
 */
function logAdminBatch($method, $cls, $ids): void
{
    $act = explode('\\', $method);
    foreach ($ids as $id) {
        auth()->user()->logs()->create([
            'action' => $act[count($act) - 1],
            'loggable_type' => $cls,
            'loggable_id' => $id,
        ]);
    }
}

/**
 * save admin log
 * @param $method
 * @param $cls class
 * @param $id
 * @return void
 */
function logAdmin($method, $cls, $id): void
{
    $act = explode('\\', $method);
    auth()->user()->logs()->create([
        'action' => $act[count($act) - 1],
        'loggable_type' => $cls,
        'loggable_id' => $id,
    ]);
}

function gfx(){
    return \App\Models\Gfx::pluck('value','key');
}


/**
 * build query with excepts
 * @param $except
 * @return string
 */
function queryBuilder($except = null)
{
    $queries = request()->toArray();
    if ($except != null) {
        unset($queries[$except]);
        unset($queries['sortType']);
    }
    return http_build_query($queries);
}


/**
 * @param $name
 * @param $replace_char string
 * @return string
 */
function sluger($name, $replace_char = '-')
{
    // special chars
    $name = str_replace(['&', '+', '@', '*'], ['and', 'plus', 'at', 'star'], $name);

    // replace non letter or digits by -
    $name = preg_replace('~[^\pL\d\.]+~u', $replace_char, $name);

    // transliterate
    $name = iconv('utf-8', 'utf-8//TRANSLIT', $name);

    // trim
    $name = trim($name, $replace_char);

    // remove duplicate -
    $name = preg_replace('~-+~', $replace_char, $name);

    // lowercase
    $name = strtolower($name);

    if (empty($name)) {
        return 'N-A';
    }

    return substr($name, 0, 120);
}


/**
 * generate last item of breadcrumb of admin panel
 * @return void
 */
function lastCrump()
{
    $routes = explode('.', Route::currentRouteName());
    if (count($routes) != 3) {
        echo '<li >
        <a>
            <i class="ri-folder-chart-line" ></i>
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
        echo '<li >
        <a>
            <i class="ri-list-check" ></i>
            ' . __(Str::plural(ucfirst($routes[count($routes) - 2]))) . '
        </a>
    </li>';
    } else {
        $link = '#';
        $temp = $routes;
        array_pop($temp);
        $temp = implode('.', $temp) . '.';
        $link = \route($temp . 'index');
        echo '<li>
        <a href="' . $link . '">
            <i class="ri-list-check" ></i>
            ' . __(ucfirst(Str::plural($routes[count($routes) - 2]))) . '
        </a>
    </li>';
        switch ($route) {
            case 'create':
                $title = __('Add') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'ri-add-line';
                break;
            case 'edit':
                $title = __('Edit') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'ri-edit-line';
                break;
            case 'show':
                $title = __('Show') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'ri-eye-line';
                break;
            case 'sort':
                $title = __('Sort') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'ri-sort-number-asc';
                break;
            case 'trashed':
                $title = __('Trashed') . ' ' . __($routes[count($routes) - 2]);
                $icon = 'ri-delete-bin-6-line';
                break;
            default:
                $title = __('') . ' ' . __(ucfirst($routes[count($routes) - 1]));
                $icon = 'ri-bubble-chart-line';
                break;
        }
        echo '<li>
            <a>
                <i class="' . $icon . '" ></i>
                ' . $title . '
            </a>
        </li>';
    }
}


/**
 * @param $cats array categories or groups as nested ul li wih checkbox
 * @param $checked array witch one checked default
 * @param $parent null|integer parent id
 * @return string
 */
function showCatNestedControl($cats, $checked = [], $parent = null)
{
    $ret = "";
    foreach ($cats as $cat) {
        if ($cat->parent_id == $parent) {
            $ret .= "<li>";
            $check = in_array($cat->id, $checked) ? 'checked=""' : '';
            $ret .= "<label><input type='checkbox' name='cat[]' value='{$cat->id}' $check />";
            $ret .= $cat->name . '</label>';
            $ret .= showCatNestedControl($cats, $checked, $cat->id);
            $ret .= "</li>";
        }
    }
    if ($parent == null) {
        return $ret;
    } else {
        return "<ul class='ps-3'> $ret </ul>";
    }
}

/**
 * find model name form morph
 * @param $modelable_type
 * @param $modelable_id
 * @return string
 */
function getModelName($modelable_type, $modelable_id)
{
    $r = explode('\\', $modelable_type);
    return $r[count($r) - 1] . ':' . $modelable_id;
}

/**
 * find model show link form morph
 * @param $modelable_type
 * @param $modelable_id
 * @return string
 */
function getModelLink($modelable_type, $modelable_id)
{
    $r = explode('\\', $modelable_type);
    $model = strtolower($r[count($r) - 1]);
    $name = 'admin.' . $model . '.show';
    if (Route::has($name)) {
        return \route($name, $modelable_id);
    } else {
        return '';
    }
}

/**
 * fix action in log
 * @param $act
 * @return string
 */
function getAction($act)
{
    $r = explode('::', $act);
    return ucfirst($r[count($r) - 1]);

}

/**
 * ge all admin routes array
 * @return array
 */
function getAdminRoutes()
{
    $routes = [];
    foreach (Illuminate\Support\Facades\Route::getRoutes() as $r) {
        if (strpos($r->getName(), 'admin') !== false) {
            $routes[] = [
                'name' => $r->getName(),
                'url' => $r->uri(),
            ];
        }
    }

    return $routes;
}


/**
 * get model with all custom attributes
 * @param $model \Illuminate\Database\Eloquent\Model
 * @return void
 */
function modelWithCustomAttrs($model)
{
    $data = $model->toArray();
    $attrs = $model->getMutatedAttributes();
    $attrs = array_diff($attrs, ['translations']);
    foreach ($attrs as $attr) {
        $data[$attr] = $model->getAttribute($attr);
    }
    return $data;
}


/**
 * get max size for upload
 * @return int
 */
function getMaxUploadSize()
{
    $uploadMaxSize = returnBytes(ini_get('upload_max_filesize'));
    $postMaxSize = returnBytes(ini_get('post_max_size'));

    return min($uploadMaxSize, $postMaxSize);
}


/**
 * convert text to byte
 * @param $val
 * @return float|int|string
 */
function returnBytes($val)
{
    $last = strtolower($val[strlen($val) - 1]);
    $val = trim(strtolower($val), 'kgm');
    switch ($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024 * 1024 * 1024;
        case 'm':
            $val *= 1024 * 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}


/**
 * convert byte to human readable
 * @param $size
 * @return string
 */
function formatFileSize($size)
{
    if ($size < 1024) {
        return $size . ' bytes';
    } elseif ($size < 1048576) {
        return number_format($size / 1024, 1) . ' KB';
    } elseif ($size < 1073741824) {
        return number_format($size / 1048576, 1) . ' MB';
    } else {
        return number_format($size / 1073741824, 1) . ' GB';
    }
}


/**
 * generating hash UID by length
 * @param $length
 * @return string
 */
function generateUniqueID($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $uniqueID = '';

    for ($i = 0; $i < $length; $i++) {
        $randomChar = $chars[rand(0, strlen($chars) - 1)];
        $uniqueID .= $randomChar;
    }

    return $uniqueID;
}

/**
 * comment status to bypass blade error
 * @return array[]
 */
function commentStatuses()
{
    return [
        ['name' => __("Approved"), 'id' => '1'],
        ['name' => __("Rejected"), 'id' => '-1'],
        ['name' => __("Pending"), 'id' => '0']
    ];
}


/**
 * validate basic setting request b4 save
 * @param $setting
 * @param $newValue
 * @return mixed|string
 */
function validateSettingRequest($setting, $newValue)
{
    if (!$setting->is_basic) {
        return $newValue;
    }

    switch ($setting->key) {
        case 'optimize':
            if ($newValue != 'jpg' && $newValue != 'webp') {
                return 'webp';
            }else{
                return  $newValue;
            }
        case 'gallery_thumb':
        case 'post_thumb':
        case 'product_thumb':
        case 'product_image':
            $temp = explode('x', $newValue);
            if (count($temp) != 2) {
                return '500x500';
            } else {
                if ((int)$temp[0] < 50 || (int)$temp[1] < 50) {
                    return '500x500';
                }
            }
    }
    return $newValue;
}


/***
 * get setting by key
 * @param string $key setting key
 * @return false|mixed|string|null
 */
function getSetting($key)
{
    if (!isset($_SERVER['SERVER_NAME']) || !\Schema::hasTable('settings')) {
        return false;
    }
    $x = Setting::where('key', $key)->first();
    if ($x == null) {
//        $a = new \stdClass();
        return '';
    }
    if (config('app.xlang') && ($x->type == 'group' || $x->type == 'category')) {
        $defLang = config('app.xlang_main');
        return $x->getTranslations('value')[$defLang];
    }
    return $x->value;
}

/**
 * validae convert image size
 * @param $size
 * @return string[]
 */
function imageSizeConvertValidate($size)
{
    $s = getSetting($size);
    if ($s == null) {

        $t = explode('x', $size);
        if (config('app.media' . $size) == null || config('app.media' . $size) == '') {
            $t[0] = 500;
            $t[1] = 500;
        }

    } else {
        $t = explode('x', $s);
    }
    return $t;

}


function nestedWithData($items, $parent_id = null)
{
    $r = '<ol class="ol-sortable">' . PHP_EOL;
    foreach ($items as $item) {
        if ($item->parent_id == $parent_id) {
            $name = $item->name ?? $item->title ?? $item->id;
            $r .= "<li data-id='{$item->id}'> <span> <i class='ri-drag-move-2-line'></i> {$name}</span>" . PHP_EOL;
            $r .= nestedWithData($items, $item->id);
            $r .= PHP_EOL . ' </li>';
        }
    }
    $r .=  '</ol>' . PHP_EOL;
    return $r;
}
