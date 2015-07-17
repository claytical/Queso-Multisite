@layout('layouts.default')
@section('content')

<h2>{{$data->quest->name}} Redemption Codes</h2>
<div class="container">
<p>Generated {{$data->amount}} redemption codes.</p>
	<ul>
	
	@foreach($data->quest->redemptions as $redemption)
		<li>{{$redemption->code}}</li>
	@endforeach
	
	</ul>
</div>
    @endsection