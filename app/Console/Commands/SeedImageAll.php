<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedImageAll extends Command
{


    public $models = ['Category', 'Group', 'Slider', 'Post', 'Product'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeding:all {directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        foreach ($this->models as $model) {
            // Call the seeder command
            $exitCode = \Artisan::call('seeding:image', ['directory' => $this->argument('directory'), 'model' => $model]);

            // Get the output
            $output = \Artisan::output();

            // Handle the exit code and output as needed
            if ($exitCode === 0) {
                $this->info( "Seeding was successful: [$model] \n");
            } else {
                $this->error("Seeding failed with exit code {$exitCode}:\n");
            }
            $this->info( $output);
        }
    }
}
