@layout('layouts.default')
@section('content')
	@if(isset($posts))
		@foreach($posts as $post)
			<h2>{{$post->headline}}</h2>
			<div class="row-fluid">{{$post->post}}</div>
			@if($post->filename)
        		<div class="row-fluid">
        			<h5>Files</h5>
	        		<ul class="inline">
	        		@foreach(explode(",",$post->filename) as $file)
						<li><a class='btn btn-small btn-info pull-right' href='{{$file}}'>{{Filepicker::metadata($file)->filename}}</a></li>
					@endforeach
					</ul>
				</div>
			@endif
			<hr>
		@endforeach
	@else
		<h2>Nothing posted yet, stay tuned!</h2>
	@endif
@endsection