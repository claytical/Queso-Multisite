@layout('layouts.default')
@section('content')
		<h2>{{$post->headline}}</h2>
		<div class="row-fluid">{{$post->post}}</div>
		@if($post->filename)
			<div class="row-fluid">
				<h5>Files</h5>
	        		<ul class="inline">
	        		@foreach(explode(",",$post->filename) as $file)
						<li>
						<a class='btn btn-small btn-info pull-right' href='{{$file}}'>{{Filepicker::metadata($file)->filename}}</a>
						</li>
					@endforeach
				</ul>
			</div>
		@endif
@endsection