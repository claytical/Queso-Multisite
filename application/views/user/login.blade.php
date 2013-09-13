@layout('layouts.notloggedin')
@section('content')
<h2>Login</h2>
<?php echo Form::open('login', 'POST', array('class' => 'well')); ?>
    <p>
        Don't have an account? <a href="{{URL::to('register')}}" class="">Register Now!</a>
     </p>
     <p>
        Forgot your password? <a href="{{URL::to('forgot')}}" class="">Reset It</a> 
    </p>
    </div>
    <!-- username field -->
    <?php echo Form::label('email', 'Email Address'); ?>
    @if(Cookie::get('remember'))
    <?php echo Form::text('email', Cookie::get('email')); ?>
    <!-- password field -->
    @else
    <?php echo Form::text('email', '', array('autocomplete' => 'off')); ?>
    @endif
    <?php echo Form::label('password', 'Password'); ?>
    <?php echo Form::password('password'); ?>
    <label class="checkbox">
    @if(Cookie::get('remember'))    
    <?php echo Form::checkbox('remember', 1, true); ?>
    @else
    <?php echo Form::checkbox('remember', 1, false); ?>        
    @endif
        Remember Me</label>
    
<!-- login button -->

    <div class="form-actions">

<?php echo Form::submit('Login', array('class' => 'btn btn-primary btn-large pull-right'));?>
	</div>
<?php echo Form::close(); ?>
@endsection