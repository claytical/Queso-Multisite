@layout('layouts.notloggedin')
@section('title')
Forgot Password
@endsection
@section('content')
<h2>Password Reset Confirmed!</h2>
<p class="lead">Your password has been successfully reset, you may now login.</p>
<a class='btn btn-primary btn-large' href="{{URL::to('login')}}">Login</a>
@endsection