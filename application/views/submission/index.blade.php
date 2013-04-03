@layout('layouts.default')
@section('content')
<h2>{{$data->title}}</h2>
@if (!empty($data->submissions))
<table class="table sortable">
	  <thead>
	  <th>Quest</th>
	  <th>Student</th>
      <th class="filter-select" data-placeholder="Select...">Submitted</th>
	  </thead>
	  <tbody>
		@foreach ($data->submissions as $submission)
		<tr>
		  <td>
		  @if($submission['type'] == 'text')
			  <a href="{{ URL::to('admin/submission/grade/'.$submission['id'])}}">{{$submission['quest']}}</a>
		  @endif
		  @if($submission['type'] == 'file')
			  <a href="{{ URL::to('admin/upload/grade/'.$submission['id'])}}">{{$submission['quest']}}</a>		  
		  @endif
		  </td>
		  <td>
			{{$submission['username']}}
		  </td>
		  <td>
		  <?php $submitted_date = strtotime($submission['created']);?>
			{{date("F j, Y", $submitted_date);}}
		  
		  </td>
		</tr>
		@endforeach
	  </tbody>
	</table>
@else
<p class="lead">Nothing to grade...</p>
@endif
@endsection