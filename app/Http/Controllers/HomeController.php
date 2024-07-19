<?php

namespace App\Http\Controllers;

use App\Helpers\TDate;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        // make visit date
        $visits = Visitor::where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "count"'),
                DB::raw('SUM(visit) as "visits"'),
            ])->toArray();
        $dates = range((count($visits) - 1) * -1, 0);
        $dt = new TDate();
        array_walk($dates, function (&$item, $key) use ($dt) {
            $x = strtotime($item . ' days');
            if (config('app.locale') == 'fa') {
                $item = $dt->PDate('Y/m/d', $x);
            } else {
                $item = date('Y-m-d', $x);
            }
        });



        // make device data
        $mobiles_count = Visitor::where('created_at', '>=', Carbon::now()->subMonth())->where('is_mobile',1)->count();
        $all_visitor = Visitor::where('created_at', '>=', Carbon::now()->subMonth())->count();


        // make order data

        $invoices = Invoice::where('created_at', '>=', Carbon::now()->subWeek())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "count"'),
            ))->pluck('count')->toArray();
        $orders = Order::where('created_at', '>=', Carbon::now()->subWeek())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(count) as "count"'),
            ))->pluck('count')->toArray();

        $week = range((count($invoices) - 1) * -1, 0);

        array_walk($week, function (&$item, $key) use ($dt) {
            $x = strtotime($item . ' days');
            if (config('app.locale') == 'fa') {
                $item = $dt->PDate('Y/m/d', $x);
            } else {
                $item = date('Y-m-d', $x);
            }
        });


        return view('home',compact('dates', 'visits',
            'all_visitor','mobiles_count','week','invoices','orders'));
    }
}
