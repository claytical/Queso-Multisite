@layout('layouts.default')
@section('content')
<h1>Course Setup</h1>
	<ul>
	@foreach($courses as $course)	
		<li>{{$course->name}} <a href="{{URL::to('admin/course/remove/'.$course->id)}}">Remove</a></li>
	@endforeach
	</ul>
@endsection