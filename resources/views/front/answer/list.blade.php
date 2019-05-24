@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Answered List</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Answered <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="answer_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Answered Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- question loop -->
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
        $(function () {
            $('#answer_table').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{url('answered/datatable')}}",
                columns:[
                    { data: 'hash', name: 'hash' },
                    { data: 'question.title', name: 'question.title' },
                    { data: 'answer', name:'answer'},
                    { data: 'created_at', name:'created_at'},
                    { data: 'action' , name:'action'}
                ]
            });
        })
    </script>
@endsection
