@layout('layouts.default')
@section('content')
<h2>Questions</h2>

	@if(isset($questions))
		@foreach($questions as $question)
			<div class="well">
				<a href="{{URL::to('question/'.$question->id)}}" class="btn pull-right">Answers</a>
				<p>{{$question->username}} asked...</p>
				{{$question->question}}
			</div>
		@endforeach
	@else
	<p class="lead">No one has asked any questions yet.</p>
	@endif
@endsection