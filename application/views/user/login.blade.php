@layout('layouts.notloggedin')
@section('content')
<h2>Login</h2>
<div class="container">
    <div class="row">
        <?php echo Form::open('login', 'POST', array('class' => 'form-horizontal')); ?>
        <?php echo Form::label('email', 'Email Address'); ?>
    @if(Cookie::get('remember'))
    <?php echo Form::text('email', Cookie::get('email'), array('class'=> 'form-control input-md')); ?>
    @else
    <?php echo Form::text('email', '', array('autocomplete' => 'off', 'class' => 'input-md form-control')); ?>
    @endif
    <?php echo Form::label('password', 'Password'); ?>
    <?php echo Form::password('password', array('class' => 'form-control input-md')); ?>
<label class="checkbox">
    @if(Cookie::get('remember'))    
    <?php echo Form::checkbox('remember', 1, true); ?>
    @else
    <?php echo Form::checkbox('remember', 1, false); ?>        
    @endif
        Remember Me</label>
<?php echo Form::submit('Login', array('class' => 'btn btn-primary btn-lg pull-right'));?>
<?php echo Form::close(); ?>
    </div>
    <div class="row well">
    <p class="help-text">
        Don't have an account? <a href="{{URL::to('register')}}" class="">Register Now</a>
     </p>
     <p class="help-text">
        Forgot your password? <a href="{{URL::to('forgot')}}" class="">Reset It</a> 
    </p>
    </div>
</div>
@endsection