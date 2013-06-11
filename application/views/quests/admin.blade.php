@layout('layouts.default')
@section('title')
Quest Admin
@endsection
@section('content')
<h2>Quests</h2>

@if (count($data->quests) > 0)
<table class="table sortable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th class="filter-select" data-placeholder="All">Category</th>
                  <th class="filter-false">Instructions</th>
                  <th class="filter-false" data-sorter="false"></th>
                </tr>
              </thead>
              <tbody>
            	@foreach($data->quests as $quest)
                <tr>
                  <td><span style="white-space:nowrap;"><strong><a href="{{URL::to('admin/quest/update/'.$quest->id);}}">{{$quest->name}}</a><strong></span></td>
                  <td>{{$quest->category}}</td>
                  <td>{{$quest->instructions}}</td>
                  <td>
					<div class="btn-group">
						<a class="btn" href="{{URL::to('admin/quests/completed/'.$quest->id);}}" data-original-title="Student Progress on Quest"><i class="icon-user"></i></a>
            <a class="btn" href="{{URL::to('admin/quest/clone/'.$quest->id);}}" data-original-title="Clone Quest"><i class="icon-repeat"></i></a>

						@if ($quest->visible)
						<a class="btn" title="Hide" href="{{ URL::to('/admin/quest/hide/'.$quest->id);}}"><i class="icon-eye-close"></i></a>
						@else
						<a class="btn" title="Show" href="{{ URL::to('/admin/quest/show/'.$quest->id);}}"><i class="icon-eye-open"></i></a>
						
						@endif
						<a class="btn btn-danger" href="{{ URL::to('/admin/quest/trash/'.$quest->id);}}" title="Remove this quest and everything related to it"><i class="icon-trash icon-white"></i></a>
						</div>
                  </td>
                </tr>
				@endforeach

              </tbody>
            </table>
@else
<p class="lead">No quests available</p>
<a class="btn btn-primary btn-large pull-right" href="{{URL::to('admin/quest/create')}}">Create Quest</a>
@endif
@endsection