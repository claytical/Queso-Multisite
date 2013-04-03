@layout('layouts.default')
@section('content')
<h2>Questions</h2>

	@if(isset($questions))
		@foreach($questions as $question)
			<div class="well">
				<p>{{$question->username}} asked...</p>
				{{$question->question}}
				<a href="{{URL::to('question/'.$question->id)}}" class="btn pull-right">Answers</a>
			</div>
		@endforeach
	@else
	<p class="lead">No one has asked any questions yet.</p>
	@endif
@endsection