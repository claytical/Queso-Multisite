<h3>Course Code <span class="label label-default">{{Course::code()}}</span></h3>
<p class="help-text">Students can sign up for the course by using this link: <a href="{{URL::to('register?id='.Course::code())}}">{{URL::to('register?id='.Course::code())}}</a>
</p>
<p class="help-text">If you prefer, you can enter their email addresses and to send the link directly to their inbox.
</p>
<?php echo Form::open('admin/course/share', 'POST', array('class' => '')); ?>
	<div class="form-group">	
	    <?php echo Form::label('users', 'Email Addresses (comma separated)', array('class' => 'control-label')); ?>
			<div class="form-group">
    			<?php echo Form::textarea('emails', '', array('style' => 'width:100%;')); ?>
			</div>
	</div>
    <?php echo Form::submit('Share Course', array('class' => 'btn btn-primary pull-right'));?>		
<?php echo Form::close(); ?>
