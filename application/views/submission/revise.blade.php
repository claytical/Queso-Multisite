@layout('layouts.default')
@section('title')
Revising {{$data->quest->name}}
@endsection
@section('content')
<h2>{{$data->quest->name}}</h2>

        @if($data->submission->revision == 0 && !$data->revisions)
				<span class="label label-info pull-right visible-md visible-lg">First Attempt</span>
			@else
				<div class="btn-group pull-right visible-md-visible-lg">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					@if($data->submission->revision == 0)
					  First Attempt
					@else
					  Revision #{{$data->submission->revision}}
					@endif
					
					 
					  <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
					  @foreach($data->revisions as $revision)
					  	@if($revision->revision == count($data->revisions)-1)
					  	
						  <li><a href="{{ URL::to('submission/revise/'.$revision->id)}}">Revise Latest Version</a></li>					  	
					  	@else
					  		@if($revision->revision == 0)
							  <li><a href="{{ URL::to('submission/view/'.$revision->id)}}">Original Submission</a></li>					  	
					  		@else					  		
							  <li><a href="{{ URL::to('submission/view/'.$revision->id)}}">Submission <span class="label label-info">#{{$revision->revision}}</span> {{date("j/n/Y g:ia", strtotime($revision->created_at))}}</a></li>					  	
							@endif
					  	@endif
					  	
					  @endforeach
					</ul>
				  </div>
			@endif


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
@if($data->submission->filename)
<h4>Attached Files</h4>
<div>
<p>
	@foreach(explode(",",$data->submission->filename) as $file)
	<a class="btn btn-info btn-xs" target="_blank" href="{{$file}}">{{Filepicker::metadata($file)->filename}}</a>
	@endforeach
</p>
</div>
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