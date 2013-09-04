@layout('layouts.default')
@section('content')
<?php
	$created_date = strtotime($data['submission']->created_at);
 ?>
	<div class="row-fluid">
		<div class="span9">
			<h2>{{$data['quest']->name}}</h2>
			{{$data['quest']->instructions}}
		</div>
		<div class="span3 well pull-right">
			@if($data['submission']->revision ==0)
				<span class="label label-info">First Attempt</span>
			@else
				<span class="label label-info">Revision: #{{$data['submission']->revision}}</span>
			@endif
			<h6>{{date("F j, Y", $created_date);}}</h6>
		</div>
	</div>
	<hr>
	<div class="row-fluid">
		{{$data['submission']->submission}}
		@if($data['submission']->filename)
		<ul class="inline">
		@foreach(explode(",", $data['submission']->filename) as$file)
			<li><a class="btn btn-info" href="{{$file}}">{{Filepicker::metadata($file)->filename}}</a></li>
		@endforeach
		</ul>
		@endif
	</div>
	<div class="row-fluid">
	<?php echo Form::open('admin/submission/grade', 'POST', array('class' => '')); ?>
	<h4>Notes</h4>


	<fieldset>
		{{ Form::textarea('notes', '', array('placeholder' => 'Your feedback to the student...', 'class' => 'wysiwyg-area', 'id' => 'grade-notes', 'style' => 'width: 98%')); }}

	<div class="control-group">
	    <?php echo Form::submit('Grade', array('class' => 'btn btn-primary pull-right btn-large btn-submit', 'data-loading-text' => 'Grading...'));?>
	@foreach($data['rewards'] as $reward)
		<div class="controls" style="margin-bottom: 10px">
		<?php echo Form::label('reward', $reward->name, array('class' => 'control-label', 'style' => '')); ?>
		{{ Form::text('rewards['.$reward->id.']', '', array('data-slider-min' => $reward->rewards['Minimum'], 'data-slider-max' => $reward->rewards['Maximum'], 'data-slider-step' => 1, 'class' => 'slider'))}}

		</div>		
	@endforeach
	</div>
	</fieldset>
		<?php echo Form::hidden('submission_id', $data['submission']->id); ?>
		<?php echo Form::hidden('quest_type', $data['quest']->type); ?>
		<?php echo Form::hidden('quest_id', $data['submission']->quest_id); ?>
		<?php echo Form::hidden('user_id', $data['submission']->user_id); ?>

		<?php echo Form::close(); ?>
	</div>
	<hr>
	@if($data['comments'])
		<h4>Previous Notes</h4>
		@foreach($data['comments'] as $comment)
		<?php $comment_date = strtotime($comment->created_at);?>
		<blockquote>
			<p>{{$comment->comment}}</p>
			<small>{{date("F j, Y", $comment_date);}}</small>	
		</blockquote>
		@endforeach
	@endif
@endsection