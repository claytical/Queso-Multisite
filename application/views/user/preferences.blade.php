@layout('layouts.default')
@section('title')
Preferences
@endsection
@section('content')
<h2>Preferences</h2>
<?php echo Form::open('user/preferences', 'POST', array('class' => 'well')); ?>
    <?php echo Form::label('email', 'Email Address'); ?>
    <?php echo Form::text('email', $user->email); ?>
	<label class="checkbox">
		<?php echo Form::checkbox('email_notifications', 1, $user->notify_email); ?> Receive email notifications</label>

	<div class="form-actions">

			<?php echo Form::submit('Update', array('class' => 'btn btn-primary btn-large pull-right'));?>
	</div>
<?php echo Form::close(); ?>
@endsection