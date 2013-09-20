@layout('layouts.noclass')
@section('content')
<div class="row container">
<div class="col-md-3">
      <h2>Classes</h2>
    <div class="list-group">
    @foreach($info->courses as $course)
      <a class="list-group-item" href="{{URL::to('course/'.$course->id)}}">{{$course->name}}</a>       
      @endforeach
    </div>
</div>
<div class="col-md-9">
<h2>Notices</h2>
      @if($info->notices)
        <ul class="list-unstyled">
        @foreach($info->notices as $notice)
        <li>
          <div>
          <a class="btn btn-info btn-xs pull-right" href="{{URL::to('notice/show/'.$notice->id)}}">View</a>

          {{$notice->notification}}
          </div>
        </li>
        @endforeach
        </ul>
      @else
      Nothing new!
      @endif
 </div>

      <hr>

      <footer>
        <p>&copy; Clay Ewing 2013</p>
      </footer>
</div>
    @endsection