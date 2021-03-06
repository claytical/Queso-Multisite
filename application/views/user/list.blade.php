@layout('layouts.default')
@section('content')
<h2>Students</h2>
<div class="container">
	@if($data->teams)
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="student-actions" data-toggle="dropdown">
    Options
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="student-actions">
  	<li><a data-toggle="modal" href="#teamModal" class="">Assign Selected Students to a Team</a></li>
	<li><a href="#email" class="" onclick="emailSelectedStudents()">Email Selected Students</a></li>
  </ul>
</div>	
		
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
	@else
<div class="row">
	<a href="#email" class="btn btn-default pull-right btn-xs" onclick="emailSelectedStudents()">Email Selected Students</a>
</div>
	@endif
<div class="row">
	<button type="button" class="btn btn-default pull-left btn-md select-all">Select All</button>
</div>
	
	
	

<table class="table sortable">
	<thead>
	<th>Name</th>
    <th class="filter-false" data-sorter="false"></th>
	@if($data->teams)
		<th>Team</th>
	@endif
	<th class="filter-false" data-sorter="false">

	</th>

	</thead>
  	<tbody>
	@foreach ($data->users as $user)
		<tr>
	
	
		  	<td>

		  		<label class="checkbox">
					{{ Form::checkbox('addToTeam[]', $user['personal']->id, false, array('class' => 'user-checkbox'));}}	
						<span class="email hidden">{{$user['personal']->email}}</span>

					  <a href="{{ URL::to('/admin/student/details/'.$user['personal']->id);}}">{{$user['personal']->username}}</a>
			  </label>
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
</div>
@endsection