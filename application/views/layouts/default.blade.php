<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap-wysihtml5.css') }}">
{{ Asset::container('bootstrapper')->styles(); }}
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
 <script type="text/javascript" src="{{ URL::to('js/wysihtml5-0.3.0.min.js') }}"></script>   
{{ Asset::container('bootstrapper')->scripts(); }} 
<link href='http://fonts.googleapis.com/css?family=Lato|Londrina+Solid|Londrina+Shadow' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
<script type="text/javascript" src="{{ URL::to('js/visualize.jQuery.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.tablesorter.widgets.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap-wysihtml5.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap-slider.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstro.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize-light.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/tablesorter.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to_asset('chosen/chosen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/slider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/queso.css') }}">

<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<script>
filepicker.setKey('A3wHASwlySGqI2Krs6veZz');
</script>
  </head>
	<body>
	<div class="navbar navbar navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  @if(Session::get('current_course'))
			  <a class="brand" href="{{ URL::to('posts') }}">{{ Session::get('course_name')}}</a>
			  @else
			  <a class="brand" href="{{ URL::base() }}">Queso</a>
			  @endif
			  <div class="nav-collapse collapse">
				<ul class="nav">
				@if(Session::get('current_course') && Sentry::check())
				  @if(Course::has_post_menu())
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Posts</a>
					@render('posts.menu')
				  </li>
				  @endif
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Quests</a>
				  	<ul class="dropdown-menu">
				  		<li><a href="{{ URL::to('quests/in-class');}}">In Class</a></li>
				  		<li><a href="{{ URL::to('quests/online');}}">Online</a></li>
				  		<li><a href="{{ URL::to('quests/completed');}}">Completed</a></li>
				  	</ul>
				  
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Q&A</a>
				  	<ul class="dropdown-menu">
				  		<li><a href="{{ URL::to('question/ask');}}">New Question</a></li>
				  		<li><a href="{{ URL::to('questions');}}">Questions</a></li>
				  	</ul>
				  				  
				  </li>
				@endif

				@if(Course::is_instructor())

				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Lists</a>
				  	<ul class="dropdown-menu">
				  		<li><a href="{{ URL::to('admin/students');}}">Students</a></li>
				  		<li><a href="{{ URL::to('admin/quests');}}">Quests</a></li>
				  		<li><a href="{{ URL::to('admin/posts');}}">Posts</a></li>
				  	</ul>

				  </li>
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Grading</a>
				  	<ul class="dropdown-menu">
				  		<li><a href="{{ URL::to('admin/grade');}}">In Class Work</a></li>
				  		<li><a href="{{ URL::to('admin/submissions');}}">Online Submissions</a></li>
				  		<li><a href="{{ URL::to('admin/revisions');}}">Revisions</a></li>
				  	</ul>

				  </li>
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Create</a>
				  	<ul class="dropdown-menu">
				  		<li><a href="{{ URL::to('admin/quest/create');}}">Quest</a></li>
				  		<li><a href="{{ URL::to('admin/post/create');}}">Post</a></li>
				  	</ul>

				  </li>
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Setup</a>
				  	<ul class="dropdown-menu">
				  		<li><a href="{{ URL::to('admin/course');}}">Information</a></li>
				  		<li><a href="{{ URL::to('admin/skills');}}">Skills</a></li>
				  		<li><a href="{{ URL::to('admin/levels');}}">Levels</a></li>
				  		<li class="divider"></li>
				  		<li><a href="{{ URL::to('admin/course/share');}}">Share Course</a></li>
				  		<li><a href="{{ URL::to('admin/course/new');}}">New Course</a></li>
				  	</ul>
				  </li>

				  @endif				
				
				</ul>
					@render('user.menu')
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				@render('user.sidebar')
				
			</div>
			<div class="span10">
				@include('simplemessage::out')				
		    	@yield('content')
			</div>
		</div>
    </div>
<script src="{{ URL::to_asset('chosen/chosen.jquery.min.js') }}"></script> 
<script type="text/javascript" src="{{ URL::to('js/queso.js') }}"></script>

  </body>
</html>


