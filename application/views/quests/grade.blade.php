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
			<h4>{{$skill['name']}}  <span class="label label-info grade{{$skill['id']}}"></span></h4>		

			<div class="controls">
                <div class="input-group">
				<input class="form-control" type="range" id="grade{{$skill['id']}}" name="grade[{{$skill['id']}}]" min="{{$skill['rewards']['Minimum']}}" max="{{$skill['rewards']['Maximum']}}" value="{{$skill['rewards']['Maximum']}}">
                    </div>
				
			</div>
		@endforeach
		

	</div>
		<div class="form-group">

			{{ Form::textarea('note', '', array('placeholder' => 'Your feedback to the student...', 'class' => 'wysiwyg-area form-control', 'id' => 'grade-notes', 'style' => 'width: 100%')); }}
			
			{{ Form::hidden('quest_id', $data->quest->id); }}
		</div>


		<div class="form-group">
	    {{ Form::submit('Grade Quest', array('class' => 'btn btn-primary pull-right btn-submit btn-lg', 'data-loading-text' => 'Grading...')); }}
		</div>
</div>
@endsection