@layout('layouts.default')
@section('content')

<h2>{{$data->quest->name}} Redemption Codes</h2>
<div class="container">
<p>Generated {{$data->amount}} redemption codes.</p>
<a href="{{URL::to('admin/quest/385/codes/print')}}" target="_blank" class="pull-right btn btn-default">Print QR Code Sheet</a>
	<ul>
	
	@foreach($data->quest->redemptions as $redemption)
		<li>{{$redemption->code}}</li>
	@endforeach
	
	</ul>
</div>
    @endsection