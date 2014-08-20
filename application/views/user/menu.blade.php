@if ($info)
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">					  
	  <a id="usermenu" role="button" class="dropdown-toggle" data-toggle="dropdown" href="#">
	  <i class="icon-user icon-white"></i> {{ $info['user']['metadata']['first_name'] . " " .$info['user']['metadata']['last_name']}}
	  <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu" role="menu" aria-labelledby="usermenu">
          <li role="presentation" class="dropdown-header">Courses</li>          
				@foreach($info['groups'] as $course)
					<li role="presentation"><a role="menuitem" href="{{ URL::to('/course/'.$course->id);}}">{{$course->name}}</a>                      </li>
				@endforeach
          <li role="presentation" class="divider"></li>
          
        @if(Course::is_instructor())
            <li role="presentation"><a role="menuitem" href="{{ URL::to('admin/course');}}">Course Setup</a></li>
            <li role="presentation"><a role="menuitem" href="{{ URL::to('admin/course/export');}}">Export</a></li>
            <li role="presentation"><a role="menuitem" href="{{ URL::to('admin/course/new');}}">New Course</a></li>
          @else
            <li role="presentation"><a role="menuitem" href="{{ URL::to('user');}}"><span class="glyphicon glyphicon-stats"></span> Progress</a></li>
        @endif
        <li class="divider"></li>
          <li role="presentation"><a role="menuitem" href="{{ URL::to('user/add');}}">Join Another Course</a></li>
          <li role="presentation"><a role="menuitem" href="{{ URL::to('user/preferences');}}">Account Settings</a></li>
        <li role="presentation"><a role="menuitem" href="{{ URL::to('user/logout');}}">Sign Out</a></li>

        </ul>
	</li>
</ul>
@else
	@if(URI::segment(1) == 'login')
	@else
        @include('user.loginbar')
    @endif
@endif
