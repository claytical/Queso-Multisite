@layout('layouts.default')
@section('content')
<h2>{{$data->quest->name}}</h2>
{{ Form::open('admin/quest/grade', 'POST', array('class' => 'form-horizontal')); }}

<div class="container">
	<div class="form-group">	

			<div class="controls">
				{{ Form::select('students[]', $data->students, '', array('class' => 'selectpicker', 'data-placeholder' => 'Select Students', 'tabindex' => '-1', 'multiple')) }}	
			</div>
			
			
		@foreach($data->skills as $skill)
			<h4>{{$skill['name']}}</h4>		

			<div class="controls">
                <div class="input-group">
				<input class="form-control" type="range" name="grade[{{$skill['id']}}]" min="{{$skill['rewards']['Minimum']}}" max="{{$skill['rewards']['Maximum']}}" value="{{$skill['rewards']['Maximum']}}">
                    <span class="badge input-group-addon" for="grade[{{$skill['id']}}]" onforminput="value = grade[{{$skill['id']}}].valueAsNumber;"></span>
                    </div>
				
			</div>
		@endforeach
		

	</div>
		<div class="form-group">
			{{ Form::text('note', '', array('placeholder' => 'Note', 'class' => 'input-md form-control')); }}
			{{ Form::hidden('quest_id', $data->quest->id); }}
		</div>


		<div class="form-group">
	    {{ Form::submit('Grade Quest', array('class' => 'btn btn-primary pull-right btn-submit btn-lg', 'data-loading-text' => 'Grading...')); }}
		</div>
</div>
@endsection