@layout('layouts.default')
@section('content')
<h2>Quest Created!</h2>
@if ($quest->category)
<span class="label label-info pull-right">{{$quest->category}}</span>
@endif
<h3>{{ $quest->name }}</h3> 
<div class="pull-right">
<a class="btn btn-success" href="{{ URL::to('admin/quest/create');}}">Create Another Quest</a> 
</div>

<p class="lead">{{ $quest->instructions }}</p>
	@if($quest->allow_instant)
		<h4>Instant Redemption Codes</h4>
		<p>You have opted to allow students to receive credit for this quest by entering in a unique code.
			You can generate these codes now or later through the quest management page.</p>
		<?php echo Form::open('admin/quest/codes', 'POST', array('class' => 'form-inline')); ?>

		  <div class="form-group">
		    <input class="form-control" type="number" id="code" name="code_count" min="1" placeholder="Amount to Create">
		  </div>
			{{ Form::submit('Generate Codes', array('class' => 'btn-default btn', 'data-loading-text' => 'Generating')); }}
			<?php echo Form::hidden('quest_id', $quest->id); ?>
		
			<?php echo Form::close(); ?>
					
		</form>

	@endif
@endsection