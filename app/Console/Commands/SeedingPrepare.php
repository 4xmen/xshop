<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SeedingPrepare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeding:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and unpack zip file for seeding.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // URL of the zip file
        $zipUrl = 'https://github.com/A1Gard/xshop-installer-assets/raw/master/seeder-image.zip';
        $localZipPath =__DIR__.'/../../../database/seeders/images/seeder-image.zip'; // Path where the zip will be saved
        $extractPath = __DIR__.'/../../../database/seeders/images'; // Directory where the zip will be extracted

        // Downloading the ZIP file
        $this->info('Downloading ZIP file...');
        $zipContent = file_get_contents($zipUrl);
        file_put_contents($localZipPath, $zipContent);

        // Check if the ZIP file was successfully downloaded
        if (!file_exists($localZipPath)) {
            $this->error('Failed to download the ZIP file.');
            return;
        }

        // Unzipping the file
        $this->info('Unzipping the file...');
        $zip = new \ZipArchive();
        if ($zip->open($localZipPath) === TRUE) {
            // Create the extraction directory if it doesn't exist
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            // Extract the ZIP file to the specified directory
            $zip->extractTo($extractPath);
            $zip->close();
            $this->info('File unzipped successfully.');
        } else {
            $this->error('Failed to unzip the file.');
        }

        // Optionally, delete the zip file after extraction
         unlink($localZipPath);
    }
}
