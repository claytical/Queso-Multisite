@layout('layouts.default')
@section('content')

<h2>Cloning {{$quest->name}}</h2>
<div class="container">
		{{ Form::open('admin/quest/clone', 'POST', array('class' => 'form-horizontal', 'id' => 'clone-quest')); }}

	
	
	<div class="form-group">	

		<div class="controls">
		    {{ Form::text('title', '', array('placeholder' => 'Quest Name', 'class' => 'input-md form-control', 'id' => 'quest-name', 'required' => '', 'title' => 'Quest name')); }}
		</div>
		
		<div class="controls">
		    {{ Form::textarea('body', $quest->instructions, array('placeholder' => 'Instructions go here...', 'class' => 'wysiwyg-area form-control', 'id' => 'quest-instructions', 'required' => '', 'style' => 'width: 100%', 'title' => 'Quest instructions')); }}
		    {{ Form::hidden('quest_id', $quest->id)}}
		</div>

	
	</div>
    <div class="form-group">
	    <?php echo Form::submit('Clone Quest', array('class' => 'btn btn-primary pull-right btn-lg validated-submission'));?>
	</div>


<?php echo Form::close(); ?>
</div>
    @endsection