@layout('layouts.default')
@section('content')
<h2>{{$data->quest->name}}</h2>
					
        @if($data->submission->revision == 0 && !$data->revisions)
				<span class="label label-info pull-right visible-md visible-lg">First Attempt</span>
			@else
				<div class="btn-group pull-right visible-md-visible-lg">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					@if($data->submission->revision == 0)
					  First Attempt
					@else
					  Revision #{{$data->submission->revision}}
					@endif
					
					 
					  <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
					  @foreach($data->revisions as $revision)
					  	@if($revision->revision == count($data->revisions)-1)
					  	
						  <li><a href="{{ URL::to('submission/revise/'.$revision->id)}}">Revise Latest Version</a></li>					  	
					  	@else
					  		@if($revision->revision == 0)
							  <li><a href="{{ URL::to('submission/view/'.$revision->id)}}">Original Submission</a></li>					  	
					  		@else					  		
							  <li><a href="{{ URL::to('submission/view/'.$revision->id)}}">Submission <span class="label label-info">#{{$revision->revision}}</span> {{date("j/n/Y g:ia", strtotime($revision->created_at))}}</a></li>					  	
							@endif
					  	@endif
					  	
					  @endforeach
					</ul>
				  </div>
			@endif


<?php
	$created_date = strtotime($data->submission->created_at);
 ?>
<h6>Submitted on {{date("F j, Y", $created_date);}}</h6>
<div>
{{$data->submission->submission}}
</div>
@if($data->submission->filename)
<div>
<p>
	@foreach(explode(",",$data->submission->filename) as $file)
	<a class="btn btn-info btn-xs" target="_blank" href="{{$file}}">{{Filepicker::metadata($file)->filename}}</a>
	@endforeach
</p>
</div>
@endif
@endsection