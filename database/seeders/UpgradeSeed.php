<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Part;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpgradeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // v3.5.1 to up
        if (Area::where('name', 'page')->count() == 0) {
            Area::create([
                'name' => 'page',
                'valid_segments' => json_encode(
                    ["top", "header", "footer", "menu",
                        "parallax", "other", "page", "comments", "ads", "attachments"]
                ),
                'max' => 6,
                'preview' => null,
                'icon' => 'ri-file-settings-line',
            ]);

            $part = new Part();
            $part->segment = 'page';
            $part->part = 'SimplePage';
            $part->area_id = Area::where('name', 'page')->first()->id;
            $part->sort = 1;
            $part->save();
        }

    }
}
