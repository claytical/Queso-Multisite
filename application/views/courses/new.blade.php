@layout('layouts.default')
@section('content')
<h2>New Course</h2>
<?php echo Form::open_for_files('admin/course/new', 'POST', array('class' => 'well form-horizontal')); ?>
<fieldset>
	<div class="control-group">	
	    <?php echo Form::label('course', 'Name the course', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::text('course'); ?>
			</div>
	</div>

	<div class="control-group">	
	    <?php echo Form::label('course_file', 'Or upload an exported course file', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::file('course_file'); ?>
			</div>
	</div>

	
	<div class="form-actions">
		    	<?php echo Form::submit('Create Course', array('class' => 'btn btn-primary pull-right'));?>		
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection