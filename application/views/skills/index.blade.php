@layout('layouts.default')
@section('content')
<h1>Skills</h1>
<p class="lead">A class can have more than one skill.  If you use multiple skills, the student's level will be determined by their skill with the lowest point value.
</p>
<?php echo Form::open('admin/skills', 'POST', array('class' => 'well form-inline')); ?>
<fieldset>
			    <?php echo Form::text('skill', '', array('placeholder' => 'Name of skill', 'class' => 'input-lg')); ?>
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
                  <td><span class="skill-name">{{$skill->name}}</span>
                  <td>
      	            <div class="btn-toolbar pull-right">
        							<a class="btn btn-danger" href="{{URL::to('admin/skill/remove/'.$skill->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
        			</div>
                </td>

                </tr>

			@endforeach
              </tbody>
            </table>
@endsection