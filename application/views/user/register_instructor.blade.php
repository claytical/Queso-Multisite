@layout('layouts.notloggedin')
@section('content')
<h2>Instructor Registration</h2>
<p class="lead">Please enter your information below</p>
<?php echo Form::open('register/instructor', 'POST', array('class' => 'form-horizontal well')); ?>
	<fieldset>
		
	<div class="control-group">	
	    <?php echo Form::label('course', 'Course Name', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::text('course'); ?>
			</div>
	</div>

	<div class="control-group">	
	    <?php echo Form::label('firstname', 'First Name', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('firstname'); ?>
			</div>
	</div>


	<div class="control-group">	
	    <?php echo Form::label('lastname', 'Last Name', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::text('lastname'); ?>
			</div>
	</div>
	
	<div class="control-group">	
	    <?php echo Form::label('email', 'Email', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('email'); ?>
    		</div>
    </div>

	<div class="control-group">	
	    <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password'); ?>
			</div>
	</div>

	<div class="control-group">	
	    <?php echo Form::label('password_confirm', 'Confirm Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('confirm_password'); ?>
			</div>
	</div>


	<div class="form-actions">
    <!-- login button -->
    <?php echo Form::submit('Register', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection