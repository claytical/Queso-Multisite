@layout('layouts.default')
@section('content')
<h1>Change User Password</h1>
<?php echo Form::open('admin/user/changepw', 'POST', array('class' => 'form-horizontal well')); ?>
	<fieldset>
	
	<div class="control-group">	
	    <?php echo Form::label('password', 'New Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password'); ?>
			    <?php echo Form::hidden('user', $user->id); ?>
			</div>
	</div>

	<hr>
    <!-- login button -->
    <?php echo Form::submit('Change Password', array('class' => 'btn btn-primary pull-right btn-lg'));?>
	</fieldset>
<?php echo Form::close(); ?>
@endsection