@layout('layouts.default')
@section('content')
<h2>{{$data->user->username}}</h2>
@if(!empty($data->dates))
<h4>{{$data->current_level->label}}</h4>
	@if(count($data->dates) > 1)
		<table class="chart" style="display:none;" width="65%" height="50%">
			<thead>
				<tr>
					<td></td>
					<!-- Date of Quests -->
					@foreach($data->dates as $date)
					<th scope="col">{{ date('n/j', strtotime($date)) }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
					@foreach($data->progress_by_skill as $skill => $dates)

				<tr>

					<th scope="row">{{$skill}}</th>
						@foreach($dates as $date)
							<td>
								@if($date['amount'])
									{{$date['amount']}}
								@else
								0
								@endif
							</td>
						@endforeach
				</tr>
					@endforeach

			</tbody>
		</table>
	@endif
@endif
@if (!empty($data->quests))
	@if (count($data->quests) > 0)
	<table class="table table-hover">
	              <thead>
	                <tr>
	                  <th>Quest</th>
	                  <th>Skills Earned
	                  </th>
	                </tr>
	              </thead>
	              <tbody>
	            	@foreach($data->quests as $quest)
	                <tr class="{{str_replace(' ', '', $quest['category'])}} quest">
	                  <td>
	                  	<span style="white-space:nowrap;">						
						@if ($quest['submission'])
		                  	@if($quest['type'] == 2)
		    	              	<a href="{{URL::to('submission/revise/'.$quest['submission']->id)}}">
							@endif
	            	
	            	      	@if($quest['type'] == 3)
	                		  	<a href="{{URL::to('upload/revise/'.$quest['submission']->id)}}">
							@endif
						@endif
							{{$quest['name']}}						
						@if ($quest['submission'])
							</a>
						@endif

	                  	</span>
	                  	<div>
		                  	<?php $created_date = strtotime($quest['completed']);?>
							{{date("F j, Y", $created_date);}}
	                  	<div>
	                  	</td>
	                  <td>
						@if($quest['skills'])

							<ul class="unstyled">
									@foreach($quest['skills'] as $skill)
									<li><em>{{$skill->name}}</em>

										<div class="progress progress-success">
											<div class="bar" style="width: {{$skill->amount/$data->questPoints[$quest['quest_id']][$skill->id] * 100}}%;">{{$skill->amount}} / {{$data->questPoints[$quest['quest_id']][$skill->id]}}</div>
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

	@endif

@else
	<p class="lead">No quests have been completed</p>
@endif


@endsection