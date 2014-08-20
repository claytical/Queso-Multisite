@layout('layouts.default')
@section('content')
<div class="container">
	<h2>New Post</h2>
	<?php echo Form::open('admin/post/create', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="col-md-9">
		<div class="form-group">	
				<div class="controls">
					<?php echo Form::text('headline', '', array('placeholder' => 'Headline', 'class' => 'input-md form-control')); ?>
				</div>
		</div>

		<div class="form-group">	
				<div class="controls">
						{{ Form::textarea('body', '', array('placeholder' => 'Post content goes here...', 'class' => 'wysiwyg-area form-control', 'id' => 'post-content', 'style' => 'width: 100%')); }}
				</div>
		</div>
		
	</div>
	
	<div class="col-md-3">

	<div class="panel panel-default">
		  <div class="panel-body">
			 <?php echo Form::submit('Create Post', array('class' => 'btn btn-primary btn-block btn-lg'));?>
		  </div>
	</div>

		<div class="panel-group" id="accordion">
		  <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#settings">
				  Settings
				</a>
			  </h4>
			</div>
			<div id="settings" class="panel-collapse collapse in">
			  <div class="panel-body">
				<label class="checkbox"><?php echo Form::checkbox('frontpage', '1', array('checked' => 'checked')); ?> Front Page</label>
				<label class="checkbox"><?php echo Form::checkbox('menuitem', '1'); ?> Add to Menu</label>
			  </div>
			</div>
		  </div>

		  <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#attach">
				  Attach
				</a>
			  </h4>
			</div>
			<div id="attach" class="panel-collapse collapse">
			  <div class="panel-body">
				<input type="filepicker-dragdrop" class="" name="files" data-fp-button-text="" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
			  </div>
			</div>
		  </div>
		</div>




		  </div>
		</div>
<?php echo Form::close(); ?>


	</div>
</div>
@endsection