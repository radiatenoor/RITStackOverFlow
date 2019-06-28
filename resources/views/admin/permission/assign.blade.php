@extends('admin.master')
@section('page_title')
    <div class="page-title">
        <div class="title_left">
            <h3>Assign Role To System User</h3>
        </div>
    </div>
@endsection
@section('stylesheets')
    <link href="{{ asset('js/admin/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection
@section('container')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Assign Role <small>To System User </small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button class="btn btn-success btn-md" data-target=".assign_modal" data-toggle="modal"><i class="fa fa-plus-circle"></i> Assign</button>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($admins as $row)
                         <tr>
                             <td>{{ $row->name }}</td>
                             <td>{{ $row->email }}</td>
                             <td>{{ $row->role }}</td>
                             <td>
                                 @foreach($row->permissions as $permission)
                                     <label class="badge badge-danger">{{ $permission->name }}</label>
                                 @endforeach
                             </td>
                             <td>
                                 <button id="{{ $row->id }}"
                                         data-target=".edit_assign_modal"
                                         data-toggle="modal"
                                         data-username="{{ $row->name }}"
                                         data-permission="{{ $row->permissions->pluck('id') }}"
                                         class="btn btn-info btn-xs edit_permission">
                                     <i class="fa fa-eye"></i> Edit
                                 </button>
                                 <button id="{{ $row->id }}" class="btn btn-danger btn-xs delete_permissions"><i class="fa fa-trash-o"></i> Delete</button>
                             </td>
                         </tr>
                      @endforeach
                    </tbody>
                </table>
                <!-- Assign modal -->
                <div class="modal fade assign_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Assign Permission</h4>
                            </div>
                            <form id="assign_form" action="{{ route('assign.permission') }}" class="form-horizontal"  method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">System User <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name="admin_id">
                                                <option>-- Select User --</option>
                                                @foreach($admins as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Permissions <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control permissions" name="permissions[]" multiple>
                                                <option>-- Select Permission --</option>
                                                @foreach($permissions as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                    <button type="submit" id="save_assign" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- / Assign modal -->
                <!--Edit Assign modal -->
                <div class="modal fade edit_assign_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Edit Assigned Permission</h4>
                            </div>
                            <form id="edit_assign_form" action="{{ route('update.permission') }}" class="form-horizontal"  method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">System User <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="hidden" class="form-control" name="show_edit_id" id="show_edit_id" value="">
                                            <input type="text" class="form-control" id="show_edit_username" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Permissions <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select id="edit_permission" class="form-control permissions" name="edit_permissions[]" multiple>
                                                <option>-- Select Permission --</option>
                                                @foreach($permissions as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                    <button type="submit" id="update_assign" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- / Edit Assign modal -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/admin/select2/dist/js/select2.js') }}"></script>
    <script>
        $(".permissions").select2();
        $('.edit_permission').click(function () {
            var id = $(this).attr('id');
            var permissions = $(this).attr('data-permission');
            var username = $(this).attr('data-username');
            console.log(JSON.parse(permissions));
            $('#show_edit_id').val(id);
            $('#show_edit_username').val(username);

            $('#edit_permission').val(JSON.parse(permissions));
            $('#edit_permission').trigger('change');
        });
        $('.delete_permissions').click(function () {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result){
                if (result.value) {
                    // delet by ajax
                    var url = "{{ url('delete/permission') }}";
                    $.ajax({
                        /*config part*/
                        url:url+"/"+id,
                        type:"GET",
                        dataType:"json",
                        /*Config part*/
                        beforeSend:function () {
                            Swal.fire({
                                title: 'Deleting Data.......',
                                html:"<i class='fa fa-spinner fa-spin' style='font-size: 24px'></i>",
                                allowOutsideClick:false,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        success:function (response) {
                            Swal.close();
                            if(response==="success"){
                                Swal.fire({
                                    title: 'Success',
                                    text: "You Have Succefully Deleted The Permissions",
                                    type: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function(result){
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            }
                            console.log(response);
                        },
                        error:function (error) {
                            Swal.fire({
                                title: 'Error',
                                text:'Something Went Wrong',
                                type:'error',
                                showConfirmButton: true
                            });
                            console.log(error)
                        }

                    })
                }
            });
        });
    </script>
@endsection