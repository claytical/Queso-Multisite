@layout('layouts.default')
@section('content')
<h2>Change Password</h2>
<div class="container">
<?php echo Form::open('user/changepw', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="form-group">	
	    <?php echo Form::label('password', 'Old Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password_old', array('class' => 'form-control input-md')); ?>
			</div>
	</div>
	

	<div class="form-group">	
	    <?php echo Form::label('password', 'New Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password',  array('class' => 'form-control input-md')); ?>
			</div>
	</div>


	<div class="form-group">	
	    <?php echo Form::label('password_confirm', 'Confirm Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password_confirm',  array('class' => 'form-control input-md')); ?>
			</div>
	</div>
    <div class="form-group">
        <?php echo Form::submit('Change Password', array('class' => 'btn btn-primary pull-right btn-lg'));?>
    </div>
<?php echo Form::close(); ?>
</div>
@endsection