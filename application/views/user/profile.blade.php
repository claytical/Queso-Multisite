@layout('layouts.default')
@section('content')
<div class="">
<h2>{{$data->user->username}}</h2>

@if(!empty($data->dates))
<h4>{{$data->current_level->label}}</h4>
</div>
<hr>
@if(count($data->dates) > 1)

<div class="container">

<table class="chart" style="display:none;" width="95%" height="65%">
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
    </div>
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
                              <a href="{{URL::to('submission/revise/'.$quest['submission']->id)}}">{{$quest['name']}}</a>
						@else
                              {{$quest['name']}}
                        @endif
					
	                  	</span>
	                  	
		                  	<?php $created_date = strtotime($quest['completed']);?>
						<div>
                          {{date("F j, Y", $created_date);}}
	                  	</div>
                        </td>
	                  <td>
						@if($quest['skills'])

							<ul class="list-unstyled">
									@foreach($quest['skills'] as $skill)
									<li><em>{{$skill->amount}} {{$skill->name}}</em>

										<div class="progress">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$skill->amount}}" aria-valuemin="0" aria-valuemax="{{$data->questPoints[$quest['quest_id']][$skill->id]}}" style="width: {{$skill->amount/$data->questPoints[$quest['quest_id']][$skill->id] * 100}}%;"><span class="sr-only">{{$skill->amount}}</span> </div>
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
				<h4>Totals</h4>
				<ul class="list-unstyled">
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
					<li>Current Level<span class="pull-right">{{$data->current_level->label}}</span></li>

				</ul>
			</div>
<div class="offset6">
		<h4>Points From Remaining Quests</h4>
		<ul class="list-unstyled">
		
		@foreach($data->projected_level['skills'] as $projection)
			<li>
				{{$projection['label']}}
				<span class="pull-right">
				@if($projection['left'])
					{{$projection['left']}}
				@else
				0
				@endif
				</span>
			
			</li>
		@endforeach
			<li>Projected Level<span class="pull-right">{{$data->projected_level['level']}}</span></li>
		</ul>
</div>
<hr>







	@endif

@else
	<p class="lead">No quests have been completed</p>
@endif

@endsection