@layout('layouts.default')
@section('content')
<h2>Student Signup</h2>
<p class="lead">Students can sign up for the course by using this link: <a href="{{URL::to('register?id='.Course::code())}}">{{URL::to('register?id='.Course::code())}}</a>
</p>
<p class="lead">If you prefer, you can enter their email addresses and to send the link directly to their inbox.
</p>
<?php echo Form::open('admin/course/share', 'POST', array('class' => '')); ?>
<fieldset>
	<div class="control-group">	
	    <?php echo Form::label('users', 'Email Addresses (comma separated)', array('class' => 'control-label')); ?>
			<div class="controls">
    			<?php echo Form::textarea('emails', '', array('style' => 'width:100%;')); ?>
			</div>
	</div>

	
	<div class="form-actions">
		    	<?php echo Form::submit('Share Course', array('class' => 'btn btn-primary pull-right'));?>		
	</fieldset>
	</div>
<?php echo Form::close(); ?>

@endsection