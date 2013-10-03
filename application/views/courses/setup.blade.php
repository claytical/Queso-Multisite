
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
                <?php echo Form::hidden('tab', 'levels'); ?> 
                <?php echo Form::submit('Update Course', array('class' => 'btn btn-primary pull-right'));?>		
            </div>
        <?php echo Form::close(); ?>
    

    
