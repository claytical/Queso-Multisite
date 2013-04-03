@layout('layouts.default')
@section('content')
<h1>Course Code Generation</h1>
<?php echo Form::open('admin/course/generate', 'POST', array('class' => 'well form-horizontal')); ?>
<fieldset>
	<div class="control-group">	
	    <?php echo Form::label('course', 'Course Name', array('class' => 'control-label')); ?>
			<div class="controls">
				{{ Form::select('course', $courses) }}
			</div>
	</div>

	
	<div class="form-actions">
		    	<?php echo Form::submit('Update Course', array('class' => 'btn btn-primary pull-right'));?>		
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection