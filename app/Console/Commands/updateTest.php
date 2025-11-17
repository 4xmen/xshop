<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updateTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update dashboard test file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $functions = '';
        foreach (\Route::getRoutes() as $route) {
            $name = explode('.',$route->getName());
            if ($name[0] == 'admin' && isset($name[2]) && ($name[2] == 'index' || $name[2] == 'create')) {

                $r = '"'.$route->getName().'"';
                $functions .= <<<FNC

    public function test_$name[1]_$name[2](): void
    {
        \$admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        \$response = \$this->actingAs(\$admin)->get(route($r));
        \$response->assertStatus(200);
    }

FNC;

            }
        }
        $fileContent = '<?php'.<<<DOC

use Tests\TestCase;

class DashboardTest extends TestCase
{
    $functions
}

DOC;

     file_put_contents(base_path('tests/Unit/DashboardTest.php'), $fileContent);
    }

}
