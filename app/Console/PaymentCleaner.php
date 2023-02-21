<?php

namespace App\Console;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Console\Command;

class PaymentCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Old and Failed Payments';

    public function handle()
    {
        $date =now()->subDays(7)->endOfDay()->toDateTimeString();
        Payment::whereType('ONLINE')->whereStatus('PENDING')->where('created_at','<',$date)->delete();
        Payment::whereType('ONLINE')->whereStatus(Payment::FAIL)->where('created_at','<',$date)->delete();
        Payment::whereType('ONLINE')->whereStatus(Payment::CANCEL)->where('created_at','<',$date)->delete();
        Invoice::whereStatus(Invoice::FAILED)->where('created_at','<',$date)->delete();
        Invoice::whereStatus(Invoice::CANCELED)->where('created_at','<',$date)->delete();
        Invoice::whereStatus(Invoice::PENDING)->where('created_at','<',now()->subDays(14)->endOfDay()->toDateTimeString())->delete();
        $this->info('Old Invoice|Payment with Fail Status Cleaned.');
    }

}
