@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Search Question</h3>
    </div>
@endsection
@section('contain')
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Search <small>Items</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="{{ route('search.question') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search Something..">
                        <button class="btn btn-success btn-sm"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                       <thead>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Tags</th>
                          <th>Created At</th>
                          <th>Action</th>
                       </thead>
                       <tbody>
                         @forelse($questions as $row)
                             <tr>
                                 <td>{{ $row->title }}</td>
                                 <td>{{ $row->category->name }}</td>
                                 <td>
                                     @foreach($row->tags as $item)
                                        <button class="btn btn-info btn-sm"> {{ $item->name }}</button>
                                     @endforeach
                                 </td>
                                 <td>
                                     {{ $row->created_at }}
                                 </td>
                                 <td>
                                     <a href="{{ url('view/question/'.$row->id) }}" class="btn btn-info btn-sm"> View</a>
                                 </td>
                             </tr>
                         @empty
                             <tr>
                                 <td colspan="5">No Data Found</td>
                             </tr>
                         @endforelse
                       </tbody>
                    </table>
                    @if(count($questions)>0)
                      {{ $questions->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection