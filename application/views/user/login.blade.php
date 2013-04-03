@layout('layouts.notloggedin')
@section('content')
<h1>Login</h1>
<?php echo Form::open('login', 'POST', array('class' => 'well')); ?>
    <p>
        Don't have an account? <a href="{{URL::to('register')}}" class="">Register Now!</a>
     </p>
     <p>
        Forgot your password? <a href="{{URL::to('register')}}" class="">Reset It</a> 
    </p>
    </div>
    <!-- username field -->
    <?php echo Form::label('email', 'Email Address'); ?>
    <?php echo Form::text('email'); ?>
    <!-- password field -->
    <?php echo Form::label('password', 'Password'); ?>
    <?php echo Form::password('password'); ?>
    <!-- login button -->
	<div class="form-actions">

			<?php echo Form::submit('Login', array('class' => 'btn btn-primary btn-large pull-right'));?>
	</div>
<?php echo Form::close(); ?>
@endsection