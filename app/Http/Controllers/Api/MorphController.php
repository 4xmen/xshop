<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clip;
use App\Models\Creator;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;


class MorphController extends Controller
{

    public  $limit = 5;
    //
    public function search(Request $request)
    {
        abort_unless(auth()->check(), 403);

        $morph = $request->input('morph', Product::class);
        $term  = mb_strtolower((string) $request->input('q', ''));
        $term  = addcslashes($term, '\%_');
        $like  = "%{$term}%";

        $locale = app()->getLocale();

        $searchableColumns = [
            Product::class  => ['name', 'description'],
            Post::class     => ['title', 'subtitle', 'body'],
            Page::class     => ['title', 'subtitle', 'body'],
            Group::class    => ['name', 'subtitle', 'description'],
            Category::class => ['name', 'subtitle', 'description'],
            Creator::class  => ["name->{$locale}", 'subtitle', 'description'],
            Clip::class     => ['title', 'body'],
            Gallery::class  => ['title', 'description'],
        ];

        if (! isset($searchableColumns[$morph])) {
            return ['OK' => false, 'error' => __('Invalid morph')];
        }

        $query = $morph::query()->where(function ($builder) use ($searchableColumns, $morph, $like) {
            $grammar = $builder->getGrammar();

            foreach ($searchableColumns[$morph] as $column) {
                // wrap() بر اساس driver، ستون یا مسیر JSON رو درست می‌سازه
                $wrapped = $grammar->wrap($column);
                $builder->orWhereRaw("LOWER({$wrapped}) LIKE ?", [$like]);
            }
        });

        return [
            'OK'   => true,
            'data' => $query->orderByDesc('updated_at')->limit($this->limit)->get(),
        ];
    }
}
