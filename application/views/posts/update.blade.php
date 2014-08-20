@layout('layouts.default')
@section('content')
		<h2>Updating Post</h2>
<div class="container">
	<?php echo Form::open('admin/post/update', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="col-md-9">

	<div class="form-group">	
			<div class="controls">
			    <?php echo Form::text('headline', $post->headline, array('placeholder' => 'Headline', 'class' => 'input-md form-control')); ?>
			    <?php echo Form::hidden('post_id', $post->id); ?>

			</div>
	</div>

	<div class="form-group">	
			<div class="controls">
				{{ Form::textarea('body', $post->post, array('placeholder' => 'Post content goes here...', 'class' => 'wysiwyg-area form-control', 'id' => 'post-content', 'required' => '', 'style' => 'width: 100%')); }}
			</div>
	</div>
	</div>
	<div class="col-md-3">	
	
		<div class="panel panel-default">
		  	<div class="panel-body">

	    		<?php echo Form::submit('Update Post', array('class' => 'btn btn-primary btn-lg'));?>

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
				<label class="checkbox">
				  <?php echo Form::checkbox('frontpage', 1, $post->frontpage); ?> Front Page</label>
			  	<label class="checkbox">
				<?php echo Form::checkbox('menuitem', 1, $post->menu); ?>
				 Add to Menu</label>
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
			@if($post->files)
				<ul class="list-inline">
				@foreach($post->files as $file)
					<li>{{$file['friendly']}} {{ Form::hidden('existingFiles[]', $file['encoded'])}} <a class="btn btn-danger btn-xs btn-remove-file" href=''>Remove</a></li>
				@endforeach
				</ul>
			@endif
			<div class="controls">
				<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true"/>
			</div>
			  </div>
			</div>
		  </div>
	
		</div>
	

	
	
	</div>
<?php echo Form::close(); ?>
</div>
@endsection