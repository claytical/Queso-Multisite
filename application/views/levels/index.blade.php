@layout('layouts.default')
@section('content')
<h1>Levels</h1>
<p class="lead">
You probably want more than one level.  Traditionally, most classes require over 60% to get a D.  That means most of your students will have an F for the majority of the class and make great progress towards the end of the course.  To encourage motivation, try creating levels inbetween levels that correspond to letter grades.</p>
<?php echo Form::open('admin/levels', 'POST', array('class' => 'well form-inline')); ?>
	<fieldset>
			    <?php echo Form::text('label', '', array('placeholder' => 'Level Name', 'class' => 'input-xlarge')); ?>
			    <?php echo Form::text('amount', '', array('placeholder' => 'Points Required', 'class' => 'input-xlarge')); ?>

		    	<?php echo Form::submit('Add This Level', array('class' => 'btn btn-primary pull-right'));?>		
	
	</fieldset>
<?php echo Form::close(); ?>
<h3>Current Levels</h3>
<table class="table table-hover table-condensed">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Points Required</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
			@foreach($levels as $level)
                <tr>
                <?php echo Form::open('admin/level/edit', 'POST', array('class' => 'form-inline')); ?>

                    <td><span class="level">{{$level->label}}</span>
                    <?php echo Form::text('level', $level->label, array('placeholder' => '', 'class' => 'input-large level-input', 'style' => 'display:none;')); ?>
                    <?php echo Form::hidden('level_id', $level->id); ?>

                    </td>                    
                    <td><span class="level_amount">{{$level->amount}}</span>
                    <?php echo Form::text('level_amount', $level->amount, array('placeholder' => '', 'class' => 'input-large level-amount-input', 'style' => 'display:none;')); ?>
                    
                    </td>
                    
                    <td>
      	            <div class="btn-toolbar pull-right">
							<a class="btn btn-danger" href="{{URL::to('admin/level/delete/'.$level->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
					</div>
                    </td>
                </tr>
                  @endforeach
              </tbody>
            </table>
@endsection