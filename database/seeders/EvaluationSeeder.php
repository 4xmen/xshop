<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Evaluation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $e = new Evaluation();
        $e->title = __('Quality');
        $e->save();


        $e = new Evaluation();
        $e->title = __('Packing');
        $e->evaluationable_type = Category::class;
        $e->evaluationable_id = 1;
        $e->save();
    }
}
