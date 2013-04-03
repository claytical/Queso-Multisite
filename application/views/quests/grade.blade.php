@layout('layouts.default')
@section('content')
<h1>{{$data->quest->name}}</h1>
{{ Form::open('admin/quest/grade', 'POST', array('class' => 'well')); }}

<fieldset>

	<div class="control-group">	

			<div class="controls">
				{{ Form::select('students[]', $data->students, '', array('class' => 'chzn-select', 'data-placeholder' => 'Select Students', 'tabindex' => '-1', 'multiple')) }}	
			</div>
			
			
		@foreach($data->skills as $skill)
			<h6>{{$skill['name']}}</h6>		
			<div class="controls">
				{{ Form::select('grade['.$skill["id"].']', $skill['rewards'], '', array('class' => 'chzn-select', 'data-placeholder' => 'No Grade', 'tabindex' => '-1')) }}	

			</div>
		@endforeach
		

	</div>
		<div class="controls">
			{{ Form::text('note', '', array('placeholder' => 'Note', 'class' => 'input-xxlarge')); }}
			{{ Form::hidden('quest_id', $data->quest->id); }}
		</div>


		<div class="form-actions">
	    {{ Form::submit('Grade Quest', array('class' => 'btn btn-primary pull-right btn-large')); }}
		</div>

@endsection