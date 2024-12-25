<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\Tag;

class TagController extends Controller
{
    //

    public function search($q)
    {

//        // Check if $q contains any non-Latin characters
//        if (preg_match('/[^\x20-\x7E]/', $q)) {
//            // If it contains non-Latin characters, encode it
//            $q =trim( json_encode($q),' "');
//        }

        // Perform the search
        $tags = \Spatie\Tags\Tag::where('name->' . config('app.locale'), 'like', '%' . $q . '%')->limit(10)->pluck('name');
        return ['OK' => true, 'data' => $tags];
    }
}
