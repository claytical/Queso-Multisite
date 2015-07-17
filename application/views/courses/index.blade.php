@layout('layouts.default')
@section('content')
<h1>Course List</h1>
@foreach($data->courses as $course)
	<div class="row">
		<div class="col-md-6">
			<h3>{{$course["class"]->name}}</h3>
			@foreach ($course["instructors"] as $instructor)
			{{$instructor->username}}<br/>
			@endforeach
			<ul style="unstyled-list">
				<li>Students <span class="pull-right">{{$course["class"]->users()->count()}}</span></li>
				<li>Quests <span class="pull-right">{{$course["class"]->quests()->count()}}</span></li>
				<li>Skills <span class="pull-right">{{$course["class"]->skills()->count()}}</span></li>
			</ul> 
		</div>

		<div class="col-md-6">
			<a class="btn btn-danger pull-right" href="{{URL::to('admin/course/remove/'.$course['class']->id)}}">Remove</a>
		</div>
	</div>
@endforeach


@endsection