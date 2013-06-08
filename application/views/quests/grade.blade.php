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
			<h4>{{$skill['name']}}</h4>		
			<div class="controls">
				{{ Form::text('grade['.$skill["id"].']', '', array('data-slider-min' => $skill['rewards']['Minimum'], 'data-slider-max' => $skill['rewards']['Maximum'], 'data-slider-step' => 1, 'class' => 'slider'))}}
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