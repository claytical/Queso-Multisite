@layout('layouts.default')
@section('content')
<h2>{{$data->quest->name}}</h2>
@if($data->submission->revision == 0)
<span class="label label-info pull-right">Original</span>
@else
<span class="label label-info pull-right">Revision #{{$data->submission->revision}}</span>
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
	<a class="btn btn-info btn-mini" target="_blank" href="{{$file}}">{{Filepicker::metadata($file)->filename}}</a>
	@endforeach
</p>
</div>
@endif
@endsection