@layout('layouts.default')
@section('title')
Quest Admin
@endsection
@section('content')

<h2>Quests <a href='{{URL::to("admin/quest/create")}}' class="btn btn-lg btn-primary pull-right">New Quest</a></h2>
<div class="container">
@if (count($data->quests) > 0)
<table class="table sortable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th class="filter-select" data-placeholder="All">Category</th>
                  <th class="filter-false" data-sorter="false"></th>
                </tr>
              </thead>
              <tbody>
            	@foreach($data->quests as $quest)
                <tr>
                  <td><a href="{{URL::to('admin/quest/update/'.$quest->id);}}">{{$quest->name}}</a></td>
                  <td>{{$quest->category}}</td>
                  <td>
					<div class="btn-group pull-right">
						<a class="btn btn-default btn-xs" href="{{URL::to('admin/quests/completed/'.$quest->id);}}" data-original-title="Student Progress on Quest">Progress</a>
            <a class="btn btn-default btn-xs" href="{{URL::to('admin/quest/clone/'.$quest->id);}}" data-original-title="Clone Quest">Clone</a>

						@if ($quest->visible)
						<a class="btn btn-default btn-xs" title="Hide" href="{{ URL::to('/admin/quest/hide/'.$quest->id);}}">Hide</a>
						@else
						<a class="btn btn-default btn-xs" title="Show" href="{{ URL::to('/admin/quest/show/'.$quest->id);}}">Show</a>
						
						@endif
						<a class="btn btn-danger btn-xs" href="{{ URL::to('/admin/quest/trash/'.$quest->id);}}" title="Remove this quest and everything related to it">Trash</a>
						</div>
                  </td>
                </tr>
				@endforeach

              </tbody>
            </table>
@else
<p class="lead">No quests available</p>
<a class="btn btn-primary btn-lg pull-right" href="{{URL::to('admin/quest/create')}}">Create Quest</a>
@endif
</div>
@endsection