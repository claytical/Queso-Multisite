<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
{{ Asset::container('bootstrapper')->styles(); }}
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
{{ Asset::container('bootstrapper')->scripts(); }} 
<script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
<script type="text/javascript" src="{{ URL::to('js/visualize.jQuery.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.tablesorter.widgets.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap-wysihtml5.js') }}"></script>

<script type="text/javascript" src="{{ URL::to('js/bootstro.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap-slider.js') }}"></script>

<link href='http://fonts.googleapis.com/css?family=Lato|Londrina+Solid|Londrina+Shadow' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstro.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize-light.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/tablesorter.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to_asset('chosen/chosen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/queso.css') }}">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  </head>
	<body>
	<div class="navbar navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			 
			  <div class="nav-collapse collapse">
					@render('user.menu')
			  </div><!--/.nav-collapse -->

			</div>
		  </div>
		</div>
	<div class="container-fluid">
		<div class="row-fluid">
					@include('simplemessage::out')				
		        	@yield('content')
		</div>
    </div>
<script src="{{ URL::to_asset('chosen/chosen.jquery.min.js') }}"></script> 
<script type="text/javascript" src="{{ URL::to('js/queso.js') }}"></script>

  </body>
</html>


