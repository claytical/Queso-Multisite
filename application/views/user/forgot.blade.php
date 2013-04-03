@layout('layouts.notloggedin')
@section('title')
Forgot Password
@endsection
@section('content')
<h2>Forgot Password</h2>
<?php echo Form::open('forgot', 'POST', array('class' => 'well')); ?>
    <!-- username field -->
    <?php echo Form::label('email', 'Email Address'); ?>
    <?php echo Form::text('email'); ?>
    <!-- password field -->
    <?php echo Form::label('password', 'New Password'); ?>
    <?php echo Form::password('password'); ?>

	<div class="form-actions">

			<?php echo Form::submit('Reset Password', array('class' => 'btn btn-primary btn-large pull-right'));?>
	</div>
<?php echo Form::close(); ?>
@endsection