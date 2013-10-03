@layout('layouts.default')
@section('title')
Preferences
@endsection
@section('content')

<h2>Account Settings<a class="btn btn-default pull-right" href="{{ URL::to('user/changepw');}}">Change Password</a></h2>
    
<div class="container">
    <?php echo Form::open('user/preferences', 'POST', array('class' => 'form-horizontal')); ?>
        <div class="form-group">	
            <div class="controls">
                <img class="img-thumbnail" id="profile_photo" src="{{$user->photo_url}}"/>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <input type="filepicker" name="photo" data-fp-button-text="Choose Image" data-fp-mimetype="image/*" data-fp-services="COMPUTER,DROPBOX" data-fp-multiple="false" onchange="swapPhoto(event.fpfile.url)" class="btn btn-default"/>
                <input type="hidden" name="photo_url" id="photo_url"/>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <?php echo Form::label('email', 'Email Address'); ?>
                <?php echo Form::text('email', $user->email, array('class' => 'input-md form-control')); ?>
            </div>
            <div class="controls">
                <label class="checkbox">
                <?php echo Form::checkbox('email_notifications', 1, $user->notify_email); ?> Receive email notifications</label>
            </div>
        </div>
    
                <?php echo Form::submit('Update', array('class' => 'btn-submit btn btn-primary btn-lg pull-right', 'data-loading-text' => 'Updating...'));?>
    <?php echo Form::close(); ?>
</div>
@endsection