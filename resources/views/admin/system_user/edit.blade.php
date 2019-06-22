@extends('admin.master')
@section('page_title')
    <div class="page-title">
        <div class="title_left">
            <h3>Edit/View System User</h3>
        </div>
    </div>
@endsection
@section('container')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit/View User <small>| admin</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form action="{{ route('update.system.user',$admin->id) }}" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $admin->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="email" name="email" value="{{ $admin->email }}" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="photo" class="form-control col-md-7 col-xs-12" type="file" name="photo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo Preview</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <img id="image_preview" src="{{ asset('images/admin/') }}/{{ $admin->photo!=null?$admin->photo:'' }}" style="width: 180px;height: 180px">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="role">
                                <option value="">-- Select Role --</option>
                                <option value="sub-admin" {{ $admin->role=='sub-admin'?'selected':'' }}>Sub Admin</option>
                                <option value="editor" {{ $admin->role=='editor'?'selected':'' }}>Editor</option>
                                <option value="moderator" {{ $admin->role=='moderator'?'selected':'' }}>Moderator</option>
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function() {
            readURL(this);
        });
    </script>
@endsection