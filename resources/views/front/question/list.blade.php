@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Question List</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Question <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tile</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Status</th>
                            <th>Create Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- question loop -->
                        @foreach($question as $qst)
                            <tr>
                                <td><input type="checkbox" id="qst_id_{{$qst->id}}"></td>
                                <td>{{$qst['title']}}</td>
                                <td>{{$qst->category->name}}</td>
                                <td>
                                    @foreach($qst->tags as $tag)
                                        <button class="btn btn-success btn-xs">{{$tag->name}}</button>
                                    @endforeach
                                </td>
                                <td>
                                    @if($qst->status==1)
                                        <button class="btn btn-success btn-xs">Active</button>
                                    @else
                                        <button class="btn btn-danger btn-xs">Inactive</button>
                                    @endif
                                </td>
                                <td>
                                    {{$qst->created_at}}
                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#question_table').DataTable();
        } );
    </script>
@endsection