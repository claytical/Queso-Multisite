@layout('layouts.default')
@section('content')
<h2>Completed Quests</h2>

@if (count($data->quests) > 0)
<table class="table sortable">
              <thead>
                <tr>
                  <th>Quest</th>
                  <th class="filter-select" data-placeholder="Select...">Category</th>
                  <th class="filter-false" data-sorter="false"></th>

                </tr>
              </thead>
              <tbody>
            	@foreach($data->quests as $quest)
                <tr>
                  <td>

                  	<span style="white-space:nowrap;">
                  	@if($quest['type'] == 1)
                  	{{$quest['name']}}
					@endif
                  	@if($quest['type'] == 2)
                  	<a href="{{URL::to('submission/revise/'.$quest['submission']->id)}}">{{$quest['name']}}</a>
					@endif
                  	@if($quest['type'] == 3)
                  	<a href="{{URL::to('upload/revise/'.$quest['submission']->id)}}">{{$quest['name']}}</a>
					@endif

                  	</span>
                  	<div>
	                  	<?php $created_date = strtotime($quest['completed']);?>
						{{date("F j, Y", $created_date);}}
                  	<div>
                  	</td>
                  	<td>{{$quest['category']}}</td>
                  <td>
					@if($quest['skills'])
						<ul class="unstyled">
								@foreach($quest['skills'] as $skill)
								<li><em>{{$skill->name}}</em>
									<div class="progress progress-success">
										@if($data->questMaxPoints[$skill->id] != 0)
										<div class="bar" style="width: {{$skill->amount/$data->questMaxPoints[$skill->id] * 100}}%;">{{$skill->amount}} / {{$data->questMaxPoints[$skill->id]}}</div>
										@endif
									</div>	
								</li>
								@endforeach
						</ul>
					@else						
						<em>Pending</em>
					@endif

                  </td>
                </tr>
				@endforeach

              </tbody>
            </table>
<hr>
<div class="offset6">
	<h5>Totals</h5>
	<ul class="unstyled">
	@foreach($data->skills as $skill)
		<li>
			{{$skill['label']}}
		 	<span class="pull-right">
		 	@if($skill['amount'])
		 		{{$skill['amount']}}
			@else
			0
			@endif
		 	</span>
		</li>
	@endforeach
	</ul>
</div>

@else
<p class="lead">Looks like you haven't completed any quests...</p>
@endif
@endsection