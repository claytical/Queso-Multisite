@layout('layouts.default')
@section('content')
		<h2>Updating Post</h2>
	<?php echo Form::open('admin/post/update', 'POST', array('class' => 'well')); ?>
	<fieldset>
	
	
	<div class="control-group">	
			<div class="controls">
			    <?php echo Form::text('headline', $post->headline, array('placeholder' => 'Headline', 'class' => 'input-xxlarge')); ?>
			    <?php echo Form::hidden('post_id', $post->id); ?>

			</div>
	</div>

	<div class="control-group">	
			<div class="controls">
				{{ Form::textarea('body', $post->post, array('placeholder' => 'Post content goes here...', 'class' => 'wysiwyg-area', 'id' => 'post-content', 'required' => '', 'style' => 'width: 98%')); }}
			</div>
	</div>
	
		<div class="control-group">
			@if($post->files)
				<ul class="inline">
				@foreach($post->files as $file)
					<li>{{$file['friendly']}} {{ Form::hidden('existingFiles[]', $file['encoded'])}} <a class="btn btn-danger btn-mini btn-remove-file" href=''><i class="icon-remove icon-white"></i></a></li>
				@endforeach
				</ul>
			@endif
			<div class="controls">
				<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
			</div>
	</div>


		<div class="control-group">

			<div class="controls">
				<label class="checkbox">
				<?php echo Form::checkbox('frontpage', 1, $post->frontpage); ?>
				 Show on Front Page</label>
			</div>

			<div class="controls">
				<label class="checkbox">
				<?php echo Form::checkbox('menuitem', 1, $post->menu); ?>
				 Add to Menu</label>
			</div>


		</div>

	
	
	<div class="form-actions">
	    <?php echo Form::submit('Post', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection