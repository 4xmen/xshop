<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class makeXcontroller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:xcontroller {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create new xContoller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $model = ucfirst($this->argument('model'));
        $var = '$' . strtolower($this->argument('model'));


        if (!file_exists(__DIR__.'/../../Models/'.$model.'.php')){
            $this->error("Model not found!");
            return ;
        }

        $content = file_get_contents(__DIR__ . '/xcontroller.dat');

        $content = str_replace('User', $model, $content);
        $content = str_replace('$user', $var, $content);

        Artisan::call('make:request', ['name' => $model.'SaveRequest']);
        Artisan::call('make:controller', ['name' => 'Admin/' . $model . 'Controller']);


        $model_content = file_get_contents(__DIR__.'/../../Models/'.$model.'.php');

        if (!strpos($model_content,'SoftDeletes')){
            $pattern = '/\/\*\*restore\*\/(.*?)\/\*restore\*\*\//s';
            $replacement = '';
            $content = preg_replace($pattern, $replacement, $content);
        }
        file_put_contents(__DIR__.'/../../Http/Controllers/Admin/' . $model . 'Controller.php',$content);
        $this->info('Admin/' . $model . 'Controller created');
        $this->info( $model.'SaveRequest created');


    }
}
