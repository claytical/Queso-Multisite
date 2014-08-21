@layout('layouts.default')
@section('content')

<div class="container">
<h2>Bug Report</h2>
<?php echo Form::open('report', 'POST', array('class' => 'form-horizontal')); ?>

	<div class="form-group">	
			<div class="controls">
            {{ Form::text('subject', '', array('placeholder' => 'What seems to be the problem?', 'class' => 'input-md form-control')); ?>
			</div>
	</div>
	
	<div class="form-group">	
			<div class="controls">
				{{ Form::textarea('bug', '', array('placeholder' => 'Any details would be helpful...', 'class' => 'wysiwyg-area form-control', 'id' => 'bug-instructions', 'style' => 'width: 100%')); }}
			</div>
	</div>
	

	<hr>
<div class="form-group">
	<?php echo Form::submit('Submit Bug', array('class' => 'btn btn-primary pull-right btn-lg'));?>
</div>
    <?php echo Form::close(); ?>
</div>


@endsection