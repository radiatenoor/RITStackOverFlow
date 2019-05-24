@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Edit Question</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="{{ asset('js/admin/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection
@section('contain')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Question</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form id="question_form" action="" method="post" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="title" name="title" required="required"
                                       value="{{$question->title}}"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Category <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="category" class="form-control col-md-7 col-xs-12" required>
                                    <option value="">-- Selecte Category --</option>
                                    <!-- category loop -->
                                    @foreach($categories as $category)
                                      <option value="{{$category->id}}" {{$question->category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tag <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="tag[]" id="tag" class="form-control col-md-7 col-xs-12" required multiple>
                                    <!-- Tag loop -->
                                    @foreach($tags as $tag)
                                       <option value="{{$tag->id}}" {{in_array($tag->id,$tag_array)?'selected':''}}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <textarea name="description" id="description">
                                   {!! $question->description !!}
                               </textarea>
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
    </div>
@endsection
@section('script')
    <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <script src="{{ asset('js/admin/select2/dist/js/select2.js') }}"></script>
 <script>
     CKEDITOR.replace('description');
     $(function () {
        $("#tag").select2();
        $('#question_form').submit(function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to update the question",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then(function(result) {
                if (result.value) {
                    var form = $("#question_form")[0];
                    var formData = new FormData(form);
                    var url = "{{url('update/question')}}"+"/"+"{{$question->id}}";
                    $.ajax({
                        url:url,
                        type:"POST",
                        data:formData,
                        dataType:"json",
                        contentType:false,
                        processData:false,
                        beforeSend:function () {
                            Swal.fire({
                                title: 'Updating Data.......',
                                html:"<i class='fa fa-spinner fa-spin' style='font-size: 24px'></i>",
                                allowOutsideClick:false,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        success:function (response) {
                            Swal.close();
                            if(response==="success") {
                                Swal.fire({
                                    title: 'Success',
                                    text: "You Have Succefully Updated",
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
                            console.log(error);
                        }
                    });
                }
            });
        })
     });
     
 </script>
@endsection
