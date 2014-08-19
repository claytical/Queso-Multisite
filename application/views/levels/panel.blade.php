<h4>Levels</h4>
<p class="help-text">You probably want more than one level.  Traditionally, most classes require over 60% to get a D.  That means most of your students will have an F for the majority of the class and make great progress towards the end of the course.  To encourage motivation, try creating levels inbetween levels that correspond to letter grades.
</p>

<?php echo Form::open('admin/levels', 'POST', array('class' => 'form-inline', 'role' => 'form')); ?>
<div class="form-group">
<?php echo Form::text('label', '', array('placeholder' => 'Level Name', 'class' => 'input-md form-control')); ?>
</div>
<div class="form-group">
    <?php echo Form::text('amount', '', array('placeholder' => 'Points Required', 'class' => 'input-md form-control')); ?>
    <?php echo Form::hidden('tab', 'levels'); ?> 
</div>

<?php echo Form::submit('Add This Level', array('class' => 'btn btn-primary pull-right'));?>

<?php echo Form::close(); ?>
<h5>Current Levels</h5>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Level</th>
            <th>Amount</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
@foreach($course->levels as $level)
        <tr>
        <td>
        <?php echo Form::open('admin/level/edit', 'POST', array('class' => 'form-inline')); ?>
        <div class="level">{{$level->label}}</div>
        </td>
        <td><div class="level_amount">{{$level->amount}}</div></td>
        <td>
        <div class="pull-right">
            <div class="btn-toolbar">
                <div class="btn-group">
                  <a rel="tooltip" data-original-title='Edit Level' data-toggle="modal" href="#levelEdit{{$level->id}}" class="btn btn-default btn-xs">Edit</a>
                  <div class="modal fade" id="levelEdit{{$level->id}}" tabindex="-1" role="dialog" aria-labelledby="levelEdit{{$level->id}}Label" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Editing {{$level->label}}</h4>
                        </div>
                        <?php echo Form::open('admin/level/edit', 'POST', array('class' => 'form-horizontal')); ?>
                        <div class="modal-body">
                            <div class="form-group">
                            <label for="label" class="control-label">Level Name</label>
                                <?php echo Form::text('label', $level->label, array('placeholder' => 'Level Name', 'class' => 'input-md form-control')); ?>
                            </div>
                            <div class="form-group">
                            <label for="label" class="control-label">Amount</label>
                                <?php echo Form::text('amount', $level->amount, array('placeholder' => 'Points Required', 'class' => 'input-md form-control')); ?>
                                <?php echo Form::hidden('level_id', $level->id); ?>
                          <?php echo Form::hidden('tab', 'levels'); ?> 
        
                            </div>
                          </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <a class="btn btn-danger btn" href="{{URL::to('admin/level/delete/'.$level->id)}}">Delete</a> 
                          <?php echo Form::submit('Save', array('class' => 'btn btn-primary'));?>
                            <?php echo Form::close(); ?>

                        </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->                                    
            </div>
        </div>
    </div>
    </td>
    </tr>

@endforeach
    </tbody>
</table>







