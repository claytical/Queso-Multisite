@layout('layouts.default')
@section('content')
<h2>{{ $quest->name }}</h2> 

<p class="lead">{{ $quest->instructions }}</p>

		<?php echo Form::open('quest/redeem', 'POST', array('class' => 'form-inline')); ?>

		  <div class="form-group">
		    <input class="form-control" type="text" id="code" name="code" placeholder="Redemption Code">
		  </div>
			{{ Form::submit('Redeem', array('class' => 'btn-default btn', 'data-loading-text' => 'Redeeming')); }}
			<?php echo Form::hidden('quest_id', $quest->id); ?>
		
			<?php echo Form::close(); ?>
					
		</form>
@endsection