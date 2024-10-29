<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class AssetsBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely run npm build process  ';

    /**
     * Store command output
     */
    private $commandOutput = '';

    /**
     * Get Laravel root path
     */
    private function getLaravelRoot()
    {
        return base_path();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Set working directory to Laravel root
            chdir($this->getLaravelRoot());

            // Check if npm is installed
            $npmVersion = new Process(['npm', '-v']);
            $npmVersion->setWorkingDirectory($this->getLaravelRoot());
            $npmVersion->run();

            if (!$npmVersion->isSuccessful()) {
                $this->addOutput('npm is not installed. Please install npm first.');
                return Command::FAILURE;
            }

            // Check if package.json exists
            if (!file_exists($this->getLaravelRoot() . '/package.json')) {
                $this->addOutput('package.json not found in ' . $this->getLaravelRoot());
                return Command::FAILURE;
            }


            // Check if node_modules exists
            if (!file_exists($this->getLaravelRoot() . '/node_modules')) {
                $this->addOutput('node_modules not found. Installing dependencies...');

                $installProcess = new Process(['npm', 'install']);
                $installProcess->setWorkingDirectory($this->getLaravelRoot());
                $installProcess->setTimeout(3600); // 1 hour timeout

                $installProcess->run(function ($type, $buffer) {
                    $this->addOutput($buffer);
                });

                if (!$installProcess->isSuccessful()) {
                    throw new ProcessFailedException($installProcess);
                }
            }

            // Run npm build
            $this->addOutput('Starting build process in: ' . $this->getLaravelRoot());

            $buildProcess = new Process(['./node_modules/.bin/vite', 'build']);
            $buildProcess->setWorkingDirectory($this->getLaravelRoot());
//            $this->addOutput($this->getLaravelRoot());

            $buildProcess->setTimeout(3600); // 1 hour timeout

            $buildProcess->run(function ($type, $buffer) {
                $this->addOutput($buffer);
            });

            if (!$buildProcess->isSuccessful()) {
                throw new ProcessFailedException($buildProcess);
            }

            $this->addOutput('Build completed successfully!');

            // Store output in cache for retrieval
            cache()->put('build_command_output', $this->commandOutput, now()->addMinutes(5));

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $errorMessage = 'Build process failed: ' . $e->getMessage();
            $this->addOutput($errorMessage);
            cache()->put('build_command_output', $this->commandOutput, now()->addMinutes(5));
            return Command::FAILURE;
        }
    }

    /**
     * Add output to both console and stored output
     */
    private function addOutput($output)
    {
        $this->commandOutput .= $output . PHP_EOL;
        $this->info($output); // This will only show in CLI
    }

    /**
     * Get the command output
     */
    public function getOutput()
    {
        return $this->commandOutput;
    }
}
