@layout('layouts.default')
@section('content')
		<h2>Create Post</h2>
	<?php echo Form::open('admin/post/create', 'POST', array('class' => 'well')); ?>
	<fieldset>
	
	
	<div class="control-group">	
			<div class="controls">
			    <?php echo Form::text('headline', '', array('placeholder' => 'Headline', 'class' => 'input-xxlarge')); ?>
			</div>
	</div>

	<div class="control-group">	
			<div class="controls">
				    {{ Form::textarea('body', '', array('placeholder' => 'Post content goes here...', 'class' => 'wysiwyg-area', 'id' => 'post-content', 'style' => 'width: 98%')); }}
			</div>
	</div>
	
		<div class="control-group">
			<div class="controls">
				<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
			</div>
	</div>


		<div class="control-group">

			<div class="controls">
				<label class="checkbox"><?php echo Form::checkbox('frontpage', '1'); ?> Show on Front Page</label>
			</div>

			<div class="controls">
				<label class="checkbox"><?php echo Form::checkbox('menuitem', '1'); ?> Add to Menu</label>
			</div>


		</div>

	
	
	<div class="form-actions">
	    <?php echo Form::submit('Post', array('class' => 'btn btn-primary pull-right btn-large'));?>
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection