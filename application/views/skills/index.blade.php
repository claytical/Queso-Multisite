@layout('layouts.default')
@section('content')
<h1>Skills</h1>
<p class="lead">A class can have more than one skill.  If you use multiple skills, the student's level will be determined by their skill with the lowest point value.
</p>
<?php echo Form::open('admin/skills', 'POST', array('class' => 'well form-inline')); ?>
<fieldset>
			    <?php echo Form::text('skill', '', array('placeholder' => 'Name of skill', 'class' => 'input-xlarge')); ?>
		    	<?php echo Form::submit('Add This Skill', array('class' => 'btn btn-primary pull-right'));?>		
	
	</fieldset>
<?php echo Form::close(); ?>
<h3>Current Skills</h3>
<table class="table table-hover table-condensed">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
			@foreach($skills as $skill)
                <tr>
                <?php echo Form::open('admin/skill/edit', 'POST', array('class' => 'form-inline')); ?>

                  <td><span class="skill-name">{{$skill->name}}</span>
                    <?php echo Form::text('skill', $skill->name, array('placeholder' => '', 'class' => 'input-large skill-input', 'style' => 'display:none;')); ?></td>
                    <?php echo Form::hidden('skill_id', $skill->id); ?></td>
                  <td>
      	            <div class="btn-toolbar pull-right">
          						<div class="btn-group">
        							<a class="btn btn-edit-skill" href="#"><i class="icon-pencil"></i></a>
                      <?php echo Form::submit('<i class="icon-ok"></i>', array('class' => 'btn btn-edit-skill-save', 'style' => "display:none;" ));?>                          
        							<a class="btn btn-danger" href="{{URL::to('admin/skill/remove/'.$skill->id)}}"><i class="icon-trash icon-white"></i></a>
        					   </div>
        					</div>
                          </td>
                <?php echo Form::close(); ?>

                </tr>

			@endforeach
              </tbody>
            </table>
@endsection