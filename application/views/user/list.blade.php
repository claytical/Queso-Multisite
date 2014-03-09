@layout('layouts.default')
@section('content')
<h2>Students</h2>
<div class="container">
@if($data->users)
	@if($data->teams)
		<a data-toggle="modal" href="#teamModal" class="btn btn-default pull-right btn-xs">Assign Selected Students to a Team</a>
		  <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				  <h4 class="modal-title">Assign Students to a Team</h4>
				</div>
				<div class="modal-body">
		{{ Form::open('admin/user/assign', 'POST', array('class' => '')); }}
		{{ Form::select('team', $data->teams, '', array('class' => 'selectpicker', 'data-placeholder' => 'Teams', 'id' => 'team-select')) }}
		{{ Form::submit('Assign', array('class' => 'btn btn-success btn-lg pull-right')); }}


				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			  </div>
			</div>
		  </div>
	@endif
	
	
	
	

<table class="table sortable">
	<thead>
	<th>Name</th>
    <th class="filter-false" data-sorter="false"></th>
	@if($data->teams)
		<th>Team</th>
	@endif
	<th class="filter-false" data-sorter="false"></th>
	</thead>
  	<tbody>
	@foreach ($data->users as $user)
		<tr>
	
	
		  	<td>
	@if($data->teams)

		  		<label class="checkbox">
					{{ Form::checkbox('addToTeam[]', $user['personal']->id);}}	
					  <a href="{{ URL::to('/admin/student/details/'.$user['personal']->id);}}">{{$user['personal']->username}}</a>
			  </label>
	@else
					  <a href="{{ URL::to('/admin/student/details/'.$user['personal']->id);}}">{{$user['personal']->username}}</a>
	
	@endif			

			</td>
		  <td>
		  
			  <span class="badge badge-info pull-left">{{$user['current_level']->label}}</span>
		</td>
		@if($data->teams)
		<td>
			{{$user['team']}}
		</td>
		@endif
		<td>		

				<div class="visible-sm visible-xs">
					<a data-toggle="modal" href="#userModal{{$user['personal']->id}}" class="btn btn-default pull-right btn-xs">Options</a>
					  <div class="modal fade" id="userModal{{$user['personal']->id}}" tabindex="-1" role="dialog" aria-labelledby="userModal{{$user['personal']->id}}Label" aria-hidden="true">
						<div class="modal-dialog">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							  <h4 class="modal-title">{{$user['personal']->username}}</h4>
							</div>
							<div class="modal-body">
	<a class="btn btn-default btn-block" href="mailto:{{$user['personal']->email}}"><span class="glyphicon glyphicon-envelope"></span> Email</a>
	<a class="btn btn-default btn-block" title="Quests available to this student" href="{{ URL::to('/admin/quests/available/student/'.$user['personal']->id);}}" data-original-title="Available Quests"><span class="glyphicon glyphicon-book"></span> Available Quests</a> 
			<a class="btn btn-danger confirm btn-block" title="Remove this student" href="{{ URL::to('/admin/student/deactivate/'.$user['personal']->id);}}" data-original-title="Deactivate this student"><span class="glyphicon glyphicon-trash"></span> Remove Student</a>                   
							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						  </div>
						</div>
					  </div>
	  
		  </div>
	<div class="btn-group pull-right visible-md visible-lg">
		<a class="btn btn-default btn-xs" href="mailto:{{$user['personal']->email}}"><span class="glyphicon glyphicon-envelope"></span></a>
			<a class="btn btn-default btn-xs" title="Quests available to this student" href="{{ URL::to('/admin/quests/available/student/'.$user['personal']->id);}}" data-original-title="Available Quests"><span class="glyphicon glyphicon-book"></span></a> 
			<a class="btn btn-danger confirm btn-xs" title="Remove this student" href="{{ URL::to('/admin/student/deactivate/'.$user['personal']->id);}}" data-original-title="Deactivate this student"><span class="glyphicon glyphicon-trash"></span></a>
	</div>	

		</td>
		</tr>
	@endforeach
  </tbody>
	</table>
@else
<h3>There are no students in this course yet!</h3>
@endif
</div>
@endsection