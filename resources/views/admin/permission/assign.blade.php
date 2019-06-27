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
                                            <select id="permissions" class="form-control" name="permissions[]" multiple>
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
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/admin/select2/dist/js/select2.js') }}"></script>
    <script>
        $("#permissions").select2();
    </script>
@endsection