@layout('layouts.default')
@section('content')
    <div class="col-md-6">
	@if($data->posts)
		@foreach($data->posts as $post)
			<h2>{{$post->headline}}</h2>
			<div class="row-fluid">{{$post->post}}</div>
			@if($post->filename)
        		<div class="row-fluid">
        			<h5>Files</h5>
	        		<ul class="list-inline">
	        		@foreach(explode(",",$post->filename) as $file)
						<li><a class='btn btn-sm btn-info pull-right' href='{{$file}}'><span class="glyphicon glyphicon-cloud-download"></span> {{Filepicker::metadata($file)->filename}}</a></li>
					@endforeach
					</ul>
				</div>
			@endif
			<hr>
		@endforeach
	@else
		<h2>Nothing posted yet, stay tuned!</h2>
	@endif
    </div>
    <div class="col-md-6">
        <h2>Questions <a href="{{URL::to('question/ask')}}" class="btn btn-default btn-primary pull-right">Ask a Question</a></h2>

        @if($data->questions)
<div class="panel-group" id="accordion">

    @foreach($data->questions as $question)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#question{{$question->id}}">
                             
                        @if($data->answers[$question->id])
                            <span class="glyphicon glyphicon-comment"></span> 
                        @endif

                            {{$question->question}} 
                                
                    </a> 
                      @if(Course::is_instructor())
                      <a href="{{URL::to('admin/question/delete/'.$question->id)}}" class="btn btn-xs pull-right btn-default"><span class="glyphicon glyphicon-trash"></span></a>
                      @endif

                    </h4>
                </div>
                <div id="question{{$question->id}}" class="panel-collapse collapse">
                  <div class="panel-body">
                    @if($data->answers[$question->id])
                    <ul class="list-unstyled">
                        @foreach($data->answers[$question->id] as $answer)
                        <li>
                            <div class="answer-header">{{$answer->username}} says...
                            <div class="btn-group pull-right">
                                <a href="{{URL::to('answer/'.$answer->id.'/thanks')}}" class='btn-xs btn btn-default'>{{$answer->thanks}} <span class="glyphicon glyphicon-heart"></span></a>
                        @if(Course::is_instructor())
                            <a href="{{URL::to('admin/answer/delete/'.$answer->id)}}" class="btn-xs btn btn-default"><span class="glyphicon glyphicon-trash"></span></a>
                        @endif
                            </div>
                            </div>
                            <div class="answer-body">
                                {{$answer->answer}}
                            </div>
                            <hr>
                                

                        </li>
                        @endforeach
                    </ul>
                    @endif
<div class="container">
{{ Form::open('question/'.$question->id, 'POST', array('class' => 'form-horizontal')); }}
<div class="form-group">
                      {{ Form::textarea('answer', '', array('placeholder' => 'Your answer...', 'class' => 'input-sm form-control', 'required' => '', 'style' => '','title' => 'Answer')); }}                      
</div>
    <div class="form-group">
                      {{ Form::submit('Answer', array('class' => 'btn btn-sm pull-right'));}}
</div>
    {{ Form::close(); }}
</div>
                    </div>
                </div>
              </div>
            @endforeach
        @else
            <p class="lead">No one has asked any questions yet.</p>
        @endif
        
    </div>
@endsection