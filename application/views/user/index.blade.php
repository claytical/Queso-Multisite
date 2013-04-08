@layout('layouts.default')
@section('content')
<h1>Player List</h1>
	<ul>
	@foreach($users as $user)
		<li>{{$user->email}}</li>
	@endforeach
	</ul>
@endsection