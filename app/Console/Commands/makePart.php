<?php

namespace App\Console\Commands;

use App\Models\Theme;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class makePart extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:part {part} {section}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make theme part';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $part = strtolower($this->argument('part'));
        $section = strtolower($this->argument('section'));

        // make detail
        $detail = [
            'name' => $part,
            'version' => '1.0',
            'author' => 'xStack',
            'email' => 'xshop@xstack.ir',
            'license' => 'GPL-3.0-or-later',
            'url' => 'https://xstack.ir',
            'author_url' => 'https://4xmen.ir',
            'packages' => [],
        ];
        // check section
        if (!in_array($section, Theme::$sections)) {
             $this->error(__('Invalid theme section'));
             return  -1;
        }


        $folderPath = resource_path() . '/views/segments/' . $section . '/' . $part;


        // check is exists
        if (File::exists($folderPath)) {
             $this->warn(__('Command ignored, segment part exists!'));
            return -1;
        }

        // create folder
        File::makeDirectory($folderPath, 0755, true);
        File::makeDirectory($folderPath.'/assets', 0755, true);

        $this->info('Directory created as: /theme/' . $section . '/' . $part);

        $handler = file_get_contents(__DIR__.'/data/handle.dat');

        $handler = str_replace('Handle',ucfirst($part), $handler);
        $scss = <<<DOC
#$part {
    // scss
}
DOC;

        file_put_contents($folderPath . '/' . $part . '.blade.php', "<div id='{$part}'></div>");
        file_put_contents($folderPath . '/' . $part . '.js', '');
        file_put_contents($folderPath . '/' . $part . '.json', json_encode($detail,JSON_PRETTY_PRINT));
        file_put_contents($folderPath . '/' . ucfirst($part) . '.php', $handler);
        file_put_contents($folderPath . '/' . $part . '.scss', $scss);
        File::copy(__DIR__.'/data/screen.png',$folderPath .'/screenshot.png');


        $this->info(__("Theme part created successfully: [blade, js, json, scss, php, assets, screenshot]"));
        return  0;

    }


}
