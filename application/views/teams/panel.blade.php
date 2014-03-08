<h4>Teams</h4>
<p class="help-text">If you run a very large class or have multiple sections, you can categorize them with teams. This is purely administrative and not required.
</p>

<?php echo Form::open('admin/teams', 'POST', array('class' => 'form-inline', 'role' => 'form')); ?>
<div class="form-group">
<?php echo Form::text('label', '', array('placeholder' => 'Team Name', 'class' => 'input-md form-control')); ?>
</div>

<div class="form-group">

    <?php echo Form::hidden('tab', 'teams'); ?> 
</div>

<?php echo Form::submit('Add This Team', array('class' => 'btn btn-primary pull-right'));?>

<?php echo Form::close(); ?>
@if($course->teams)
	<h5>Current Teams</h5>
	<table class="table table-hover">
		<thead>
		</thead>
		<tbody>
	@foreach($course->teams as $team)
			<tr>
			<td>
			<?php echo Form::open('admin/team/edit', 'POST', array('class' => 'form-inline')); ?>
			<div class="team">{{$team->label}}</div>
			</td>
			<td>
			<div class="pull-right">
				<div class="btn-toolbar">
					<div class="btn-group">
					  <a rel="tooltip" data-original-title='Edit team' data-toggle="modal" href="#teamEdit{{$team->id}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
					  <div class="modal fade" id="teamEdit{{$team->id}}" tabindex="-1" role="dialog" aria-labelledby="teamEdit{{$team->id}}Label" aria-hidden="true">
						<div class="modal-dialog">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							  <h4 class="modal-title">Editing {{$team->label}}</h4>
							</div>
							<?php echo Form::open('admin/team/edit', 'POST', array('class' => 'form-horizontal')); ?>
							<div class="modal-body">
								<div class="form-group">
								<label for="label" class="control-label">Team Name</label>
									<?php echo Form::text('label', $team->label, array('placeholder' => 'Team Name', 'class' => 'input-md form-control')); ?>
	                                <?php echo Form::hidden('team_id', $team->id); ?>

								</div>
							  </div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<?php echo Form::hidden('tab', 'teams'); ?> 
								<?php echo Form::submit('Save', array('class' => 'btn btn-primary'));?>
							</div>
								<?php echo Form::close(); ?>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					  </div><!-- /.modal -->                                    
			<a class="btn btn-danger btn-xs" href="{{URL::to('admin/team/delete/'.$team->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
				</div>
			</div>
		</div>
		</td>
		</tr>

	@endforeach
		</tbody>
	</table>
@else
@endif