<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $type = [
            'text' => '{"value":"'.$this->faker->word.'"}',
            'number' => '{"value":"'.$this->faker->numberBetween(0,99).'"}',
            'color' => '[{"title":"black","value":"#000000"},{"title":"white","value":"#ffffff"},{"title":"red","value":"#ff0000"}]' ,
            'checkbox' => "{}",
            'select'=>'[{"title":"item 1","value":"item1"},{"title":"item 2","value":"item2"},{"title":"item 3","value":"item3"}]' ,
            'multi'=>'[{"title":"item 1","value":"item1"},{"title":"item 2","value":"item2"},{"title":"item 3","value":"item3"}]' ,
            'singlemulti' => '[{"title":"item 1","value":"item1"},{"title":"item 2","value":"item2"},{"title":"item 3","value":"item3"}]' ,
        ];

        $temp = array_keys($type);
        shuffle($temp);
        $key= $temp[0];



        return [
            //
            'name'=>$this->faker->unique()->word,
            'label'=>$this->faker->word,
            'required' => rand(0,1),
            'searchable' => rand(0,1),
            'priceable' => rand(0,1),
            'type' => $key ,
            'options' => $type[$key],
        ];
    }
}
