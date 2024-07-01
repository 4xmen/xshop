<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
    protected $description = 'create new xController';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $model = ucfirst($this->argument('model'));
        $var = '$' . strtolower($this->argument('model'));

        $plural = Str::plural($model);

        // check model exists
        if (!file_exists(__DIR__.'/../../Models/'.$model.'.php')){
            $this->error("Model not found!");
            return ;
        }

        // get controller content
        $content = file_get_contents(__DIR__ . '/data/xcontroller.dat');

        // replace variables
        $content = str_replace('User', $model, $content);
        $content = str_replace('users', strtolower($plural), $content);
        $content = str_replace('user', strtolower($model), $content);
        $content = str_replace('$user', $var, $content);

        Artisan::call('make:request', ['name' => $model.'SaveRequest']);
        Artisan::call('make:controller', ['name' => 'Admin/' . $model . 'Controller']);


        $model_content = file_get_contents(__DIR__.'/../../Models/'.$model.'.php');

        // check soft delete for restore
        if (!strpos($model_content,'SoftDeletes')){
            $pattern = '/\/\*\*restore\*\/(.*?)\/\*restore\*\*\//s';
            $replacement = '';
            $content = preg_replace($pattern, $replacement, $content);
        }
        file_put_contents(__DIR__.'/../../Http/Controllers/Admin/' . $model . 'Controller.php',$content);
        $this->info('Admin/' . $model . 'Controller created');
        $this->info( $model.'SaveRequest created');

        $folderPath = resource_path('views/admin/'.strtolower($plural));

        // create view folder
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath);
            $this->info('Folder created successfully.');
        } else {
            $this->info('Folder already exists.');
        }

        // make list blade
        $model = strtolower($model);
        $content = file_get_contents(__DIR__ . '/data/listblade.dat');
        $content = str_replace('Users',$plural,$content);
        file_put_contents($folderPath.'/'.$model.'-list.blade.php',$content);
        $this->info($model.'-list.blade.php created');

        // make form blade
        $content = file_get_contents(__DIR__ . '/data/formblade.dat');
        $content = str_replace('Users',$plural,$content);
        $content = str_replace('user',strtolower($model),$content);
        file_put_contents($folderPath.'/'.$model.'-form.blade.php',$content);
        $this->info($model.'-form.blade.php created');


    }
}
