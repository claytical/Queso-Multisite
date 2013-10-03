@layout('layouts.default')
@section('content')
		<h2>Ask a Question</h2>
<div class="container">
	<?php echo Form::open('question/ask', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="form-group">	
			<div class="controls">
				    {{ Form::textarea('question', '', array('placeholder' => "What's your question?", 'class' => 'wysiwyg-area form-control', 'id' => 'question-content', 'style' => 'width: 100%')); }}
			</div>
	</div>
		
	
	<div class="form-group">
	    <?php echo Form::submit('Ask', array('class' => 'btn btn-primary pull-right'));?>
	</div>

        <?php echo Form::close(); ?>
</div>
@endsection