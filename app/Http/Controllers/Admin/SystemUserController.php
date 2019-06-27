<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SystemUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:system_admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderBy('id','DESC')
            ->whereNotIn('role',['master-admin'])
            ->get();
        return view('admin.system_user.list')
            ->with('admins',$admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.system_user.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:admins,email',
            'password'=>'required|string|confirmed|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'role'=>'required'
        ]);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->active = 1;
        $admin->role = $request->role;
        if ($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = time().".".$image->getClientOriginalExtension();
            $destination_path = public_path('images/admin');
            $image->move($destination_path,$filename);
            $admin->photo = $filename;
        }
        $admin->save();
        Session::flash('success','You have Successfully Added New System User');
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
        $admin = Admin::find($id);
        return view('admin.system_user.edit')
            ->with('admin',$admin);
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
            'name'=>'required',
            'email'=>'required|email|unique:admins,email,'.$id,
            'role'=>'required'
        ]);

        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role = $request->role;
        if ($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = time().".".$image->getClientOriginalExtension();
            $destination_path = public_path('images/admin');
            $image->move($destination_path,$filename);
            $admin->photo = $filename;
        }
        $admin->save();
        Session::flash('success','You have Successfully Updated System User');
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
        $admin = Admin::find($id);
        if ($admin && $admin->role != 'master-admin'){
            $admin->delete();
            return response()->json('successful',201);
        }
        return response()->json('error',422);
    }
}
