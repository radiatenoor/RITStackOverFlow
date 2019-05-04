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
                             <th></th>
                         </tr>
                       </thead>
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
            $('#question_table').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{url('question/datatable')}}",
                columns:[
                    { data: 'hash', name: 'hash' },
                    { data: 'title', name: 'title' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'quest_tags', name: 'quest_tags' },
                    { data: 'status', name: 'status' },
                    { data: 'date', name: 'date' },
                    { data: 'action', name: 'action' }
                ]
            });

        });
    </script>
@endsection
