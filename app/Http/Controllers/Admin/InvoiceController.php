<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebsiteController;
use App\Http\Requests\InvoiceSaveRequest;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Quantity;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createOrUpdate(Invoice $invoice, InvoiceSaveRequest $request)
    {
        $invoice->customer_id = $request->input('customer_id');
        $invoice->status = $request->input('status');
        $invoice->tracking_code = $request->input('tracking_code');
        if ($invoice->status == Invoice::CANCELED) {
//            $this->remQ([$invoice->id]);
        }
        $invoice->save();
        foreach ($request->products_ids as $k => $products_id) {
            $invoice->products[$k]->pivot->update(['count' => $request->products_counts[$k]]);
        }

        WebsiteController::resetStockStatus();
        WebsiteController::resetQuantity();
        return $invoice;
    }

    public function remQ($invoices)
    {
        foreach ($invoices as $id) {
            $inv = Invoice::whereId($id)->first();
            if ($inv->status != Invoice::CANCELED) {
                $pros = $inv->products()->withPivot(['quantity_id', 'count'])->get();
                foreach ($pros as $pr) {
                    $q = Quantity::whereId($pr->pivot->quantity_id)->first();
                    $q->count += $pr->pivot->count;
                    $q->save();
                    $q->product->stock_quantity += $pr->pivot->count;
                    $q->product->save();
                }
            }
        }
    }


    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Invoices deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Invoice::class, $request->input('id'));
                Invoice::destroy($request->input('id'));
                break;
            case 'PENDING':
            case 'PROCESSING':
            case 'COMPLETED':
            case 'CANCELED':
            case 'FAILED':
                $msg = __('Invoices status changed successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Invoice::class, $request->input('id'));
                Invoice::whereIn('id', $request->input('id'))->update(['status' => $request->input('bulk')]);
//                if ($request->input('bulk') == Invoice::CANCELED) {
//                    $this->remQ($request->input('id'));
//                }
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.invoice.index')->with(['message' => $msg]);
    }


    public function index(Request $request)
    {
        $n = Invoice::latest();
        if ($request->has('filter')) {
            $n = $n->where('status', $request->filter);
        }
        $invoices = $n->with('successPayments', 'payments')->paginate(20);
        return view('admin.invoice.invoiceIndex', compact('invoices'));
    }


    public function create()
    {
        return view('admin.invoice.invoiceForm');
    }


    public function store(InvoiceSaveRequest $request)
    {
        $invoice = new Invoice();
        $invoice = $this->createOrUpdate($invoice, $request);
        logAdmin(__METHOD__, Invoice::class, $invoice->id);
        return redirect()->route('admin.invoice.index')->with(['message' => __('invoice created successfully')]);
    }


    public function show(Invoice $invoice)
    {
        //
        return view('admin.invoice.invoiceShow', compact('invoice'));
    }


    public function edit(Invoice $invoice)
    {
        $invoice = $invoice->load('customer', 'products')->refresh();
        return view('admin.invoice.invoiceForm', compact('invoice'));

    }


    public function update(InvoiceSaveRequest $request, Invoice $invoice)
    {
        $this->createOrUpdate($invoice, $request);
        logAdmin(__METHOD__, Invoice::class, $invoice->id);
        return redirect()->route('admin.invoice.index')->with(['message' => __('Product invoice updated successfully')]);

    }


    public function destroy(Invoice $invoice)
    {
        logAdmin(__METHOD__, Invoice::class, $invoice->id);
        $invoice->delete();
        return redirect()->route('admin.invoice.index')->with(['message' => __('Product invoice deleted successfully')]);
    }
}
