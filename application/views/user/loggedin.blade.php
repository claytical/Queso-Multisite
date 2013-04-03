@layout('layouts.default')
@section('content')
<h1>Login</h1>
Logged in {{$user->email}}!

Current Course: {{ Session::get('current_course')}}
{{URI::segment(1)}}
@endsection