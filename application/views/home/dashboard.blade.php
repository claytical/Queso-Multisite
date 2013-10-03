@layout('layouts.noclass')
@section('content')
<div class="container">
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
              {{$notice->notification}}
              </div>
            </li>
            @endforeach
            </ul>
          @else
            <p class="lead">
            Nothing new!
            </p>
          @endif
     </div>
</div>    
<div class="container">
    <div class="col-md-12">
            <hr>
            <footer>
            <p>&copy; Clay Ewing 2013</p>
          </footer>
    </div>
</div>
    @endsection