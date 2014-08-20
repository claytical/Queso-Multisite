@layout('layouts.default')
@section('content')
<h1>Public Course List</h1>
@if($courses)
	<ul>
	@foreach($courses as $course)	
		<li><a href="{{URL::to('course/add/'.$course->code)}}">{{$course->name}}</a></li>
	@endforeach
	</ul>
@else
<p>There are no publicly available courses. In order to sign up for a course, you need to know the registration code.</p>
@endif
@endsection