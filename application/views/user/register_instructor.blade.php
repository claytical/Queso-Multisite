@layout('layouts.notloggedin')
@section('content')
<h2>Instructor Registration</h2>
<p class="lead">Please enter your information below</p>

<div class="container">
<?php echo Form::open('register', 'POST', array('class' => 'form-horizontal')); ?>

    <div class="form-group">	
	    <?php echo Form::label('course', 'Course Name', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::text('course', '', array('class' => 'input-md form-control')); ?>
			</div>
	</div>
		
	<div class="form-group">	
	    <?php echo Form::label('firstname', 'First Name', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('firstname', '', array('class' => 'input-md form-control')); ?>
			</div>
	</div>


	<div class="form-group">	
	    <?php echo Form::label('lastname', 'Last Name', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::text('lastname', '', array('class' => 'input-md form-control')); ?>
			</div>
	</div>
	
	<div class="form-group">	
	    <?php echo Form::label('email', 'Email', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('email', '', array('class' => 'input-md form-control')); ?>
    		</div>
    </div>

	<div class="form-group">	
	    <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('password', array('class' => 'input-md form-control')); ?>
			</div>
	</div>

	<div class="form-group">	
	    <?php echo Form::label('password_confirm', 'Confirm Password', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::password('confirm_password', array('class' => 'input-md form-control')); ?>
			</div>
	</div>


    <div class="form-group">
	    {{ Form::submit('Register', array('class' => 'btn btn-primary pull-right btn-submit btn-lg', 'data-loading-text' => 'Registering...')); }}
    
        <?php echo Form::close(); ?>
 </div>
</div>
        @endsection

	