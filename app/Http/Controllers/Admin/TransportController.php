<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransportSaveRequest;
use App\Models\Transport;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;
class TransportController extends Controller
{

    function createOrUpdate(Transport $transport,TransportSaveRequest $request){
        $transport->price = $request->price;
        $transport->title = $request->title;
        $transport->description = $request->description;
        if ($request->has('is_default')){
            Transport::where('is_default')->update([
                'is_default' =>  0,
            ]);
            $transport->is_default = 1;
        }
        $transport->save();
        return $transport;
    }
    /**
     * Display a listing of the resource.
     *z
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transports = Transport::paginate(10);
        return  view('admin.transport.transportIndex',compact('transports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.transport.transportForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransportSaveRequest $request)
    {
        $transport = new Transport();
        $transport = $this->createOrUpdate($transport, $request);
        logAdmin(__METHOD__, Transport::class, $transport->id);
        return redirect()->route('admin.transport.index')->with(['message' => __('Transport') . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transport $transport)
    {
        //
        return  $transport;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transport $transport)
    {
        //
        return view('admin.transport.transportForm',compact('transport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransportSaveRequest $request, Transport $transport)
    {
        //
        $transport = $this->createOrUpdate($transport, $request);
        logAdmin(__METHOD__, Transport::class, $transport->id);
        return redirect()->route('admin.transport.index')->with(['message' => __('Transport') . ' ' . __('updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transport $transport)
    {
        //
        logAdmin(__METHOD__, Transport::class, $transport->id);
        $transport->delete();
        return redirect()->route('admin.transport.index')->with(['message' => __('Transport') . ' ' . __('deleted successfully')]);
    }

    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('transports deleted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),TransportController::class,$request->input('id'));
                TransportController::destroy($request->input('id'));
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.customer.index')->with(['message' => $msg]);
    }
}
