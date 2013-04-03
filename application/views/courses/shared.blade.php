@layout('layouts.default')
@section('content')
<h2>Emails Sent!</h2>
<p class="lead">Feel free to share this link with anyone that you want to signup for the course:</p>
<p class="lead"><a href="{{URL::to('register?id='.Course::code())}}">{{URL::to('register?id='.Course::code())}}</a>
</p>

@endsection