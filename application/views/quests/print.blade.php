@layout('layouts.print')
@section('content')

	@foreach($quest->redemptions as $redemption)
	    <div class="col-xs-3 text-center" style="border: 1px dotted; padding-top:10px; padding-bottom: 10px;">
		    <h3>{{$quest->name}}</h3>
		    <img src=" https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{$redemption->code}}"/>
		    <p>{{$redemption->code}}</p>
	    </div>
	@endforeach


@endsection