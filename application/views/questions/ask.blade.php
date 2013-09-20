@layout('layouts.default')
@section('content')
		<h2>Ask a Question</h2>
	<?php echo Form::open('question/ask', 'POST', array('class' => 'well')); ?>
	<fieldset>
	
	
	<div class="control-group">	
			<div class="controls">
				    {{ Form::textarea('question', '', array('placeholder' => "What's your question?", 'class' => 'wysiwyg-area', 'id' => 'question-content', 'style' => 'width: 98%')); }}
			</div>
	</div>
		
	
	<div class="form-actions">
	    <?php echo Form::submit('Ask', array('class' => 'btn btn-primary pull-right btn-lg'));?>
	</div>
	</fieldset>

        <?php echo Form::close(); ?>

@endsection