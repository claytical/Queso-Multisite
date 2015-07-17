@layout('layouts.default')
@section('content')
<h1>Redeemed!</h1>
@foreach($skills as $skill)
	<p>{{$skill->amount}} points!</p>
@endforeach

@endsection