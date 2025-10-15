<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    //

    public function index(){
        return view('admin.reports.index');
    }


    public function salesReport(Request $request) {
        $period = $request->input('period', 'daily'); // 'daily' or 'monthly'

        $query = Invoice::query()
            ->whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED']) // Only successful orders
            ->with('orders'); // Eager load to avoid extra queries

        // Apply filters if wee need

        $limit = $request->input('limit', 50);

        $grouped = $query->select(
            DB::raw($period === 'daily' ? 'DATE(created_at) as date' : "MONTH(created_at) as month, YEAR(created_at) as year, CONCAT(YEAR(created_at), '-', LPAD(MONTH(created_at), 2, '0')) AS date"),
            DB::raw('SUM(total_price - COALESCE(credit_price, 0)) as revenue'), // Net revenue without transport
            DB::raw('COUNT(id) as order_count'),
            DB::raw('AVG(total_price) as avg_basket_value')
        )
            ->groupBy($period === 'daily' ? 'date' : ['month', 'year','date'])
            ->orderBy('date', 'desc'); // Or month/year

        $grouped->limit($limit);
        $data = $grouped->get();



        // For comparison with previous periods, run a separate query if needed
//        return $data;

        return view('admin.reports.period', compact('data'));
    }


    public function topProductsReport(Request $request) {

        $query = Order::query()
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->whereHas('invoice', function($q) {
                $q->whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED']); // Only successful orders
            });

        // Apply filters if wee need
        $limit = $request->input('limit', 10);
        if ($request->has('start_date')) {
            $query->whereDate('orders.created_at', '>=', date('Y-m-d', ($request->input('start_date'))));
        }else{
            $query->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime('-30 days') ));
        }
        if ($request->has('end_date')) {
            $query->whereDate('orders.created_at', '<=', date('Y-m-d', ($request->input('end_date'))));
        }else{
            $query->whereDate('orders.created_at', '<=', date('Y-m-d' ));
        }


        $grouped = $query->select(
            'products.id',
            'products.name',
            DB::raw('SUM(orders.count) as total_sold'),
            DB::raw('SUM(orders.price_total) as total_revenue'),
            DB::raw('AVG(( orders.price_total /  orders.count) - products.buy_price) as avg_margin') // Average profit margin
        )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit($limit);

        $data = $grouped->get();

        return view('admin.reports.top-products', compact('data'));
    }


    public function customerBehaviorReport(Request $request)
    {
        // Base query for customers with aggregated invoice data
        $query = Customer::query()
            ->withCount([
                // Count only invoices that are paid, processing or completed
                'invoices as total_purchases' => fn ($q) => $q->whereIn(
                    'status',
                    ['PAID', 'PROCESSING', 'COMPLETED']
                ),
            ])
            ->with([
                // Load per‑customer invoice statistics:
                //   avg_spend – average total_price
                //   peak_hour – hour of day when the invoice was created
                'invoices' => fn ($q) => $q->select(
                    'customer_id',
                    DB::raw('AVG(total_price) as avg_spend'),
                    DB::raw('HOUR(created_at) as peak_hour')
                )->groupBy('customer_id', 'peak_hour')
            ]);



        // apply filters we need
        // Date range filters (applied to related invoices)
        $start = $request->has('start_date')
            ? date('Y-m-d', $request->input('start_date'))
            : date('Y-m-d', strtotime('-30 days'));

        $end = $request->has('end_date')
            ? date('Y-m-d', $request->input('end_date'))
            : date('Y-m-d');

        // name filter
        if ($request->filled('q')){
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('q') . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $request->input('q') . '%');
            });
        }
        // Restrict invoices to the selected date window
        $query->whereHas('invoices', function ($q) use ($start, $end) {
            $q->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        });

        // Apply a common limit to the customer result set
        $limit = $request->input('limit', 10);
        $query->limit($limit);

        // Select final fields for each customer
        $customers = $query->select(
            'id',
            'name',
            'email',
            // Simple segmentation based on total purchases
            DB::raw('CASE
            WHEN total_purchases > 5 THEN "loyal"
            WHEN total_purchases = 1 THEN "new"
            WHEN total_purchases = 0 THEN "new"
            ELSE "regular"
        END as segment'),
            // Use the already‑calculated total_purchases as a proxy for return rate
            DB::raw('total_purchases as return_rate')
        )->get();


        // Overall peak purchase times (same date window)
        $peakTimes = Invoice::query()
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as count')
            )
            ->whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED'])
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

