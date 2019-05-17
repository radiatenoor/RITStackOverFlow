@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Top Question</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="{{ asset('js/admin/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Top Question <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button class="btn btn-info">Ask Question?</button><br>
                <div class="btn-group">
                    <a href="{{ url('top/question?option=today') }}" class="btn btn-sm btn-default" type="button"><i class="fa fa-hand-o-right"></i> Today</a>
                    <a href="{{ url('top/question?option=week') }}" class="btn btn-sm btn-default" type="button"><i class="fa fa-hand-o-right"></i> Week</a>
                    <a href="{{ url('top/question?option=month') }}" class="btn btn-sm btn-default" type="button"><i class="fa fa-hand-o-right"></i> Month</a>
                </div>
                <div class="ln_solid"></div>
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <tbody>
                            @foreach($questions as $row)
                                <tr>
                                    <th style="width: 100px">
                                        <button class="btn btn-default">
                                            Views <br>
                                            <span class="badge badge-danger">25</span>
                                        </button>
                                    </th>
                                    <th style="width: 100px">
                                        <button class="btn btn-default">
                                            Answer <br>
                                            <span class="badge badge-danger">25</span>
                                        </button>
                                    </th>
                                    <th style="width: 100px">
                                        <button class="btn btn-default">
                                            Votes <br>
                                            <span class="badge badge-danger">25</span>
                                        </button>
                                    </th>
                                    <th>
                                        <label style="font-size: 20px">{{$row->title}}</label><br>
                                        @foreach($row->tags as $tag)
                                          <button class="btn btn-success btn-xs"><i class="fa fa-tags"></i> {{$tag->name}}</button>
                                        @endforeach
                                        <br>
                                        <span>Asked {{$row->created_at}} By {{$row->user->name}}</span>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection