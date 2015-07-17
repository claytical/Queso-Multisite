@layout('layouts.noclass')
@section('content')
<div class="container">

    <div class="col-md-3">
         @if($info->courses)
          <h2>Classes in Session</h2>
        <div class="list-group">
        @foreach($info->courses as $course)
          <a class="list-group-item" href="{{URL::to('course/'.$course->id)}}">{{$course->name}}</a>       
          @endforeach
        </div>
		@endif
		@if(isset($info->previous_courses))
          <h2>Archived Classes</h2>
        <div class="list-group">
        @foreach($info->previous_courses as $course)
          <a class="list-group-item" href="{{URL::to('course/'.$course->id)}}">{{$course->name}}</a>       
          @endforeach
        </div>
          @endif



    </div>

    <div class="col-md-9">
    <h2>Notices</h2>
          @if($info->notices)
            <ul class="list-unstyled">
            @foreach($info->notices as $notice)
            <li>
              <div>
              {{$notice->title}}
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
				<div class="col-md-12">
					<div class="col-md-6">&copy; Clay Ewing 2015</div>
					<div class="col-md-6">
						<div class="pull-right"><a href="{{URL::to('credits')}}">Credit where credit is due</a></div>
					</div>
					
				</div>
          </footer>
    </div>
</div>
    @endsection