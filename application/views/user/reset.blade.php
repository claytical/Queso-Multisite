@layout('layouts.default')
@section('content')
<h2>Password Reset</h2>
@if($data['success'])
	<div class="alert alert-success">
	Your password has been successfully changed.
	</div>
@else
	<div class="alert alert-danger">
	{{$data['error']}}
	</div>
	<a href="{{URL::to('user/changepw')}}" class="btn btn-primary">Try Again</a>
@endif
@endsection