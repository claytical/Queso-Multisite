@layout('layouts.default')
@section('content')
	@if($notices)
	<h2>Notifications</h2>
		@foreach($notices as $notice)
			<div class="notice well">
				 <a class="close" href="{{URL::to('notice/hide/'.$notice->id)}}">×</a>
				<h3>{{$notice->title}}</h3>
				<a class="btn btn-info pull-right" href="{{URL::to($notice->url)}}">More Info</a>
				{{$notice->notification}}
			</div>
		@endforeach
	@else
		<h2>There are no new notifications</h2>
	@endif
@endsection