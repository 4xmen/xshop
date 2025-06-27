<?php

namespace Database\Seeders;

use App\Models\Creator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $creators = [
            __("Apple"),
            __("HP (Hewlett-Packard)"),
            __("Nokia"),
            __("Samsung"),
            __("Sony"),
        ];

        foreach ($creators as $creator){
            $c = new Creator();
            $c->name = $creator;
            $c->slug = sluger($creator);
            $c->save();
        }
    }
}
