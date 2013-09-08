@layout('layouts.default')
@section('content')
<h1>{{$data->quest->name}}</h1>
	<?php echo Form::open('admin/skill/bulk/remove', 'POST', array('class' => '')); ?>
	<?php echo Form::submit('Remove Checked Skills', array('class' => 'btn btn-danger btn-mini pull-right'));?>
	<?php echo Form::hidden('quest_id', $data->quest->id);?>
	<table class="table table-hover sortable">
				  <thead>
					<tr>
					  <th>Skill</th>
	                  <th class="filter-false" data-sorter="false">Amount</th>
					  <th class="filter-false" data-sorter="false">Label</th>
					</tr>
				  </thead>
				  <tbody>
					@foreach($data->skills as $skill)
					<tr>
					  <td>
						<span style="white-space:nowrap;">
						<div class="control-group">	
							<div class="controls">
						  	<label class="checkbox"> {{ Form::checkbox('removeSkill[]', $skill['id'])}}

							{{$skill['name']}}</label>
							</div>
						</div>

						</span>
						</td>
					  <td>
							{{$skill['amount']}}	
					  </td>
					  <td>
					  		{{$skill['label']}}
					  </td>
					</tr>
					@endforeach
	
				  </tbody>
				</table>
			<?php echo Form::close(); ?>

@endsection