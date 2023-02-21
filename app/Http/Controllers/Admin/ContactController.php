<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cons = Contact::latest()->paginate(20);
        return view('admin.contact.contacts',compact('cons'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $con)
    {
        //
        return view('admin.contact.contact',compact('con'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $con)
    {
        //
        logAdmin(__METHOD__,Contact::class,$con->id);
        $con->delete();
        return redirect()->route('admin.contact.index');
    }

    public function reply(Contact $con, Request $request){
        $body = $request->bodya;

        Mail::raw($body, function ($message)  use ($con){

            $message->from(\App\Helpers\getSetting('email'),config('app.name'));
            $message->to($con->email);
            $message->subject('reply:',config('app.name', 'Laravel') .' پاسخ تماس با ');
        });
        logAdmin(__METHOD__,Contact::class,$con->id);

        return  redirect()->back()->with(['message' => __('Your Email sent')]);
    }
    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Tickets deleted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Ticket::class,$request->input('id'));
                Contact::destroy($request->input('id'));
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.ticket.index')->with(['message' => $msg]);
    }
}
