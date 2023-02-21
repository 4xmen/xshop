<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $attaches = Attachment::orderBy('id','desc')->paginate(30);
        return view('admin.attachment',compact('attaches'));
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
        \Validator::make($request->all(),[
            'title' => ['required','string','min:3'],
            'file' => ['required','mimes:pdf','max:10000']
        ]);
        $a = new Attachment();
        $a->title = $request->title;
        $f = $request->file('file');
        $fname = date('Y-m-d').'.pdf';
        $f->storePubliclyAs('public/pdf/',$fname);
        $a->file = '/storage/pdf/' . $fname ;
        $a->save();
        logAdmin(__METHOD__,Attachment::class,$a->id);
        return redirect()->back()->with(['message' => __("Attached")]);
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
    public function destroy(Attachment $attachment)
    {
        //
        logAdmin(__METHOD__,Attachment::class,$attachment->id);

        $x = explode('/',$attachment->file);
        \Storage::disk('local')->delete('public/pdf',$x[count($x)-1] );
        $attachment->delete();
        return redirect()->back()->with(['message' => __("Attachment removed")]);
    }
}
