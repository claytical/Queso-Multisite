@layout('layouts.default')
@section('content')
	@if($notices)
	<div>
		@if($notices)
		<a href="{{URL::to('notices/hide')}}" class="btn btn-danger pull-right">Dismiss All</a>
		@endif

		<h2>Notifications</h2>
	</div>
		@foreach($notices as $notice)
			<div class="notice well">
				 <a class="close" href="{{URL::to('notice/hide/'.$notice->id)}}">×</a>
				<h3>{{$notice->title}}</h3>
				<a class="btn btn-info pull-right" href="{{URL::to('notice/show/'.$notice->id)}}">More Info</a>
				{{$notice->notification}}
			</div>
		@endforeach
	@else
		<h2>There are no new notifications</h2>
	@endif
@endsection