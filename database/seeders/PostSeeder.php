<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Post::factory(55)->create();

        foreach (Post::inRandomOrder()->limit(10)->get() as $post) {
            $post->groups()->sync(Group::all()->pluck('id')->toArray());
        }
    }
}
