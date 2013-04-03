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
                  <td>{{$level->label}}</td>
				  <td>{{$level->amount}}</td>
                  <td>
      	            <div class="btn-toolbar pull-right">
  						<div class="btn-group">
							<a class="btn" href="#"><i class="icon-edit"></i></a>
							<a class="btn btn-danger" href="#"><i class="icon-trash icon-white"></i></a>
					   </div>
					</div>
                  </td>
                </tr>
			@endforeach
              </tbody>
            </table>
@endsection