@layout('layouts.default')
@section('content')
<h2>{{ $quest->name }}</h2> 
<p class="lead">{{ $quest->instructions }}</p>

@if($quest->type == 1)
	@if($quest->allow_instant)
		<h3>Instant Redemption Codes</h3>
		<p>A redemption code can be used a student to gain points for a quest. They will receive the maximum number of points available upon redemption. If a student tries to redeem multiple codes for the same quest, they will not receive any extra points.</p>

		@if($quest->redemptions)
		<h4>Existing Codes</h4>
		<ul class="list-unstyled">
	
			@foreach($quest->redemptions as $redemption)
				<li>{{$redemption->code}}</li>
			@endforeach
	
		</ul>
		@else
		<em>No Existing Codes</em>
		@endif
		<hr>

		<?php echo Form::open('admin/quest/codes', 'POST', array('class' => 'form-inline')); ?>

		  <div class="form-group">
		    <input class="form-control" type="number" id="code" name="code_count" min="1" placeholder="Amount to Create">
		  </div>
			{{ Form::submit('Generate Codes', array('class' => 'btn-primary btn', 'data-loading-text' => 'Generating')); }}
			<?php echo Form::hidden('quest_id', $quest->id); ?>
		
			<?php echo Form::close(); ?>
					
		</form>
	@else
		<p class="lead">This quest does not have instant redemption enabled.</p>
		<a href="{{URL::to('admin/quest/'.$quest->id.'/enable_codes')}}" class="btn btn-default">Enable Instant Redemption</a>
	@endif

@else
		<p class="lead">This quest is not an activity, therefore instant redemption is unavailable.</p>

@endif
@endsection