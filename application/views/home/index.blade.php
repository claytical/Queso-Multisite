@layout('layouts.notloggedin')
@section('content')
     <div class="hero-unit">
        <h1>Welcome to Queso!</h1>
        <p>Queso is a learning management system for gameful classrooms.  We help you take your existing classroom and reshape it using concepts from game design.</p>
        <p><a href="{{URL::to('register/instructor')}}" class="btn btn-primary btn-large">Create a Course!</a></p>
      </div>
	  <div class="row-fluid">
        <div class="span4">
          <h2>Philosophy</h2>
          <p>This is not about points, badges, and leaderboards.  This is about increasing student engagement through gameful design.</p>
          <p><a href="http://conque.so/games-and-teaching-notes-for-a-manifesto/">Learn More</a></p>
        </div>
        <div class="span4">
          <h2>Test Drive</h2>
          <p>Curious what a Queso course looks like on the student end?  Try creating a student account and playing with our demo course.</p>
          <p><a class="btn" href="http://class.conque.so/register?id=HahFhAymysba">Try It</a></p>
       </div>
        <div class="span4">
          <h2>Get Involved</h2>
          <p>Queso is an open source project and completely free.  We host your classes on our site for free.  If you know a bit of PHP, why not help out?</p>
          <p><a class="btn" href="https://github.com/claytical/Queso-Multisite">Fork Us on Github</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>
@endsection