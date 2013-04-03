@layout('layouts.default')
@section('content')
<h1>Levels</h1>
<p class="lead">
Levels act as a grading system for your students.  If you are only using one skill, the amount of points earned in that skill determine the level.  When using multiple skills, the level is calculated by the using amount of points earned for the lowest skill.
</p>
<?php echo Form::open('admin/levels', 'POST', array('class' => 'well')); ?>
<fieldset>
	<div class="control-group">	
			<div class="controls">
			    <?php echo Form::text('label', '', array('placeholder' => 'Level Name', 'class' => 'input-xlarge')); ?>
			    <?php echo Form::text('amount', '', array('placeholder' => 'Points Required', 'class' => 'input-xlarge')); ?>
			</div>
	</div>
	
	<div class="form-actions">
		    	<?php echo Form::submit('Add This Level', array('class' => 'btn btn-primary pull-right'));?>		
	</fieldset>
	</div>
<?php echo Form::close(); ?>
	

@endsection