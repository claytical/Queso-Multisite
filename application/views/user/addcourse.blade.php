@layout('layouts.default')
@section('content')
<h2>Add a Course</h2>
<div class="container">
<?php echo Form::open('user/add', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="form-group">	
	    <?php echo Form::label('regcode', 'Registration Code', array('class' => 'control-label')); ?>
			<div class="controls">
			    <?php echo Form::text('regcode', '', array('class' => 'form-control input-md')); ?>
			</div>
	</div>
	

	<hr>
<div class="form-group">
<?php echo Form::submit('Add Course', array('class' => 'btn btn-primary pull-right btn-lg'));?>
</div>
    <?php echo Form::close(); ?>
</div>
@endsection