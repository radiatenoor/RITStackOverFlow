<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
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


    public function assign(){
        $admin = Admin::orderBy('id','DESC')
            ->whereNotIn('role',['master-admin'])
            ->get();
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('admin.permission.assign')
            ->with('admins',$admin)
            ->with('permissions',$permissions);

    }

    public function assignPermission(Request $request){
        $this->validate($request,[
           'admin_id'=>'required',
            'permissions'=>'required|array|min:1'
        ]);

        $admin = Admin::find($request->admin_id);
        $admin->permissions()->attach($request->permissions);

        Session::flash('success','Successfully Assigned');
        return redirect()->back();
    }

    public function updatePermission(Request $request){
        $this->validate($request,[
            'show_edit_id'=>'required',
            'edit_permissions'=>'required|array|min:1'
        ]);

        $admin = Admin::find($request->show_edit_id);
        $admin->permissions()->sync($request->edit_permissions);

        Session::flash('success','You Have Successfully Updated the permissions');
        return redirect()->back();
    }

    public function deletePermission($id){
        $admin = Admin::find($id);
        $admin->permissions()->detach();
        return response()->json('success',201);
    }
}
