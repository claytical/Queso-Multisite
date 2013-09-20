@layout('layouts.default')
@section('content')

		<h2>Cloning {{$quest->name}}</h2>

		{{ Form::open('admin/quest/clone', 'POST', array('class' => 'well', 'id' => 'clone-quest')); }}

	
	
	<div class="control-group">	
	<fieldset>

		<div class="controls">
		    {{ Form::text('title', '', array('placeholder' => 'Quest Name', 'class' => 'input-lg', 'id' => 'quest-name', 'required' => '', 'title' => 'Quest name')); }}
		</div>
		
		<div class="controls">
		    {{ Form::textarea('body', $quest->instructions, array('placeholder' => 'Instructions go here...', 'class' => 'wysiwyg-area', 'id' => 'quest-instructions', 'required' => '', 'style' => 'width: 98%', 'title' => 'Quest instructions')); }}
		    {{ Form::hidden('quest_id', $quest->id)}}
		</div>

	
	</fieldset>

	</div>

	<div class="form-actions">
	    <?php echo Form::submit('Clone Quest', array('class' => 'btn btn-primary pull-right btn-large validated-submission'));?>
	</div>


<?php echo Form::close(); ?>
@endsection