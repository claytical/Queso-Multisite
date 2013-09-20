@layout('layouts.default')
@section('content')
<h2>{{$data->title}}</h2>
@if (!empty($data->submissions) || !empty($data->revisions))
<table class="table table-responsive sortable">
	  <thead>
	  <th>Quest</th>
	  <th>Student</th>
	  </thead>
	  <tbody>
        @if (!empty($data->submissions))          
            @foreach ($data->submissions as $submission)
            <tr>
              <td>
                  <a href="{{ URL::to('admin/submission/grade/'.$submission['id'])}}">{{$submission['quest']}} <span class="label label-info pull-right">New</span></a>
              <div class="visible-md visible-lg">
              <?php $submitted_date = strtotime($submission['created']);?>
                {{date("F j, Y", $submitted_date);}}
              
              </div>                  
              </td>
              <td>
                {{$submission['username']}}
              </td>
            </tr>
            @endforeach
		@endif
        @if (!empty($data->revisions))    
              @foreach ($data->revisions as $submission)
                <tr>
                  <td>
                    <a href="{{ URL::to('admin/submission/grade/'.$submission['id'])}}">{{$submission['quest']}}<span class="label label-info pull-right">Revision {{$submission['revision']}}</span></a>
                    <div class="visible-md visible-lg">
              <?php $submitted_date = strtotime($submission['created']);?>
                {{date("F j, Y", $submitted_date);}}
              
              </div>

                  </td>
                  <td>
                    {{$submission['username']}}
                  </td>
                </tr>
            @endforeach
        @endif
    </tbody>
	</table>
@endif
@if (empty($data->submissions) && empty($data->revisions))
    <p>Nothing to grade...</p>
@endif
    
@endsection