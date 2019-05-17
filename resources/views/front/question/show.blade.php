@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Question</h3>
    </div>
@endsection
@section('stylesheet')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8.11.1/dist/sweetalert2.min.css">
@endsection
@section('contain')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="row">
                        <!-- CONTENT MAIL -->
                        <div class="col-sm-9 mail_view">
                            <div class="inbox-body">
                                <div class="mail_heading row">
                                    <div class="col-md-8">
                                        <div class="btn-group">
                                            <button class="btn btn-md btn-info" type="button">Total Vote <span class="badge badge-danger"></span></button>
                                                <a href="" class="btn btn-md btn-default" type="button"><i class="fa fa-star-o"></i> Vote?</a>
                                                <button class="btn btn-md btn-success" type="button"><i class="fa fa-star"></i> Voted</button>
                                                <a href="" class="btn btn-md btn-danger" type="button"><i class="fa fa-exclamation-circle"></i> Cancel Vote</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p class="date">Asked: {{$question->created_at}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <h4> {{$question->title}}</h4>
                                    </div>
                                </div>
                                <div class="view-mail">
                                    <p>
                                        {{$question->description}}
                                    </p>
                                </div>
                                <div class="attachment">
                                    <ul>
                                        @foreach($question->tags as $tag)
                                         <button class="btn btn-info btn-xs"><i class="fa fa-tag"></i> {{ $tag->name }}</button>
                                        @endforeach
                                    </ul>
                                </div>
                                <h2>All Answer <span class="badge badge-danger">{{isset($question->answers)?count($question->answers):0}}</span></h2>
                                    @foreach($question->answers as $answer)
                                    <div class="ln_solid"></div>
                                    <div class="view_answers">
                                        <div class="view-mail">
                                            <p>
                                                {!! $answer->answer !!}
                                            </p>
                                        </div>
                                        <div class="sender-info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span data-answer="#" class="sender-dropdown edit_answer" style="cursor: pointer"><i class="fa fa-edit"></i> Edit</span>
                                                    <span id="{{$answer->id}}" class="open_comment_box" data-toggle="modal" data-target=".comment_modal" style="cursor: pointer">
                                                        <i class="fa fa-comment"></i> Comment
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled msg_list">
                                            <li>
                                                <a>
                                                    <span class="image">
                                                      <img src="{{asset('images/user.png')}}" alt="img">
                                                    </span>
                                                    <span>
                                                      <span>{{$answer->user->name}}</span>
                                                    </span>
                                                    <span class="message">
                                                      Answered {{$answer->created_at}}
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="sender-info">
                                            <div class="comments">
                                                <label>Comments <span class="badge badge-danger">{{isset($answer->comments)?count($answer->comments):0}}</span></label>
                                                <div class="row">
                                                    @foreach($answer->comments as $comment)
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <span>
                                                            <i class="fa fa-comment"></i> {{$comment->comment}}
                                                        </span>
                                                        <span style="color: #0bff82">Comment {{$comment->created_at}} By: {{$comment->user->name}}</span>
                                                        <button class="btn btn-danger btn-xs delete_comment"><i class="fa fa-trash"></i></button>
                                                        <hr>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="answer_section">
                                    <h2>Your Answer</h2>
                                    <div class="ln_solid"></div>
                                    <form id="answer_form" data-parsley-validate="" action="{{route('store.answer',$question->id)}}" method="post">
                                        @csrf
                                        <textarea name="answer" id="answer" rows="10" cols="80"
                                                  data-parsley-minlength="6"
                                                  data-parsley-minlength-message="Come on! You need to enter at least a 6 character comment..">

                                        </textarea>
                                        <div class="ln_solid"></div>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-primary" type="button" id="post_answer"><i class="fa fa-save"></i> Post Answer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Comment modal -->
                            <div class="modal fade comment_modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Comment Box</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="comment_form" data-parsley-validate=""  method="post">
                                                @csrf
                                                <textarea name="comment" id="comment" rows="10" cols="200"
                                                          data-parsley-trigger="keyup"
                                                          data-parsley-minlength="6"
                                                          data-parsley-minlength-message="Come on! You need to enter at least a 6 character comment.."
                                                          placeholder="Comment on This Answer" style="width: 100%" required></textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                            <button type="button" id="save_comment" class="btn btn-success"><i class="fa fa-save"></i> Save Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- / Comment modal -->
                        </div>
                        <!-- /CONTENT MAIL -->
                        <div class="col-sm-3 mail_list_column">
                            <a href="#">
                                <div class="mail_list">
                                    <div class="left">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                    <div class="right">
                                        <h3>View <small>16 times</small></h3>
                                    </div>
                                </div>
                            </a>
                            <a href="#">
                                <div class="mail_list">
                                    <div class="left">
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="right">
                                        <h3>Active: <small>yes no</small></h3>
                                    </div>
                                </div>
                            </a>
                            <div class="col-xs-12 profile_details">
                                <div class="well profile_view">
                                    <div class="col-sm-12">
                                        <h4 class="brief"><i>Asked By</i></h4>
                                        <div class="right col-xs-8 col-xs-offset-2 text-center">
                                            <img src="{{asset('images/user.png')}}" alt="" class="img-circle img-responsive">
                                        </div>
                                        <div class="left col-xs-12">
                                            <h5>{{$question->user->name}}</h5>
                                            <p><strong>About: {{$question->user->title}}</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 bottom text-center">
                                        <div class="col-xs-12 col-sm-6 emphasis">
                                            <button type="button" class="btn btn-primary btn-xs">
                                                <i class="fa fa-user"> </i> View Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /MAIL LIST -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.11.1/dist/sweetalert2.js"></script>
    <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <script>
        $(function () {
            CKEDITOR.replace( 'answer' );
            $("#post_answer").click(function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want save the answer",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save it!'
                }).then(function(result){
                    if (result.value) {
                       $('#answer_form').submit();
                    }
                });
            });
            $(".open_comment_box").click(function () {
                var url = "{{url('store/comment')}}";
                var id = $(this).attr('id');
                $("#comment_form").attr('action',url+"/"+id);
            });
            $("#save_comment").click(function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want save the comment",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save it!'
                }).then(function(result){
                    if (result.value) {
                        $('#comment_form').submit();
                    }
                });
            })
        })
    </script>
@endsection