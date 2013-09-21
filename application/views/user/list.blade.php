@layout('layouts.default')
@section('content')
<h2>Students</h2>
<div class="container">
<table class="table sortable">
	<thead>
	<th>Name</th>
    <th class="filter-false" data-sorter="false"></th>
	</thead>
  	<tbody>
	@foreach ($users as $user)
	<tr>
	  <td><a href="{{ URL::to('/admin/student/details/'.$user['personal']->id);}}">{{$user['personal']->username}}</a></td>
	  <td>
          
          <span class="badge badge-info pull-left">{{$user['current_level']->label}}</span>
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
		@if(Student::is_instructor($user['personal']->id))
			<a class="btn btn-default btn-block" title="Demote instructor to student" href="{{ URL::to('/admin/student/demote/'.$user['personal']->id);}}" data-original-title="Demote to Student"><span class="glyphicon glyphicon-arrow-down"></span> Demote to Student</a> 		
		@else
			<a class="btn btn-default btn-block" title="Promote student to instructor" href="{{ URL::to('/admin/student/promote/'.$user['personal']->id);}}" data-original-title="Promote to Instructor"><span class="glyphicon glyphicon-arrow-up"> </span>Promote to Instructor</a> 		
		@endif
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
		@if(Student::is_instructor($user['personal']->id))
			<a class="btn btn-default btn-xs" title="Demote instructor to student" href="{{ URL::to('/admin/student/demote/'.$user['personal']->id);}}" data-original-title="Demote to Student"><span class="glyphicon glyphicon-arrow-down"></span></a> 		
		@else
			<a class="btn btn-default btn-xs" title="Promote student to instructor" href="{{ URL::to('/admin/student/promote/'.$user['personal']->id);}}" data-original-title="Promote to Instructor"><span class="glyphicon glyphicon-arrow-up"></span></a> 		
		@endif
		<a class="btn btn-danger confirm btn-xs" title="Remove this student" href="{{ URL::to('/admin/student/deactivate/'.$user['personal']->id);}}" data-original-title="Deactivate this student"><span class="glyphicon glyphicon-trash"></span></a>
</div>	
        </td>
	</tr>
	@endforeach
  </tbody>
	</table>
</div>
@endsection