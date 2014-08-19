@layout('layouts.default')
@section('content')
		<h2>{{$post->headline}}</h2>
		@if($post->video_url)
		<div class="row">
			<div class="video-container">
			<iframe width="320" height="240" src="{{$post->video_url}}" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
			</div>
		</div>
		@endif
		<div class="row">{{$post->post}}</div>
		@if($post->filename)
			<div class="row">
				<h5>Files</h5>
	        		<ul class="list-inline">
	        		@foreach(explode(",",$post->filename) as $file)
						<li>
						<a class='btn btn-sm btn-info pull-right' href='{{$file}}'>{{Filepicker::metadata($file)->filename}}</a>
						</li>
					@endforeach
				</ul>
			</div>
		@endif
@endsection