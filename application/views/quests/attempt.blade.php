@layout('layouts.default')
@section('title')
Attempting {{$quest->name}}
@endsection
@section('content')
<h2>{{$quest->name}}</h2>
	{{$quest->instructions}}
<hr>
<?php echo Form::open('quest/attempt', 'POST', array('class' => '')); ?>
	<fieldset>
			<div class="control-group">
				<div class="controls">
	@if ($quest->allow_text)
			    {{ Form::textarea('body', '', array('placeholder' => 'Ready when you are...', 'class' => 'wysiwyg-area', 'id' => 'submission-attempt', 'style' => 'width: 98%')); }}
	@endif

	@if ($quest->allow_upload)
					<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
	@endif

	
				</div>
		</div>
	

		<div class="control-group">

			<div class="controls">
				<label class="checkbox"><?php echo Form::checkbox('visible', '1'); ?> Visible to Other Students</label>
			</div>

		</div>

	
		<?php echo Form::hidden('quest_id', $quest->id); ?>
		<?php echo Form::hidden('quest_type', $quest->type); ?>
	    <?php echo Form::submit('Submit', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
<?php echo Form::close(); ?>

@endsection