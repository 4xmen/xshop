<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $g1 = new Group();
        $g1->name = __("News");
        $g1->slug = 'news';
        $g1->subtitle = __("All news about your e-commerce will be provided.");
        $g1->save();

        $g2 = new Group();
        $g2->name = __("Articles");
        $g2->subtitle = __("All articles about your e-commerce will be provided.");
        $g2->slug = 'articles';
        $g2->save();

        $g3 = new Group();
        $g3->name = __("About us");
        $g3->slug = 'about-us';
        $g3->save();
    }
}
