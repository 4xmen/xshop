<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OrderCancelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders inactive';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $invs = Invoice::where('status','PENDING')
            ->where('created_at','<' , Carbon::now()->subMinutes(20))->get();
       foreach ($invs as $inv){
           $inv->status = Invoice::CANCELED;
           $inv->save();
       }
//        file_put_contents('teest','');
        return Command::SUCCESS;
    }
}
