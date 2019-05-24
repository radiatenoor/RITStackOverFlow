<?php

namespace App\Http\Controllers\User;

use App\Answer;
use App\Comment;
use App\Rules\StripThenLength;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request,$id)
    {
        $this->validate($request,[
            'answer'=>['required',new StripThenLength(6)]
        ]);

        $answer = new Answer();
        $answer->question_id = $id;
        $answer->user_id =  Auth::user()->id;
        $answer->answer = $request->answer;
        $answer->save();

        Session::flash('success','You Have Successfully Saved Answer');
        return redirect()->back();
    }

    public function storeComment(Request $request,$answer_id){
        $this->validate($request,[
            'comment'=>'required|min:6'
        ]);

        $comment = new Comment();
        $comment->answer_id = $answer_id;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        Session::flash('success','You Have Successfully Saved the comment');
        return redirect()->back();
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
        $this->validate($request,[
            'answer'=>['required',new StripThenLength(6)]
        ]);

        $answer = Answer::find($id);
        $answer->answer = $request->answer;
        $answer->save();

        Session::flash('success','Successfully Updated The Answer');
        return redirect()->back();
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

    public function deleteComment($id){
       $comment = Comment::where('user_id',Auth::user()->id)
//           ->where('id',$id)->first()
           ->find($id);
       if ($comment){
           $comment->delete();
           return response()->json('success',201);
       }
       return response()->json('error',422);
    }

    public function answeredList(){
        return view('front.answer.list');
    }

    public function answeredDataTable(){
        $answers = Answer::where('user_id',Auth::id())
            ->with('question')
            ->get();
        $render_data_table = DataTables::of($answers)
            ->addColumn('hash',function ($row){
                return '<input type="checkbox" id="'.$row->id.'">';
            })
            ->addColumn('action',function ($row){
                $view_url = url('show/question/'.$row->question->id);
                return '<a href="'.$view_url.'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>'.
                    '<button onClick="deleteAnswer('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>';
            })
            ->editColumn('answer',function ($row){
                return strip_tags($row->answer);
            })
            ->rawColumns(['hash','action','answer'])
            ->make(true);

        return $render_data_table;
    }
}
