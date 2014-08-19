@layout('layouts.default')
@section('title')
Quest Admin
@endsection
@section('content')

<h2> </h2>
<div class="container">
	@if(!empty($data->postInfo))
	<?php var_dump($data->postInfo);?>

	@endif
	<div class="col-md-9">
	@if (count($data->quests) > 0)
	<table class="table table-hover">
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
						  <a href="{{URL::to('admin/quest/update/'.$quest->id);}}">{{$quest->name}}</a> <span class="label label-info pull-right category">{{$quest->category}}</span>                     
						@foreach($quest->required as $mskills)
							<div class="required_skill hidden"><span class="required_skill_id">{{$mskills->skill_id}}</span> <span class="required_skill_amount">{{$mskills->requirement}}</span></div>
							
						@endforeach
						  </div>
						  <div class="visible-sm visible-xs">
						  {{$quest->name}}<span class="hidden category">{{$quest->category}}</span>
						@foreach($quest->required as $mskills)
							<div class="required_skill hidden"><span class="required_skill_id">{{$mskills->skill_id}}</span> <span class="required_skill_amount">{{$mskills->requirement}}</span></div>
							
						@endforeach

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

	<div class="visible-md visible-lg">
		<div class="btn-group pull-right">
	  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
		Options <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu" role="menu">
			
		<li><a class="" href="{{URL::to('admin/quests/completed/'.$quest->id);}}" data-original-title="Student Progress on Quest">Student Progress</a></li>
		<li><a class="" href="{{URL::to('admin/quest/clone/'.$quest->id);}}" data-original-title="Clone Quest">Clone Quest</a></li>
		<li>
			@if ($quest->visible)
			<a title="Hide" href="{{ URL::to('/admin/quest/hide/'.$quest->id);}}">Hide Quest</a>
			@else
			<a title="Show" href="{{ URL::to('/admin/quest/show/'.$quest->id);}}">Show Quest</a>						
			@endif
		</li>

		<li><a href="{{ URL::to('/admin/quest/trash/'.$quest->id);}}" title="Remove this quest and everything related to it">Remove Quest</a></li>
	  </ul>
	</div>
	</div>


					  </td>
					</tr>
					@endforeach

				  </tbody>
				</table>
	@else
	<p class="lead">No quests available</p>
	<a class="btn btn-primary btn-md pull-right" href="{{URL::to('admin/quest/create')}}">Create Quest</a>
	@endif
	</div>

	<div class="col-md-3">
			<div class="row">
			<a href='{{URL::to("admin/quest/create")}}' class="btn btn-md btn-primary btn-block">New Quest</a>
			</div>
		
			<hr>
			
			<div class="row">
		<?php echo Form::open('admin/quests', 'POST', array('class' => 'form')); ?>

				  <div class="form-group">
        		  {{ Form::select('category', $data->categories, '', array('class' => 'selectpicker', 'data-placeholder' => 'Category Filter', 'id' => 'category-select')) }}

				  </div>
			<h6>Requirements</h6>
				@foreach($data->skills as $skill)
				  <div class="form-group">
				  <strong>{{$skill->name}}</strong>
        		  {{ Form::select('level['.$skill->id.']', $data->levels, '', array('class' => 'selectpicker selectskill', 'data-placeholder' => 'Category Filter', 'id' => 'skill-select-'.$skill->id, 'rel' => $skill->id)) }}
				  </div>
				@endforeach
				  <div class="form-group">
				<a href='#' class="btn btn-md btn-primary btn-block" onclick="filterQuests()">Filter</a>

				  </div>

			<?php echo Form::close(); ?>

			</div>
			</div>

</div>
@endsection