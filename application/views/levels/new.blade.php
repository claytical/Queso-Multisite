@layout('layouts.default')
@section('content')
<h2>Levels</h2>
<p class="lead">
Levels act as a grading system for your students.  If you are only using one skill, the amount of points earned in that skill determine the level.  When using multiple skills, the level is calculated by the using amount of points earned for the lowest skill.
</p>
<?php echo Form::open('admin/levels', 'POST', array('class' => 'form-horizontal')); ?>
	<div class="form-group">	
			<div class="controls">
			    <?php echo Form::text('label', '', array('placeholder' => 'Level Name', 'class' => 'input-md form-control')); ?>
			    <?php echo Form::text('amount', '', array('placeholder' => 'Points Required', 'class' => 'input-md form-control')); ?>
			</div>
	</div>
	
	<div class="form-group">
		    	<?php echo Form::submit('Add This Level', array('class' => 'btn btn-primary pull-right'));?>		
	</div>
<?php echo Form::close(); ?>
	

@endsection