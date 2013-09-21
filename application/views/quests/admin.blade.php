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
                  <th class="filter-false" data-sorter="false"></th>
                </tr>
              </thead>
              <tbody>
            	@foreach($data->quests as $quest)
                <tr>
                  <td>
                      <div class="visible-md visible-lg">
                      <a href="{{URL::to('admin/quest/update/'.$quest->id);}}">{{$quest->name}}</a> <span class="label label-info pull-right">{{$quest->category}}</span>                     
                      </div>
                      <div class="visible-sm visible-xs">
                      {{$quest->name}}
                      </div>
                      </td>
                  <td>
                    <div class="visible-sm visible-xs">
                        <a data-toggle="modal" href="#questModal{{$quest->id}}" class="btn btn-default pull-right btn-xs">Options</a>
                          <div class="modal fade" id="questModal{{$quest->id}}" tabindex="-1" role="dialog" aria-labelledby="questModal{{$quest->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title">{{$quest->name}}</h4>
                                </div>
                                <div class="modal-body">
    <a class="btn btn-default btn-block" href="{{URL::to('admin/quests/completed/'.$quest->id);}}" data-original-title="Student Progress on Quest"><span class="glyphicon glyphicon-tasks"></span> Show Progress</a>
                <a class="btn btn-default btn-block" href="{{URL::to('admin/quest/clone/'.$quest->id);}}" data-original-title="Clone Quest"><span class="cc-icon sprite-clone"> </span>Clone This Quest</a>
    
                            @if ($quest->visible)
                            <a class="btn btn-default btn-block" title="Hide" href="{{ URL::to('/admin/quest/hide/'.$quest->id);}}"><span class="glyphicon glyphicon-eye-close"></span> Hide This Quest</a>
                            @else
                            <a class="btn btn-default btn-block" title="Show" href="{{ URL::to('/admin/quest/show/'.$quest->id);}}"><span class="glyphicon glyphicon-eye-open"></span> Show This Quest</a>
                            
                            @endif
                            <a class="btn btn-danger btn-block" href="{{ URL::to('/admin/quest/trash/'.$quest->id);}}" title="Remove this quest and everything related to it"><span class="glyphicon glyphicon-eye-close"></span> Delete This Quest</a>
                                  </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                        
                        
                    </div>
					<div class="btn-group pull-right visible-md visible-lg">
						<a class="btn btn-default btn-xs" href="{{URL::to('admin/quests/completed/'.$quest->id);}}" data-original-title="Student Progress on Quest"><span class="glyphicon glyphicon-tasks"></span></a>
            <a class="btn btn-default btn-xs" href="{{URL::to('admin/quest/clone/'.$quest->id);}}" data-original-title="Clone Quest"><span class="cc-icon sprite-clone"> </span></a>

						@if ($quest->visible)
						<a class="btn btn-default btn-xs" title="Hide" href="{{ URL::to('/admin/quest/hide/'.$quest->id);}}"><span class="glyphicon glyphicon-eye-close"></span></a>
						@else
						<a class="btn btn-default btn-xs" title="Show" href="{{ URL::to('/admin/quest/show/'.$quest->id);}}"><span class="glyphicon glyphicon-eye-open"></span></a>
						
						@endif
						<a class="btn btn-danger btn-xs" href="{{ URL::to('/admin/quest/trash/'.$quest->id);}}" title="Remove this quest and everything related to it"><span class="glyphicon glyphicon-trash"></span></a>
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