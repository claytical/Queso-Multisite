@layout('layouts.default')
@section('content')
<h2>Creating a New Course</h2>
<?php echo Form::open('admin/course/new', 'POST', array('class' => 'well form-horizontal')); ?>
<fieldset>
	<div class="control-group">	
	    <?php echo Form::label('course', 'Name', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::text('course'); ?>
			</div>
	</div>

	
	<div class="form-actions">
		    	<?php echo Form::submit('Create Course', array('class' => 'btn btn-primary pull-right'));?>		
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection