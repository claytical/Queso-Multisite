
        <?php echo Form::open('admin/course', 'POST', array('class' => 'form-horizontal', 'role' => 'form')); ?>
        <h4>Course Settings</h4>
            <div class="form-group">
                <label for="course" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                    <?php echo Form::text('course', $course->name, array('placeholder' => 'Course Name', 'class' => 'input-md form-control')); ?>
                </div>
            </div>
            <div class="form-group">	
                <label for="dropdown" class="col-md-3 control-label">Custom Dropdown Text</label>
                <div class="col-md-9">
                    <?php echo Form::text('dropdown', $course->dropdown, array('placeholder' => 'Posts', 'class' => 'input-md form-control')); ?>
                </div>
            </div>        
            <div class="form-group">	
                <label for="code" class="col-md-3 control-label">Registration Code</label>
                <div class="col-md-9">
                    <?php echo Form::text('code', $course->code, array('placeholder' => 'Course Registration Code', 'class' => 'input-md form-control')); ?>
                </div>
            </div>

          <div class="form-group">	
                <label for="course_active" class="col-md-3 control-label">In Session</label>
                <div class="col-md-9">
					<div class="btn-group" data-toggle="buttons">
						@if($course->active == 1)
						  <label class="btn btn-default active">
							<input type="radio" name="active" value=1 id="course_active" checked> Yes

						@else
						  <label class="btn btn-default">
							<input type="radio" name="active" value=1 id="course_active" > Yes
	
						@endif

					  </label>
						@if($course->active == 0)
	
						  <label class="btn btn-default active">
							<input type="radio" name="active" value=0 id="course_deactive" checked> No
						@else
						  <label class="btn btn-default">
							<input type="radio" name="active" value=0 id="course_deactive" > No
						@endif						
					  </label>
				</div>
			</div>
		</div>			

          <div class="form-group">	
                <label for="course_active" class="col-md-3 control-label">Public</label>
                <div class="col-md-9">
					<div class="btn-group" data-toggle="buttons">
						@if($course->public == 1)
						  <label class="btn btn-default active">
							<input type="radio" name="public" value=1 id="course_public" checked> Yes

						@else
						  <label class="btn btn-default">
							<input type="radio" name="public" value=1 id="course_public" > Yes
	
						@endif

					  </label>
						@if($course->public == 0)
	
						  <label class="btn btn-default active">
							<input type="radio" name="public" value=0 id="course_public" checked> No
						@else
						  <label class="btn btn-default">
							<input type="radio" name="public" value=0 id="course_public" > No
						@endif						
					  </label>
				</div>
			</div>
		</div>			







            <div class="form-group">
                <?php echo Form::hidden('tab', 'levels'); ?> 


                <?php echo Form::submit('Update Course', array('class' => 'btn btn-primary pull-right'));?>		

            </div>
        <?php echo Form::close(); ?>
    

    