//        return [$peakTimes,$customers];

        // Return combined data
        return view('admin.reports.customer-behavior',compact('customers', 'peakTimes'));
    }

    public function basketReport(Request $request)
    {
        // Base query: only successful invoices
        $query = Order::query()
            ->join('invoices', 'orders.invoice_id', '=', 'invoices.id')
            ->whereIn('invoices.status', ['PAID', 'PROCESSING', 'COMPLETED']);

        // Optional date range filter
        // Apply filters if wee need
        $limit = $request->input('limit', 10);
        if ($request->has('start_date')) {
            $query->whereDate('orders.created_at', '>=', date('Y-m-d', ($request->input('start_date'))));
        }else{
            $query->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime('-30 days') ));
        }
        if ($request->has('end_date')) {
            $query->whereDate('orders.created_at', '<=', date('Y-m-d', ($request->input('end_date'))));
        }else{
            $query->whereDate('orders.created_at', '<=', date('Y-m-d' ));
        }

        // Gather product IDs per invoice
        $invoiceProducts = $query
            ->select('orders.invoice_id', 'orders.product_id')
            ->orderBy('orders.invoice_id')
            ->get()
            ->groupBy('invoice_id')
            ->map(fn ($group) => $group->pluck('product_id')->unique()->values()->all());

        // Count unordered product pairs (n‑choose‑2)
        $pairCounts = [];

        foreach ($invoiceProducts as $productIds) {
            $cnt = count($productIds);
            if ($cnt < 2) {
                continue;
            }

            for ($i = 0; $i < $cnt - 1; $i++) {
                for ($j = $i + 1; $j < $cnt; $j++) {
                    $key = $productIds[$i] . '_' . $productIds[$j];
                    $pairCounts[$key] = ($pairCounts[$key] ?? 0) + 1;
                }
            }
        }

        // Transform to collection, sort, and keep top 20
        $pairs = collect($pairCounts)
            ->map(fn ($freq, $key) => [
                'product1' => explode('_', $key)[0],
                'product2' => explode('_', $key)[1],
                'frequency' => $freq,
            ])
            ->sortByDesc('frequency')
            ->take($limit);

        // Pre‑load product names to avoid N+1 queries
        $productIds = $pairs->pluck('product1')
            ->merge($pairs->pluck('product2'))
            ->unique();

        $products = Product::whereIn('id', $productIds)
            ->pluck('name', 'id'); // id => name

        // Build final result set
        $data = $pairs->map(function ($item) use ($products) {
            return [
                'product1' => $products[$item['product1']] ?? 'Unknown',
                'product2' => $products[$item['product2']] ?? 'Unknown',
                'frequency' => $item['frequency'],
            ];
        });

//        return  $data;
        return view('admin.reports.basket', compact('data'));
    }


    public function inventoryReport(Request $request) {

        $query = Product::query()
            ->with('quantities'); // Eager load

        // Apply filters if wee need
        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . $request->input('q') . '%');
        }
        $limit = $request->input('limit', 10);
        $lowThreshold = $request->input('low_threshold', 10);

        $data = $query->select('id', 'name', 'stock_quantity')
            ->where('stock_quantity','>' , 0)
            ->where('stock_quantity','<' , $lowThreshold)
            ->orderBy('stock_quantity')->limit($limit)->get();

        return view('admin.reports.inventory', compact('data'));
    }


    public function returnsReport(Request $request) {
        $query = Invoice::query()
            ->where('status', 'CANCELED'); // For returns or cancellations

        // Apply filters if wee need

        // Date range filters (applied to related invoices)
        $start = $request->has('start_date')
            ? date('Y-m-d', $request->input('start_date'))
            : date('Y-m-d', strtotime('-30 days'));

        $end = $request->has('end_date')
            ? date('Y-m-d', $request->input('end_date'))
            : date('Y-m-d');
        $limit = $request->input('limit', 30);

        $query->whereDate('created_at', '>=', $start);
        $query->whereDate('created_at', '<=', $end);

        $data = $query->select(
            DB::raw('COUNT(id) as return_count'),
            DB::raw('SUM(total_price) as return_value'),
            DB::raw('AVG(total_price) as avg_return'),
            'desc as common_reasons' // Or parse meta for reasons
        )
            ->groupBy('desc') // If reasons are repeated
             ->limit($limit)
            ->get();

        // Impact on revenue: compare with total sales
        $totalRevenue = Invoice::whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED'])->sum('total_price');
        $impact = $data->sum('return_value') / ($totalRevenue ?: 1) * 100;

        return view('admin.reports.returns', compact('data', 'totalRevenue', 'impact'));
    }



    public function financialReport(Request $request) {
        $query = Invoice::query()
            ->whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED']);

        // Apply filters if wee need
        // Date range filters (applied to related invoices)
        $start = $request->has('start_date')
            ? date('Y-m-d', $request->input('start_date'))
            : date('Y-m-d',  strtotime('first day of January this year'));

        $end = $request->has('end_date')
            ? date('Y-m-d', $request->input('end_date'))
            : date('Y-m-d');
        $limit = $request->input('limit', 30);

        // Gross revenue
        $grossRevenue = $query->sum('total_price');

        // Costs: credit + buy_price of sold products
        $creditCosts = $query->sum('credit_price');
        $buyCosts = Order::query()
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->whereHas('invoice', function($q) {
                $q->whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED']);
            })
            ->sum(DB::raw('orders.count * products.buy_price'));

        $netProfit = $grossRevenue - $creditCosts - $buyCosts;

        // Debts: pending amounts
        $debts = Invoice::where('status', 'PENDING')->sum('total_price');

        $data =  [
            'gross_revenue' => $grossRevenue,
            'costs' => $creditCosts + $buyCosts,
            'net_profit' => $netProfit,
            'debts' => $debts
        ];

        return view('admin.reports.financial',compact('data'));
    }

    public function forecastReport(Request $request) {
        $monthsAhead = $request->input('monthsAhead', 3);

        $query = Invoice::query()
            ->whereIn('status', ['PAID', 'PROCESSING', 'COMPLETED']);

        // Apply filters if wee need

        $historical = $query->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as monthly_revenue')
        )->groupBy('month')->get();

        $avgMonthly = $historical->avg('monthly_revenue');
        $data = collect(range(1, $monthsAhead))->map(function($i) use ($avgMonthly) {
            return ['month' => now()->addMonths($i)->format('Y-m'), 'predicted' => $avgMonthly * (1 + rand(-10,10)/100)]; // Simple with variance
        });


        return view('admin.reports.forecast',compact('data'));
    }

}
