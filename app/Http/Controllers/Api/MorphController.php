<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clip;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class MorphController extends Controller
{

    public  $limit = 5;
    //
    public function search(Request $request)
    {

        if (auth()->check() ){
            return abort(403);
        }
        $morph = $request->input('morph', Product::class);

        $q = '%' . $request->input('q') . '%';
        switch ($morph) {
            case Product::class:
                $q = Product::where('name', 'LIKE', $q)
                    ->orWhere('description', 'LIKE', $q);
                break;
            case Post::class:
                $q = Post::where('title', 'LIKE', $q)
                    ->orWhere('subtitle', 'LIKE', $q)
                    ->orWhere('body', 'LIKE', $q);
                break;
            case Group::class:
                $q = Group::where('name', 'LIKE', $q)
                    ->orWhere('subtitle', 'LIKE', $q)
                    ->orWhere('description', 'LIKE', $q);
                break;
            case Category::class:
                $q = Category::where('name', 'LIKE', $q)
                    ->orWhere('subtitle', 'LIKE', $q)
                    ->orWhere('description', 'LIKE', $q);
                break;
            case Clip::class:
                $q = Clip::where('title', 'LIKE', $q)
                    ->orWhere('body', 'LIKE', $q);
                break;
            case Gallery::class:
                $q = Gallery::where('title', 'LIKE', $q)
                    ->orWhere('description', 'LIKE', $q);
                break;
            default:
                return ['OK' => false, 'error' => __("Invalid morph")];
        }

        return ['OK' => true, 'data' => $q->orderByDesc('updated_at')->limit($this->limit)->get()];
    }
}
