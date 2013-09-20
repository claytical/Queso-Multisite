@layout('layouts.default')
@section('content')
<h1>{{$data->quest->name}}</h1>
	@if (count($data->completed_users) > 0)
	<?php echo Form::open('admin/student/quest/remove', 'POST', array('class' => '')); ?>

	<h3>Completed</h3>
	<?php echo Form::submit('Remove Checked Quests', array('class' => 'btn btn-danger btn-xs pull-right'));?>
	<?php echo Form::hidden('quest_id', $data->quest->id);?>
	<table class="table table-hover sortable">
				  <thead>
					<tr>
					  <th>Student</th>
	                  <th class="filter-false" data-sorter="false">Skills</th>
					</tr>
				  </thead>
				  <tbody>
					@foreach($data->completed_users as $user)
					<tr>
					  <td>
						<span style="white-space:nowrap;">
						<div class="control-group">	
							<div class="controls">
						@if($data->quest->type == 1)
						  	<label class="checkbox"> {{ Form::checkbox('removeQuest[]', $user['id'])}}

							{{$user['username']}}</label>
						@endif

						@if($data->quest->type == 2)
							<label class="checkbox">
								{{ Form::checkbox('removeSubmission[]', $user['id']);}}	
									<a href="{{ URL::to('admin/submission/grade/'.$user['submission']->id)}}">{{$user['username']}}</a>
								

							</label>
						@endif
						
							</div>
						</div>

						</span>
						</td>
					  <td>
						<ul class="unstyled">
							@if($user['skills'])								
								@foreach ($user['skills'] as $skill)
								<li><em>{{$skill['label']}}</em>
									<div class="progress progress-success">
										<div class="bar" style="width: {{$skill['amount']/$data->skills[$skill['label']] * 100}}%;">{{$skill['amount']}} / {{$data->skills[$skill['label']]}}</div>
									</div>	
								</li>
								@endforeach
							@else
								<li><span class="label label-warning">Not Yet Graded</span></li>
							@endif
						</ul>
					  </td>
					</tr>
					@endforeach
	
				  </tbody>
				</table>
			<?php echo Form::close(); ?>

	@else
	<p class="alert alert-danger">No one has completed this quest</p>
	@endif

	@if (count($data->available_users) > 0)
	
	<h3>Not Completed</h3>
	<table class="table table-hover sortable">
				  <thead>
					<tr>
					  <th>Student</th>
	                  <th class="filter-false" data-sorter="false"></th>
					</tr>
				  </thead>
				  <tbody>
					@foreach($data->available_users as $user)
					<tr>
					  <td>
						<span style="white-space:nowrap;"><strong>{{$user->username}}</strong></span>
						</td>
	
					  <td>
	
					  </td>
					</tr>
					@endforeach
	
				  </tbody>
				</table>
	@else
	<p class="alert alert-success">Everyone has completed this quest</p>
	@endif
@endsection