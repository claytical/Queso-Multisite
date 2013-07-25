@layout('layouts.noclass')
@section('title')
Preferences
@endsection
@section('content')
<h2>Preferences</h2>
<?php echo Form::open('user/preferences', 'POST', array('class' => 'well')); ?>
	<div class="control-group">	
	    <div class="controls">
		    <img id="profile_photo" src="{{$user->photo_url}}"/>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<input type="filepicker" name="photo" data-fp-button-text="Choose Image" data-fp-mimetype="image/*" data-fp-services="COMPUTER,DROPBOX" data-fp-multiple="false" onchange="swapPhoto(event.fpfile.url)"/>
			<input type="hidden" name="photo_url" id="photo_url"/>
		</div>
	</div>
	<div class="control-group">
	    <div class="controls">
		    <?php echo Form::label('email', 'Email Address'); ?>
		    <?php echo Form::text('email', $user->email); ?>
		</div>
		<div class="controls">
			<label class="checkbox">
			<?php echo Form::checkbox('email_notifications', 1, $user->notify_email); ?> Receive email notifications</label>
		</div>
	</div>
		<div class="form-actions">

			<?php echo Form::submit('Update', array('class' => 'btn btn-primary btn-large pull-right'));?>
		</div>
<?php echo Form::close(); ?>
@endsection