<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\SliderResource;
use App\Models\Adv;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $data['menu'] = Menu::with(['items' => function ($query) {
            $query->select(['id', 'title', 'menuable_id', 'menuable_type', 'kind', 'meta', 'parent', 'sort', 'user_id', 'menu_id']);
        }])->first(['id', 'name']);
        $data['slider'] = SliderResource::collection(Slider::take(6)->get());
        $data['categories'] = CategoryResource::collection(Category::with('products')->whereNull('parent_id')->orderBy('sort')->take(8)->get());
        $data['adv'] = AdvResource::collection(
            Adv::query()
                ->where('status', true)
                ->whereColumn('click', '<', 'max_click')
                ->get()
        );
        $data['post'] = PostResource::collection(Post::orderByDesc('created_at')->take(8)->get());
        return success($data);
    }
}
