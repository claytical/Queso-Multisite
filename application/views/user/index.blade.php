@layout('layouts.default')
@section('content')
<h2>User Administration</h2>
<table class="table sortable">
	<thead>
	<th>Name</th>
	<th>Email</th>
    <th class="filter-false" data-sorter="false"></th>
	</thead>
  	<tbody>
	@foreach ($users as $user)
	<tr>
	  <td><a href="{{ URL::to('/admin/student/details/'.$user->id);}}">{{$user->username}}</a></td>
	  <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
	  <td>
<div class="btn-group-sm pull-right">
		@if($user->super)
		<a class="btn btn-default" title="Remove Super Admin" href="{{ URL::to('/super/admin/demote/'.$user->id);}}" data-original-title="Super Admin"><i class="icon-star"></i></a> 
		@else
		<a class="btn btn-default" title="Promote to Super Admin" href="{{ URL::to('/super/admin/promote/'.$user->id);}}" data-original-title="Super Admin"><i class="icon-star-empty"></i></a> 
		@endif
		<a class="btn btn-default btn-danger confirm" title="Remove this student" href="{{ URL::to('/super/student/deactivate/'.$user->id);}}" data-original-title="Deactivate this student"><i class="icon-trash icon-white"></i></a>
		</div>		  
	  
	  </td>
	</tr>
	@endforeach
  </tbody>
	</table>
@endsection