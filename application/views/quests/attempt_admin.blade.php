@layout('layouts.default')
@section('title')
Attempting {{$data['quest']->name}}
@endsection
@section('content')
<h2>{{$data['quest']->name}}</h2>
	{{$data['quest']->instructions}}
@if($data['quest']->filename)
	<h6>Files</h6>
		<ul class="list-inline">
		@foreach(explode(",",$data['quest']->filename) as $file)
			<li>
			<a class='btn btn-sm btn-info pull-right' href='{{$file}}'>{{Filepicker::metadata($file)->filename}}</a>
			</li>
		@endforeach
	</ul>
@endif
	
<hr>
<?php echo Form::open('quest/attempt', 'POST', array('class' => '')); ?>
	<fieldset>
			<div class="controls">
				{{ Form::select('student', $data['users'], '', array('class' => 'selectpicker', 'data-placeholder' => 'Select Students', 'tabindex' => '-1')) }}	
			</div>

			<div class="control-group">
				<div class="controls">
	@if ($data['quest']->allow_text)
			    {{ Form::textarea('body', '', array('placeholder' => 'Ready when you are...', 'class' => 'wysiwyg-area', 'id' => 'submission-attempt', 'style' => 'width: 98%')); }}
	@endif

	@if ($data['quest']->allow_upload)
					<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
	@endif

	
				</div>
		</div>
	

		<div class="control-group">

			<div class="controls">
				<label class="checkbox"><?php echo Form::checkbox('visible', '1'); ?> Visible to Other Students</label>
			</div>

		</div>

	
		<?php echo Form::hidden('quest_id', $data['quest']->id); ?>
		<?php echo Form::hidden('group_id', $data['quest']->group_id); ?>

		<?php echo Form::hidden('quest_type', $data['quest']->type); ?>
	    <?php echo Form::submit('Submit', array('class' => 'btn btn-primary pull-right btn-large btn-submit', 'data-loading-text'=>'Submitting...'));?>
	</fieldset>
<?php echo Form::close(); ?>

@endsection