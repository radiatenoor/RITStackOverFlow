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
        $question = Question::find($id);
       return view('front.question.show')
           ->with('question',$question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::where('user_id',Auth::user()->id)
            ->where('id',$id)->first();
        $tags = Tag::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $tag_array=[];
        foreach ($question->tags as $tag){
            $tag_array[] = $tag->id;
        }
        return view('front.question.edit')
            ->with('question',$question)
            ->with('categories',$categories)
            ->with('tags',$tags)
            ->with('tag_array',$tag_array);
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
        //validate
        $this->validate($request,[
            'title'=>'required|min:6',
            'category'=>'required',
            'tag'=>'required|array|min:1',
            'description'=>'required|min:10'
        ]);

        // 2. data update
        $quest = Question::find($id);
        $quest->title = $request->title;
        $quest->category_id = $request->category;
        $quest->description = $request->description;
        $quest->save();

        // data update in many to many relationship/link table
        $quest->tags()->sync($request->tag);

        return response()->json('success',201);
    }

    public function view($id){
        $question = Question::where('user_id',Auth::id())
//            ->where('id',$id)->first();
              ->find($id);

        return view('front.question.view')
            ->with('question',$question);
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
                $view_url = url('view/question/'.$row['id']);
                $edit_url = url('edit/question/'.$row['id']);
                return '<a href="'.$edit_url.'" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.$view_url.'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>'.
                    '<button onClick="deleteQuestion('.$row['id'].')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>';
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

        $today = date('Y-m-d');
        /*here we conditionally add mysql where condition to a query object*/
        if ($option=="today"){
            $query ->whereDate('created_at',$today);
        }elseif ($option=="week"){
            $week = new \DateTime($today);
            $week->modify('-6 days');
            $weekDate = $week->format('Y-m-d');
            $query->whereDate('created_at','>=',$weekDate);
            $query->whereDate('created_at','<=',$today);
        }elseif ($option=="month"){
            $month = new \DateTime($today);
            $month->modify('-30 days');
            $monthDate = $month->format('Y-m-d');
            $query->whereDate('created_at','>=',$monthDate);
            $query->whereDate('created_at','<=',$today);
        }

        $questions = $query->paginate(5);
        /* Used when your query is filter query and search query */
        $questions->appends(['option'=>$option]);

        return view('front.question.top-question')
            ->with('questions',$questions);
    }

    public function deleteQuestion($id){
        $question = Question::where('user_id',Auth::id())
            ->find($id);
        if($question){
            $question->delete();
            return response()->json('successful',201);
        }
        return response()->json('error',422);
    }

    public function search(Request $request){

        $searchValue = $request->search;
        $questions=[];

        if ($searchValue) {
            $questions = Question::where('status', 1)
                ->where('title','like','%'. $searchValue . '%')
                ->paginate(3);
            $questions->appends(['search'=>$searchValue]);
        }

        return view('front.question.search')
            ->with('questions',$questions);
    }
}
