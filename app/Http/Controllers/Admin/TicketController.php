<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $n = Ticket::latest()->whereNull('parent_id');
        if ($request->has('filter')) {
            $n = $n->where('status', $request->filter);
        }
        $tickets = $n->paginate(10);
        return view('admin.ticket.ticketIndex', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $t = new Ticket();
        if ($request->has('title')){
            $t->title = $request->title;
        }
        $t->body = $request->body;

        $t->customer_id = $request->customer_id;
        $t->save();
        return redirect()->back()->with(['message' => __('Ticket has been sent')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
        $subTickets = $ticket->subTickets;
        return view('admin.ticket.ticketForm',compact('ticket','subTickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
        $ticket->answer = $request->answer;
        $ticket->status = $request->status;
        $ticket->save();
        if ($request->has('answers')){
            foreach ($request->answers as $id => $answer) {
                Ticket::whereId($id)->update(['answer' => $answer]);
            }
        }
        logAdmin(__METHOD__,Ticket::class,$ticket->id);
        return redirect()->route('admin.ticket.index')->with(['message' => __('Ticket answered successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Tickets deleted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Ticket::class,$request->input('id'));
                Ticket::destroy($request->input('id'));
                break;
            case 'PENDING':
            case 'CLOSED':
            case 'ANSWERED':
                $msg = __('Tickets status changed successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Ticket::class,$request->input('id'));
                Ticket::whereIn('id', $request->input('id'))->update(['status' => $request->input('bulk')]);
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.ticket.index')->with(['message' => $msg]);
    }
}
