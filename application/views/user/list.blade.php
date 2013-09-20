@layout('layouts.default')
@section('content')
<h2>Students</h2>
<table class="table sortable">
	<thead>
	<th>Name</th>
	<th class="filter-select" data-placeholder="All">Level</th>
	<th>Email</th>
    <th class="filter-false" data-sorter="false"></th>
	</thead>
  	<tbody>
	@foreach ($users as $user)
	<tr>
	  <td><a href="{{ URL::to('/admin/student/details/'.$user['personal']->id);}}">{{$user['personal']->username}}</a></td>
	  <td><span class="badge badge-info">{{$user['current_level']->label}}</span></td>
	  <td><a href="mailto:{{$user['personal']->email}}">{{$user['personal']->email}}</a></td>
	  <td>
<div class="btn-group-sm pull-right">
		<a class="btn btn-default" title="Quests available to this student" href="{{ URL::to('/admin/quests/available/student/'.$user['personal']->id);}}" data-original-title="Available Quests"><i class="glyphicon glyphicon-tasks"></i></a> 
		@if(Student::is_instructor($user['personal']->id))
			<a class="btn btn-default" title="Demote instructor to student" href="{{ URL::to('/admin/student/demote/'.$user['personal']->id);}}" data-original-title="Demote to Student"><i class="glyphicon glyphicon-star"></i></a> 		
		@else
			<a class="btn btn-default" title="Promote student to instructor" href="{{ URL::to('/admin/student/promote/'.$user['personal']->id);}}" data-original-title="Promote to Instructor"><i class="glyphicon glyphicon-star-empty"></i></a> 		
		@endif
		<a class="btn btn-danger confirm" title="Remove this student" href="{{ URL::to('/admin/student/deactivate/'.$user['personal']->id);}}" data-original-title="Deactivate this student"><i class="glyphicon glyphicon-trash icon-white"></i></a>
		</div>		  
	  
	  </td>
	</tr>
	@endforeach
  </tbody>
	</table>
@endsection