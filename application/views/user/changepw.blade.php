@layout('layouts.noclass')
@section('content')
<h1>Change Password</h1>
<?php echo Form::open('user/changepw', 'POST', array('class' => 'form-horizontal well')); ?>
	<fieldset>
	
	<div class="control-group">	
	    <?php echo Form::label('password', 'Old Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password_old'); ?>
			</div>
	</div>
	

	<div class="control-group">	
	    <?php echo Form::label('password', 'New Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password'); ?>
			</div>
	</div>


	<div class="control-group">	
	    <?php echo Form::label('password_confirm', 'Confirm Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password_confirm'); ?>
			</div>
	</div>

	<hr>
    <!-- login button -->
    <?php echo Form::submit('Change Password', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
<?php echo Form::close(); ?>

@endsection