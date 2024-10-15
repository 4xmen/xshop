<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $areas = [
            [
                'name' => 'preloader',
                'valid_segments' => json_encode(
                    ["preloader"]
                ),
                'max' => 1,
                'preview' => null,
                'icon' => 'ri-loader-2-line',
            ],
            [
                'name' => 'floats',
                'valid_segments' => json_encode(
                    ["floats"]
                ),
                'max' => 2,
                'preview' => null,
                'icon' => 'ri-ai-generate',
            ],
            [
                'name' => 'defaultHeader',
                'valid_segments' => json_encode(
                    ["top", "header", "other", "ads", "menu"]
                ),
                'max' => 2,
                'preview' => null,
                'icon' => 'ri-window-line',
                'sort' => 99
            ],
            [
                'name' => 'defaultFooter',
                'valid_segments' => json_encode(
                    ["footer", "other", "ads", "groups"]
                ),
                'max' => 2,
                'preview' => null,
                'icon' => 'ri-window-line rotate-180',
                'sort' => 98
            ],
            [
                'name' => 'index',
                'valid_segments' => json_encode(
                    ["top", "slider", "header", "footer", "menu",
                        "parallax", "other", "posts", "products"
                        , "groups", "categories", "index", "ads", "galleries", "clips"]
                ),
                'max' => 10,
                'preview' => 'client.welcome',
                'icon' => 'ri-home-smile-line',
                'sort' => 97
            ],
            [
                'name' => 'post',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "post", "comments", "ads", "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-file-text-line',
            ],
            [
                'name' => 'posts-list',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "posts_page", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.posts',
                'icon' => 'ri-archive-stack-line',
            ],
            [
                'name' => 'clip',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "clip", "comments", "ads", "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-video-line',
            ],
            [
                'name' => 'clips-list',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "clips_page", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.clips',
                'icon' => 'ri-movie-2-line',
            ],
            [
                'name' => 'gallery',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "gallery", "comments", "ads", "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-image-line',
            ],
            [
                'name' => 'galleries-list',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "galleries_page", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.galleries',
                'icon' => 'ri-folder-image-line',
            ],
            [
                'name' => 'product',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "product", "comments", "ads", "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-vip-diamond-line',
            ],
            [
                'name' => 'products-list',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "products_page", "ads", "products"]
                ),
                'max' => 6,
                'preview' => 'client.products',
                'icon' => 'ri-function-line',
            ],
            [
                'name' => 'attachment',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "attachment", "comments", "ads"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-attachment-line',
            ],
            [
                'name' => 'attachments-list',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "attachments_page", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.attachments',
                'icon' => 'ri-attachment-2',
            ],
            [
                'name' => 'category',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "category", "ads", "products_page", "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-book-3-line',
            ],
//            [
//                'name' => 'categories-list',
//                'valid_segments' => json_encode(
//                    ["top", "header", "footer", "menu",
//                        "parallax", "other", "categories_page", "ads"]
//                ),
//                'max' => 6,
//                'preview' => 'client.categories',
//                'icon' => 'ri-file-copy-2-line',
//            ],
            [
                'name' => 'group',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "group", "ads", 'posts_page', "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-book-shelf-line',
            ],
//            [
//                'name' => 'groups-list',
//                'valid_segments' => json_encode(
//                    ["top", "header", "footer", "menu",
//                        "parallax", "other", "groups_page", "ads"]
//                ),
//                'max' => 6,
//                'preview' => 'client.groups',
//                'icon' => 'ri-book-shelf-line',
//            ],
            [
                'name' => 'card',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "card", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.card',
                'icon' => 'ri-shopping-cart-2-line',
            ],
            [
                'name' => 'login',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "login", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.sign-in',
                'icon' => 'ri-login-circle-line',
            ],
            [
                'name' => 'register',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "register", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.sign-up',
                'icon' => 'ri-user-add-line',
            ],
            [
                'name' => 'customer',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "customer", "ads"]
                ),
                'max' => 6,
                'preview' => 'client.profile',
                'icon' => 'ri-profile-line',
            ],
            [
                'name' => 'invoice',
                'valid_segments' => json_encode(
                    ["invoice", "other"]
                ),
                'max' => 3,
                'preview' => null,
                'icon' => 'ri-list-check-3',
            ],
            [
                'name' => 'compare',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "compare", "ads"]
                ),
                'max' => 4,
                'preview' => null,
                'icon' => 'ri-scales-3-line',
            ],
            [
                'name' => 'contact-us',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "contact", "ads", "index"]
                ),
                'max' => 4,
                'preview' => null,
                'icon' => 'ri-mail-open-line',
            ],
            [
                'name' => 'product-grid',
                'valid_segments' => json_encode(
                    ["product_grid"]
                ),
                'max' => 1,
                'preview' => null,
                'icon' => 'ri-layout-grid-line',
            ],
        ];

        foreach ($areas as $area) {
            $a = new Area();
            $a->name = $area['name'];
            $a->max = $area['max'];
            $a->sort = $area['sort']??0;
            $a->valid_segments = $area['valid_segments'];
            $a->icon = $area['icon'];
            $a->preview = $area['preview'];
            if ($area['name'] == 'index') {
                $a->use_default = false;
            }
            $a->save();
        }
    }
}
