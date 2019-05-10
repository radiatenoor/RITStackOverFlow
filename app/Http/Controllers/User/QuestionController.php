<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Question;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Question::where('user_id',Auth::user()->id)->get();
        return view('front.question.list-datatable',compact('question'));
    }

    public function rawTable()
    {
        $customData=[];
        $question = Question::where('user_id',Auth::user()->id)->get();
        // foreach to customise the data
        /*foreach ($question as $qst){
            $customData[] = [
                'qst_id'=>$qst->id,
                'quest_title'=>$qst->title,
                'category_name'=>$qst->category->name,
                'quest_tags'=>$qst->tags,
                'quest_status'=>$qst->status,
                'date'=>$qst->created_at,
                'help'=>'help me'
            ];
        }*/ // end customisation
        return view('front.question.list',compact('question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $tags = Tag::all();
        return view('front.question.new')
            ->with('categories',$category)
            ->with('tags',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1. validation
        $this->validate($request,[
            'title'=>'required|min:6',
            'category'=>'required',
            'tag'=>'required|array|min:1',
            'description'=>'required|min:10'
        ]);
        // 2. data insert
        $quest = new Question();
        $quest->title = $request->title;
        $quest->category_id = $request->category;
        $quest->user_id = Auth::user()->id;
        $quest->description = $request->description;
        $quest->status = 1;
        $quest->save();

        // data insert in many to many relationship/link table
        $quest->tags()->attach($request->tag);

        //message
        Session::flash('success','Succesfully Data Saved');
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
        //
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

    public function questionData(){
        $customData=[];
        $question = Question::where('user_id',Auth::user()->id)
            ->with('tags')
            ->orderBy('id','DESC')
            ->get();
        foreach($question as $row){
            $tags=[];
            foreach($row->tags as $tag){
                $tags[] =  $tag->name;
            }
            $customData[] = [
                'id'=>$row->id,
                'title'=>$row->title,
                'category_name'=>$row->category->name,
                'quest_tags'=>$tags,
                'status'=>$row->status,
                'date'=>''.$row->created_at
            ];
        }
        $data_table_render = DataTables::of($customData)
            ->addColumn('hash',function ($row){
                return '<input type="checkbox" id="qst_id_'.$row["id"].'">';
            })
            ->addColumn('action',function ($row){
                return '<button class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>'.
                    '<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>';
            })
            ->editColumn('status',function ($row){
                $htmlElement = "";
                if ($row['status']==1){
                    $htmlElement = '<button class="btn btn-success btn-xs">Active</button>';
                }else{
                    $htmlElement = '<button class="btn btn-danger btn-xs">Inactive</button>';
                }
                return $htmlElement;
            })
            ->editColumn('quest_tags',function ($row){
                $htmlElement = '';
                foreach ($row['quest_tags'] as $tag){
                    $htmlElement .= '<button class="btn btn-success btn-xs">'.$tag.'</button>';
                }
                return $htmlElement;
            })
            ->rawColumns(['hash','status','action','quest_tags'])
            ->make(true);
        return $data_table_render;
    }

    public function topQuestion(Request $request){
        // get the Get parameter value of url
        $option = $request->input('option');

        $query = Question::orderBy('id','DESC');
        if ($option=="today"){
            $query->whereDate('created_at',date('Y-m-d'));
        }elseif ($option=="week"){
            $query->whereDate('created_at','>=','2019-05-01');
            $query->whereDate('created_at','<=','2019-05-07');
        }elseif ($option=="month"){
            $query->whereDate('created_at','>=','2019-05-01');
            $query->whereDate('created_at','<=','2019-05-31');
        }

        $questions = $query->paginate(5);

        $questions->appends(['option'=>$option]);

        return view('front.question.top-question')
            ->with('questions',$questions);
    }
}
