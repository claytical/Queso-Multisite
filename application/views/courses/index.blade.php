@layout('layouts.default')
@section('content')
<h1>Course Setup</h1>
	<ul>
	@foreach($courses as $course)	
		<li>{{$course->name}}</li>
	@endforeach
	</ul>
@endsection