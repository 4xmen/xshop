<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $qs = Question::orderBy('status')->orderBy('id','desc')->paginate(15);
        return view('admin.question',compact('qs'));
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
    public function update(Request $request, Question $question)
    {
        //
        $question->answer = $request->answer;
        if (strlen($request->answer) > 2){
            $question->status = 1;
        }
        $question->save();
        logAdmin(__METHOD__, Question::class, $question->id);
        return redirect()->route('admin.question.index')->with(['message' => __('Question') . ' ' . __('updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        logAdmin(__METHOD__,Question::class,$question->id);
        $question->delete();
        return redirect()->route('admin.question.index')->with(['message' => __('Question') . ' ' . __('deleted successfully')]);
    }
}
