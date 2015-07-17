@layout('layouts.notloggedin')
@section('content')
     <div class="page-header">
         <div class="container">
<!--         <img src="img/logo.png" style="width: 250px;" class="pull-right">-->
            <h1>Welcome to Queso!</h1>
            <p>Queso is a learning management system for gameful classrooms.  We help you take your existing classroom and reshape it using concepts from game design.</p>
            <p><a href="{{URL::to('register/instructor')}}" class="btn btn-primary btn-large">Create a Course!</a></p>
         </div>
	  </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                  <h2>Philosophy</h2>
                  <p>This is not about points, badges, and leaderboards.  This is about increasing student engagement through gameful design.</p>
                  <p><a class="btn btn-default" href="http://conque.so/games-and-teaching-notes-for-a-manifesto/">Learn More</a></p>
                </div>
                <div class="col-md-4">
                  <h2>Test Drive</h2>
                  <p>Curious what a Queso course looks like on the student end?  Try creating a student account and playing with our demo course.</p>
                  <p><a class="btn btn-default" href="http://class.conque.so/register?id=HahFhAymysba">Try It</a></p>
               </div>
                <div class="col-md-4">
                  <h2>Get Involved</h2>
                  <p>Queso is an open source project and completely free.  We host your classes on our site for free.  If you know a bit of PHP, why not help out?</p>
                  <p><a class="btn btn-default" href="https://github.com/claytical/Queso-Multisite">Fork Us on Github</a></p>
                </div>
          </div>
      <hr>

      <footer>
				<div class="col-md-12">
					<div class="col-md-6">&copy; Clay Ewing 2015</div>
					<div class="col-md-6">
						<div class="pull-right"><a href="{{URL::to('credits')}}">Credit where credit is due</a></div>
					</div>
					
				</div>

      </footer>
    </div>
@endsection