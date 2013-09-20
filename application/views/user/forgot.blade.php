@layout('layouts.notloggedin')
@section('title')
Forgot Password
@endsection
@section('content')
<h2>Forgot Password</h2>
<div class="container">
<?php echo Form::open('forgot', 'POST', array('class' => 'form-horizontal')); ?>
<div class="form-group">
    <?php echo Form::label('email', 'Email Address'); ?>
    <?php echo Form::text('email', '', array('class' => 'input-md form-control')); ?>
</div>
    <!-- password field -->
<div class="form-group">

    <?php echo Form::label('password', 'New Password'); ?>
    <?php echo Form::password('password', array('class' => 'input-md form-control')); ?>
</div>
<div class="form-group">
    <?php echo Form::submit('Reset Password', array('class' => 'btn btn-primary btn-lg pull-right'));?>
    </div>
<?php echo Form::close(); ?>
</div>
    @endsection