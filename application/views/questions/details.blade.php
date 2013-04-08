@layout('layouts.default')
@section('content')

		<h2>Question</h2>
		<div class="row-fluid">{{$question->question}}</div>
		@if($question->answers)
			<h4>Answers</h4>
				<div class="row-fluid">
	        		@foreach($question->answers as $answer)
	        			<a href="{{URL::to('answer/'.$answer->id.'/thanks')}}" class='btn btn-success pull-right'>
	        				<i class="icon-white icon-thumbs-up"></i>
		        			@if($answer->thanks > 0)
	        					{{$answer->thanks}}
							@endif
						</a>
						<blockquote>
							<p>{{$answer->answer}}</p>
							<small>{{$answer->username}}</small>	
						</blockquote>
					@endforeach
					</div>

		@endif
	<h3>Your Answer</h3>
	<?php echo Form::open('question/'.$question->id, 'POST', array('class' => 'well')); ?>
	<fieldset>
	
	
	<div class="control-group">	
			<div class="controls">
				    {{ Form::textarea('answer', '', array('placeholder' => "Do you have anything to add?", 'class' => 'wysiwyg-area', 'id' => 'answer', 'style' => 'width: 98%')); }}
			</div>
	</div>
		
	
	<div class="form-actions">
	    <?php echo Form::submit('Answer', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection