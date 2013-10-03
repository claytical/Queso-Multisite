@layout('layouts.default')
@section('content')
<?php
	$created_date = strtotime($data['submission']->created_at);
 ?>
<div class="container">
	<div class="row">
			<h2>{{$data['quest']->name}}
        @if($data['submission']->revision ==0)
				<span class="label label-info pull-right visible-md visible-lg">First Attempt</span>
			@else
				<span class="label label-info pull-right visible-md visible-lg">Revision: #{{$data['submission']->revision}}</span>
			@endif
        </h2>
		<div class="well well-sm visible-md visible-lg">
            <button type="button" class="btn btn-default pull-right" data-toggle="collapse" data-target="#instructions">Show Instructions</button>
            <h6>{{date("F j, Y", $created_date);}}</h6>
 
 
        </div>
        
        <div id="instructions" class="collapse">
            <div class="visible-md visible-lg">
            {{$data['quest']->instructions}}
            </div>
        </div>
	<hr>
    </div>
	<div class="row">
		{{$data['submission']->submission}}
		@if($data['submission']->filename)
		<ul class="list-inline">
		@foreach(explode(",", $data['submission']->filename) as$file)
			<li><a class="btn btn-info" href="{{$file}}">{{Filepicker::metadata($file)->filename}}</a></li>
		@endforeach
		</ul>
		@endif
	</div>
	<div class="row">
	<?php echo Form::open('admin/submission/grade', 'POST', array('class' => 'form-horizontal')); ?>
	<h4>Notes</h4>
    <div class="container">
        <div class="form-group">
		{{ Form::textarea('notes', '', array('placeholder' => 'Your feedback to the student...', 'class' => 'wysiwyg-area', 'id' => 'grade-notes', 'class' => 'form-control', 'style' => 'width: 100%')); }}
        </div>
	<div class="form-group">
	    <?php echo Form::submit('Grade', array('class' => 'btn btn-primary pull-right btn-lg btn-submit', 'data-loading-text' => 'Grading...'));?>
	</div>
        @foreach($data['rewards'] as $reward)
		<div class="form-group">
 <h4>{{$reward->name}} <span class="label label-info rewards{{$reward->id}}"></span></h4>
			<input type="range" id="rewards{{$reward->id}}" name="rewards[{{$reward->id}}]" min="{{$reward->rewards['Minimum']}}" max="{{$reward->rewards['Maximum']}}" value="{{$reward->rewards['Maximum']}}" class="form-control">
			</div>		
	   @endforeach

        <?php echo Form::hidden('submission_id', $data['submission']->id); ?>
		<?php echo Form::hidden('quest_type', $data['quest']->type); ?>
		<?php echo Form::hidden('quest_id', $data['submission']->quest_id); ?>
		<?php echo Form::hidden('user_id', $data['submission']->user_id); ?>

		<?php echo Form::close(); ?>
	</div>
	<hr>
    </div>
	@if($data['comments'])
    <div class="row">
		<h4>Previous Notes</h4>
	<div class="container">
        @foreach($data['comments'] as $comment)
		<?php $comment_date = strtotime($comment->created_at);?>
		<blockquote>
			<p>{{$comment->comment}}</p>
			<small>{{date("F j, Y", $comment_date);}}</small>	
		</blockquote>
		@endforeach
        </div> 
	</div>
    @endif
</div>  
@endsection