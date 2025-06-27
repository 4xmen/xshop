<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $mainCategories = [
            __("Mobile"),
            __("Tablet"),
            __("Desktop"),
        ];

        $subCats = [
            1 => [
                __("Smart phone"),
                __("Basic phones"),
            ],
            3 => [
                __("PC"),
                __("Laptop"),
            ],
        ];

        // insert main categories
        foreach ($mainCategories as $category){
            $c = new Category();
            $c->name = $category;
            $c->slug = sluger($category);
            $c->save();
        }
        foreach ($subCats as $k => $categories){
            foreach ($categories as $category){
                $c = new Category();
                $c->name = $category;
                $c->slug = sluger($category);
                $c->parent_id = $k ;
                $c->save();
            }
        }
    }
}
