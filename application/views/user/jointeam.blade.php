@layout('layouts.default')
@section('content')
<h2>Join a Team</h2>
<div class="container">
<?php echo Form::open('user/join', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="form-group">	
			<div class="controls">
		{{ Form::select('team', $teams, '', array('class' => 'selectpicker', 'data-placeholder' => 'Teams', 'id' => 'team-select')) }}
			</div>
	</div>
	

	<hr>
<div class="form-group">
		{{ Form::submit('Join', array('class' => 'btn btn-success btn-lg pull-right')); }}
</div>
    <?php echo Form::close(); ?>
</div>
@endsection