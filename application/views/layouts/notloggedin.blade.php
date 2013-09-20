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
<link href='http://fonts.googleapis.com/css?family=Lato|Londrina+Solid|Londrina+Shadow' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstro.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/visualize-light.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/tablesorter.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to_asset('chosen/chosen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/queso.css') }}">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  </head>
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
	<body>
    
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="{{ URL::base() }}">Queso</a>
            </div>


	<ul class="nav navbar-nav pull-right">
        <li><a href="{{URL::to('register')}}">Sign Up</a></li>
        <li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
						<div class="dropdown-menu">
                            <div class="container">
							<?php echo Form::open('login', 'POST'); ?>
								    <!-- username field -->
                                    <?php echo Form::label('email', 'Email Address'); ?>
                                    @if(Cookie::get('remember'))
                                    <?php echo Form::text('email', Cookie::get('email'), array('class' => 'input-sm form-control')); ?>
                                    <!-- password field -->
                                    @else
                                    <?php echo Form::text('email', '', array('autocomplete' => 'off', 'class' => 'input-sm form-control')); ?>
                                    @endif
                                    <?php echo Form::label('password', 'Password'); ?>
                                    <?php echo Form::password('password', array('class' => 'input-sm form-control')); ?>
                                    <div class="checkbox" style="width: 200px">
                                        <label>
                                        @if(Cookie::get('remember'))    
                                        <?php echo Form::checkbox('remember', 1, true); ?>
                                        @else
                                        <?php echo Form::checkbox('remember', 1, false); ?>        
                                        @endif
                                            Remember Me</label>
                                    </div>

								<input class="btn btn-primary btn-block" type="submit" id="login" value="Login">
                            <?php echo Form::close(); ?>

                            <p class="help-block"><a href="{{URL::to('forgot')}}" class="">Reset Password</a></p>
                            </div>
                        </div>
					</li>
                </ul>
            
        </div>
    </div>
    <div class="container">
		<div class="row">
					@include('simplemessage::out')				
		        	@yield('content')
		</div>
    </div>
<script src="{{ URL::to_asset('chosen/chosen.jquery.min.js') }}"></script> 
  </body>
</html>


