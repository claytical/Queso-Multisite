<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<!--<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap-wysihtml5.css') }}">-->
{{ Asset::container('bootstrapper')->styles(); }}
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!-- <script type="text/javascript" src="{{ URL::to('js/wysihtml5-0.3.0.min.js') }}"></script>  --> 
{{ Asset::container('bootstrapper')->scripts(); }} 
<link href='http://fonts.googleapis.com/css?family=Lato|Londrina+Solid|Londrina+Shadow' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
<script type="text/javascript" src="{{ URL::to('js/visualize.jQuery.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.tablesorter.widgets.js') }}"></script>
<!--<script type="text/javascript" src="{{ URL::to('js/bootstrap-wysihtml5.js') }}"></script>-->
<script type="text/javascript" src="{{ URL::to('js/bootstrap-slider.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize.css') }}">
<!--<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstro.min.css') }}">-->
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize-light.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/tablesorter.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/slider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/queso.css') }}">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

<link href="{{ URL::to('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::to('css/froala_editor.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::to('css/froala_reset.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{ URL::to('js/beautify-html.js')}}"></script>
<script src="{{ URL::to('js/froala_editor.min.js')}}"></script>
<!--[if lt IE 9]>
<script src="{{ URL::to('js/froala_editor_ie8.min.js')}}"></script>
<![endif]-->
<script src="{{ URL::to('js/plugins/tables.min.js')}}"></script>
<script src="{{ URL::to('js/plugins/colors.min.js')}}"></script>
<script src="{{ URL::to('js/plugins/fonts/fonts.min.js')}}"></script>
<script src="{{ URL::to('js/plugins/fonts/font_family.min.js')}}"></script>
<script src="{{ URL::to('js/plugins/fonts/font_size.min.js')}}"></script>
<script src="{{ URL::to('js/plugins/block_styles.min.js')}}"></script>
<script src="{{ URL::to('js/plugins/video.min.js')}}"></script>



<script>
filepicker.setKey('A3wHASwlySGqI2Krs6veZz');
</script>
  </head>
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
    
	<body>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-queso">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
            <a class="navbar-brand" href="{{ URL::base() }}">Queso</a>
        </div>
			  <div class="collapse navbar-collapse navbar-queso" role="navigation">
				<ul class="nav navbar-nav">
				@if(Session::get('current_course') && Sentry::check())
                    <li class="dropdown"><a class="visible-md visible-lg" href="{{ URL::to('posts') }}">{{ Session::get('course_name')}}</a>          
</li>
                    @if(Course::has_post_menu())
				  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Course::posts_name()}}</a>
					@render('posts.menu')
				  </li>
				  @endif				  
				@endif

				
				</ul>
					@render('user.menu')
			  </div><!--/.nav-collapse -->
			</div>
    <div class="row container">
        <div class="col-md-2">
            @render('user.sidebar')
            
        </div>
        <div class="col-md-10">
            @include('simplemessage::out')				
            @yield('content')
        </div>
    </div>
<script type="text/javascript" src="{{ URL::to('js/queso.js') }}"></script>
  </body>
</html>


