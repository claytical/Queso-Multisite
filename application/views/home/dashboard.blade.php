@layout('layouts.noclass')
@section('content')

	  <div class="row-fluid">
        <div class="span6">
          <h2>Classes</h2>
          @foreach($info->courses as $course)
          <p><a href="{{URL::to('course/'.$course->id)}}">{{$course->name}}</a></p>
          @endforeach
        </div>

        <div class="span6">
          <h2>Notices</h2>
          @if($info->notices)
            <ul class="unstyled">
            @foreach($info->notices as $notice)
            <li>
              <div>
              <a class="btn btn-info pull-right" href="{{URL::to('notice/show/'.$notice->id)}}"><i class="icon-arrow-right"></i></a>

              {{$notice->notification}}
              </div>
            </li>
            @endforeach
            </ul>
          @else
          Nothing new!
          @endif
       </div>

      </div>

      <hr>

      <footer>
        <p>&copy; Clay Ewing 2013</p>
      </footer>
@endsection