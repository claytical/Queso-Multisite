@layout('layouts.default')
@section('content')
<h2>Skills</h2>
<p class="lead">
Queso uses skills as a metric for student achievement.  Points are awarded in specific skills to students for completing quests.  The amount awarded in each quest can vary.  If you're used to traditional methods of grading, you might only want to have one skill.
</p>
<?php echo Form::open('admin/skills', 'POST', array('class' => 'form-horizontal')); ?>
	<div class="form-group">	
			<div class="controls">
			    <?php echo Form::text('skill', '', array('placeholder' => 'Name of skill', 'class' => 'input-md form-control')); ?>
			</div>
	</div>
	
	<div class="form-group">
	    <?php echo Form::submit('Create Skill', array('class' => 'btn btn-primary pull-right'));?>
	</div>
<?php echo Form::close(); ?>
	

@endsection