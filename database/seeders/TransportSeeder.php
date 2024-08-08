<?php

namespace Database\Seeders;

use App\Models\Transport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $t = new Transport();
        $t->title = __("Motor bike delivery");
        $t->description = "Transport just for Tehran orders (pay by customer)";
        $t->icon = 'ri-motorbike-line';
        $t->is_default = false;
        $t->price = 0;
        $t->save();

        $t = new Transport();
        $t->title = __("Post office delivery");
        $t->description = "Transport with post around country";
        $t->icon = 'ri-signpost-line';
        $t->is_default = true;
        $t->price = 30000;
        $t->save();
    }
}
