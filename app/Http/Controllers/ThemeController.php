<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{

    //
    public function cssVariables()
    {
        $response = 'main{';
        if (langIsRTL(app()->getLocale())) {
            $response .= 'font-feature-settings: "ss01";';
        }
        foreach (Setting::where('section', 'theme')->whereNotNull('data')
                     ->get(['raw', 'data']) as $color) {
            $data = json_decode($color->data);
            if (isset($data->name)) {
                $response .= '--' . $data->name . ':' . $color->raw;
                if (isset($data->suffix)) {
                    $response .= $data->suffix;
                }
                $response .= ';';
            }
        }
        $response .= '}';

        if (langIsRTL(app()->getLocale())) {
            $response .= ' .slider-content, .tns-outer .item{ direction: rtl; }';
        }
        if (langIsRTL(app()->getLocale())) {
            $response .= ' .main-dir{ direction: rtl; }';
        }else{
            $response .= ' .main-dir{ direction: ltr; }';
        }
        return response($response)->header('Content-Type', 'text/css; charset=utf-8');
    }
}
