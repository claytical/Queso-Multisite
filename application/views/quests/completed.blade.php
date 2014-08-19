@layout('layouts.default')
@section('content')
<div class="container">
    <h2>Completed Quests</h2>
    <form class="form-inline form-group pull-right" role="form">
      <div class="form-group">
          {{ Form::text('quest_title', '', array('id' => 'quest_filter', 'placeholder' => 'Quest Title', 'class' => 'form-control input-md')); }}
      </div>
      <div class="form-group">
          {{ Form::select('category', $data->categories, '', array('class' => 'selectpicker', 'data-placeholder' => 'Category Filter', 'id' => 'category-select')) }}
      </div>
    </form>

</div>

@if (count($data->quests) > 0)
@foreach($data->quests as $quest)
<div class="col-md-4 quest-box">
    <span style="display:none" class="quest_category">{{$quest['category']}}</span>
    <div class="panel panel-default"  style="min-height: 140px">
    <div class="panel-heading">   
     <button class="btn btn-default btn-xs pull-right" data-toggle="collapse" data-target="#quest{{$quest['quest_id']}}" type="button">
         <span class="glyphicon glyphicon-chevron-down"></span>
     </button>
         <h3 class="panel-title">
                  	{{$quest['name']}}
        </h3>
        </div>
        <div class="panel-body">
            @if($quest['type'] != 1)
                <a class="btn btn-primary btn-sm pull-right" href="{{URL::to('submission/revise/'.$quest['submission']->id)}}">Revise</a>
            @else
            <span class="label label-info">In Class</span>
            @endif
			@if($quest['note'])
			<button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modalQuestNote{{$quest['quest_id']}}">
  <span class="glyphicon glyphicon-comment"></span>
</button>

<!-- Modal -->
<div class="modal fade" id="modalQuestNote{{$quest['quest_id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">{{$quest['name']}}</h4>
      </div>
      <div class="modal-body">
						{{$quest['note']}}
      					@if($quest['skills'])
						<ul class="list-unstyled">
								@foreach($quest['skills'] as $skill)
								<li><em>{{$skill->amount}} {{$skill->name}}</em>        
                                    <div class="progress">
                                        @if($data->questMaxPoints[$quest['quest_id']][$skill->id] != 0)
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$skill->amount}}" aria-valuemin="0" aria-valuemax="{{$data->questMaxPoints[$quest['quest_id']][$skill->id]}}" style="width: {{$skill->amount/$data->questMaxPoints[$quest['quest_id']][$skill->id] * 100}}%;">
                                            <span class="sr-only">{{$skill->amount}}</span>
                                        @endif
                                        </div>
                                    </div>                                    
								</li>
								@endforeach
						</ul>
						@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
			
			
			@endif

            <h5>
                <?php $created_date = strtotime($quest['completed']);?>
				{{date("F j, Y", $created_date);}}
            </h5>
            <div id="quest{{$quest['quest_id']}}" class="more-info collapse">
				
                <h6>{{$quest['category']}}</h6>
					@if($quest['skills'])
						<ul class="list-unstyled">
								@foreach($quest['skills'] as $skill)
								<li><em>{{$skill->amount}} {{$skill->name}}</em>        
                                    <div class="progress">
                                        @if($data->questMaxPoints[$quest['quest_id']][$skill->id] != 0)
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$skill->amount}}" aria-valuemin="0" aria-valuemax="{{$data->questMaxPoints[$quest['quest_id']][$skill->id]}}" style="width: {{$skill->amount/$data->questMaxPoints[$quest['quest_id']][$skill->id] * 100}}%;">
                                            <span class="sr-only">{{$skill->amount}}</span>
                                        @endif
                                        </div>
                                    </div>                                    
								</li>
								@endforeach
						</ul>
					@else						
						<em>Pending</em>
					@endif

            </div>
            </div>
        </div>
    </div>
@endforeach
<div class="col-md-4 quest-box quest-totals">
    <div class="panel panel-success" style="min-height: 140px">
        <div class="panel-heading">
        Totals
        </div>
        <div class="panel-body">
            <ul class="list-unstyled">
                @foreach($data->skills as $skill)
                    <li>{{$skill['label']}}
                        <span class="pull-right">
                        @if($skill['amount'])
                            {{$skill['amount']}}
                        @else
                            0
                        @endif
                        </span>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>

@else
<p class="lead">No quests available, stay tuned!</p>
@endif
@endsection