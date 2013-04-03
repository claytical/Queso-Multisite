@layout('layouts.default')
@section('content')
<h2>Add a Course</h2>
<?php echo Form::open('user/add', 'POST', array('class' => 'form-horizontal well')); ?>
	<fieldset>
	
	<div class="control-group">	
	    <?php echo Form::label('regcode', 'Registration Code', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('regcode'); ?>
			</div>
	</div>
	

	<hr>
    <!-- login button -->
    <?php echo Form::submit('Add Course', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
<?php echo Form::close(); ?>

@endsection