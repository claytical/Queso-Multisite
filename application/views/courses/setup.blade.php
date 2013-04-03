@layout('layouts.default')
@section('content')
@if($course->alert)
 <div class="alert success">
	 <button type="button" class="close" data-dismiss="alert">&times;</button>
  		{{$course->alert}}
  </div>
@endif
<h2>Course Information</h2>
<?php echo Form::open('admin/course', 'POST', array('class' => 'well form-horizontal')); ?>
<fieldset>
	<div class="control-group">	
	    <?php echo Form::label('course', 'Course Name', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('course', $course->name, array('placeholder' => 'Course Name', 'class' => 'input-large')); ?>
			</div>
	</div>

	<div class="control-group">	
	    <?php echo Form::label('dropdown', 'Custom Dropdown Text', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('dropdown', $course->dropdown, array('placeholder' => 'Posts', 'class' => 'input-large')); ?>
			</div>
	</div>
	
	<div class="form-actions">
		    	<?php echo Form::submit('Update Course', array('class' => 'btn btn-primary pull-right'));?>		
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection