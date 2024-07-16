<?php

namespace App\Http\Controllers;

use App\Helpers\TDate;
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

        $visits = Visitor::where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "count"'),
                DB::raw('SUM(visit) as "visits"'),
            ))->toArray();
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

        $mobiles_count = Visitor::where('created_at', '>=', Carbon::now()->subMonth())->where('is_mobile',1)->count();
        $all_visitor = Visitor::where('created_at', '>=', Carbon::now()->subMonth())->count();
        return view('home',compact('dates','visits','all_visitor','mobiles_count'));
    }
}
