<h4>Skills</h4>
<p class="help-text">A class can have more than one skill.  If you use multiple skills, the student's level will be determined by their skill with the lowest point value.
</p>
<?php echo Form::open('admin/skills', 'POST', array('class' => 'form-inline')); ?>
<?php echo Form::text('skill', '', array('placeholder' => 'Name of skill', 'class' => 'input-md form-control', 'style' => 'width: 80%')); ?>
<?php echo Form::hidden('tab', 'skills'); ?> 
<?php echo Form::submit('Add This Skill', array('class' => 'btn btn-primary pull-right'));?>		
<?php echo Form::close(); ?>

<h5>Current Skills</h5>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

    @foreach($course->skills as $skill)
        <tr>
        <td>{{$skill->name}}</td>
        <td>
        <div class="btn-toolbar pull-right">
        <div class="btn-group">    
        <a data-toggle="modal" href="#skillEdit{{$skill->id}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
          <div class="modal fade" id="skillEdit{{$skill->id}}" tabindex="-1" role="dialog" aria-labelledby="skillEdit{{$skill->id}}Label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Editing {{$skill->name}}</h4>
                </div>
                <?php echo Form::open('admin/skill/edit', 'POST', array('class' => 'form-inline')); ?>
                <div class="modal-body">
                    <div class="form-group">
                    <label for="label" class="control-label">New Name for Skill</label>
                        <?php echo Form::text('skill', $skill->name, array('placeholder' => 'Skill Name', 'class' => 'input-md form-control')); ?>
                    </div>
                  </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <?php echo Form::hidden('skill_id',$skill->id); ?> 
                    <?php echo Form::hidden('tab', 'skills'); ?> 
                    <?php echo Form::submit('Save', array('class' => 'btn btn-primary'));?>
                </div>
                    <?php echo Form::close(); ?>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->                                    

    <a class="btn btn-danger btn-xs" href="{{URL::to('admin/skill/remove/'.$skill->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                        </div>
        </td>
    </tr>
@endforeach        
    </tbody>
</table>
