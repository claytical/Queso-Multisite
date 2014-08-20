@layout('layouts.default')
@section('content')

<div class="container">
<h2>Something Went Wrong!</h2>
<?php echo Form::open('report', 'POST', array('class' => 'form-horizontal')); ?>
	
	<div class="form-group">	
			<div class="controls">
				{{ Form::textarea('bug', '', array('placeholder' => 'What were you trying to do?', 'class' => 'wysiwyg-area form-control', 'id' => 'bug-instructions', 'style' => 'width: 100%')); }}
				{{Form::hidden('exception', $data->exception)}}
			</div>
	</div>
	

	<hr>
<div class="form-group">
	<?php echo Form::submit('Submit Bug', array('class' => 'btn btn-primary pull-right btn-lg'));?>
</div>
    <?php echo Form::close(); ?>
</div>


@endsection