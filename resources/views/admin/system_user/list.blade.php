@extends('admin.master')
@section('page_title')
    <div class="page-title">
        <div class="title_left">
            <h3>New System User</h3>
        </div>
    </div>
@endsection
@section('container')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>User <small>list</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-bordered">
                    <thead>
                       <tr>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Active</th>
                           <th>Role</th>
                           <th>Created At</th>
                           <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                       @foreach($admins as $row)
                           <tr>
                             <td>
                                 @if($row->photo)
                                   <img src="{{ asset('images/admin/'.$row->photo) }}" style="width: 30px; height: 30px; border-radius: 20px">
                                 @endif
                                 {{ $row->name }}
                             </td>
                             <td>{{ $row->email }}</td>
                             <td>
                                 @if($row->active==1)
                                     <button class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i> Activate</button>
                                 @else
                                     <button class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Deactivate</button>
                                 @endif
                             </td>
                             <td>{{ $row->role }}</td>
                             <td>{{ $row->created_at }}</td>
                             <td>
                                 <a href="{{ route('edit.system.user',$row->id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View</a>
                                 <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                             </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection