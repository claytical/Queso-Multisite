@if ($info)
<ul class="nav navbar-nav pull-right">
	<li class="dropdown">					  
	  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	  <i class="icon-user icon-white"></i> {{ $info['user']['metadata']['first_name'] . " " .$info['user']['metadata']['last_name']}}
	  <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
          <li role="presentation" class="dropdown-header">Courses</li>          
				@foreach($info['groups'] as $course)
					<li><a href="{{ URL::to('/course/'.$course['id']);}}">{{$course['name']}}</a>                      </li>
				@endforeach
          <li class="divider"></li>
        @if(Course::is_instructor())
            <li><a href="{{ URL::to('admin/course');}}">Course Setup</a></li>
            <li><a href="{{ URL::to('admin/course/export');}}">Export</a></li>
            <li><a href="{{ URL::to('admin/course/new');}}">New Course</a></li>
          @else
            <li><a href="{{ URL::to('user');}}">Progress</a></li>
        @endif
        <li class="divider"></li>
        <li><a href="{{ URL::to('user/preferences');}}">Account Settings</a></li>
        <li><a href="{{ URL::to('user/logout');}}">Sign Out</a></li>

        </ul>
	</li>
</ul>
@else
	@if(URI::segment(1) == 'login')
	@else
	<a class="btn btn-primary pull-right" href="{{ URL::to('login')}}">Login</a>
	@endif
@endif
