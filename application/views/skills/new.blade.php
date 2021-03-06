@layout('layouts.default')
@section('content')
<h1>Skills</h1>
<p class="lead">
Queso uses skills as a metric for student achievement.  Points are awarded in specific skills to students for completing quests.  The amount awarded in each quest can vary.  If you're used to traditional methods of grading, you might only want to have one skill.
</p>
<?php echo Form::open('admin/skills', 'POST', array('class' => 'well')); ?>
<fieldset>
	<div class="control-group">	
			<div class="controls">
			    <?php echo Form::text('skill', '', array('placeholder' => 'Name of skill', 'class' => 'input-lg')); ?>
			</div>
	</div>
	
	<div class="form-actions">
	    <?php echo Form::submit('Create Skill', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</div>
    </fieldset>
<?php echo Form::close(); ?>
	

@endsection