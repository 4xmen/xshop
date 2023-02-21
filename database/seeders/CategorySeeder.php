<?php

namespace Database\Seeders;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Xmen\StarterKit\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $items = [
            [
                'name' => 'درباره ما',
                'slug' => 'درباره-ما',
            ],
            [
                'name' => 'تماس با ما',
                'slug' => 'تماس-با-ما',
            ],
            [
                'name' => 'اخبار',
                'slug' => 'اخبار',
            ],
            [
                'name' => 'سوالات متداول',
                'slug' => 'سوالات-متداول',
            ],
            [
                'name' => 'مقالات',
                'slug' => 'مقالات',
            ],

        ];
        foreach ($items as $item){
            $c = new Category();
            $c->name = $item['name'];
            $c->slug = $item['slug'];
            $c->save();
        }

    }
}
