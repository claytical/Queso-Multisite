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
{{ Asset::container('ckeditor')->scripts(); }}
<script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to_asset('chosen/chosen.css') }}">
  </head>
	<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			 
			  <a class="brand" href="{{ URL::base() }}">Queso</a>
			  <div class="nav-collapse collapse">
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</div>
	<div class="container-fluid">
		<div class="row-fluid">
		        	@yield('content')
		</div>
    </div>
<script src="{{ URL::to_asset('chosen/chosen.jquery.min.js') }}"></script> 
  </body>
</html>


