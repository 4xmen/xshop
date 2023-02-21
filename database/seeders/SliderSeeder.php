<?php

use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $faker = Faker\Factory::create('fa_IR');
        if (!file_exists(storage_path('app/public/sliders'))){
            File::makeDirectory(storage_path('app/public/sliders'));
        }
        for ($i = 1; $i <3; $i++) {
            $c = new Xmen\StarterKit\Models\Slider();
            $t =  time().$i.$i;
            $c->image = $t.'.jpg';
            $c->user_id = rand(1,3);
            $c->body = $faker->realText(600);
            $j = rand(1,5);
            File::copy(__DIR__ . "/img/top.jpg",storage_path('app/public/sliders/'.$t.'.jpg'));
            $c->save();
        }

    }
}
