@if ($info)
<ul class="nav pull-right">
	<li class="dropdown">					  
	  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	  <i class="icon-user icon-white"></i> {{ $info['user']['metadata']['first_name'] . " " .$info['user']['metadata']['last_name']}}
	  <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
		<li class="dropdown-submenu" tabindex="-1"><a href="#">Courses</a>
			<ul class="dropdown-menu">
				@foreach($info['groups'] as $course)
					<li><a href="{{ URL::to('/course/'.$course['id']);}}">{{$course['name']}}</a></li>
				@endforeach

			</ul>
		</li>
		<li><a href="{{ URL::to('user');}}">Progress</a></li>
		<li><a href="{{ URL::to('user/preferences');}}">Preferences</a></li>
		<li class="divider"></li>
		<li><a href="{{ URL::to('user/add');}}">Add Course</a></li>
		<li><a href="{{ URL::to('user/changepw');}}">Change Password</a></li>
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