@layout('layouts.default')
@section('title')
Revising {{$data->quest->name}}
@endsection
@section('content')
<h2>{{$data->quest->name}}</h2>
<span class="label label-info pull-right">Revision #{{$data->submission->revision + 1}}</span>
{{$data->quest->instructions}}
@if(!empty($data->comments))
	<h4>Notes on Quest</h4>
	@foreach($data->comments as $comment)
	<?php $comment_date = strtotime($comment->created_at);?>
	<blockquote>
		<p>{{$comment->comment}}</p>
		<small>{{date("F j, Y", $comment_date);}}</small>	
	</blockquote>
	@endforeach
@endif

<?php echo Form::open('quest/attempt', 'POST', array('class' => '')); ?>
<?php echo Form::hidden('revision',$data->submission->revision+1); ?>

	<fieldset>
		<div class="control-group">
			<div class="controls">

			@if ($data->quest->allow_upload)
				<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
				<br/>
			@endif

			@if ($data->quest->allow_text)
			    {{ Form::textarea('body', $data->submission->submission, array('placeholder' => 'Starting over?', 'class' => 'wysiwyg-area form-control', 'id' => 'submission-attempt', 'required' => '', 'style' => 'width: 98%')); }}
			@endif
	
			</div>
	</div>
	
		<div class="control-group">

			<div class="controls">
				<label class="checkbox"><?php echo Form::checkbox('visible', '1'); ?> Visible to Other Students</label>
			</div>

		</div>

	
		<?php echo Form::hidden('quest_id', $data->quest->id); ?>
		<?php echo Form::hidden('group_id', $data->quest->group_id); ?>

		<?php echo Form::hidden('quest_type', $data->quest->type); ?>
	    <?php echo Form::submit('Revise', array('class' => 'btn btn-primary pull-right btn-large btn-submit', "data-loading-text" => "Revising..."));?>
	</fieldset>
<?php echo Form::close(); ?>

@endsection