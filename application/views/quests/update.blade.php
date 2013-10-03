@layout('layouts.default')
@section('content')
		<a name="createquest"></a>
		<div class="btn-group pager pull-right">
		  <button class="btn btn-xs btn-primary pager-previous disabled">Previous</button>
		  <button class="btn btn-default btn-xs page disabled">Info</button>
		  <button class="btn btn-default btn-xs page disabled">Skills</button>
		  <button class="btn btn-default btn-xs page disabled">Thresholds</button>
		  <button class="btn btn-default btn-xs page disabled">Category</button>
		  <button class="btn btn-default btn-xs page disabled">Files</button>
		  <button class="btn btn-default btn-xs btn-primary pager-next">Next</button>
		
		</div>
		

		<h2>Update Quest</h2>

		{{ Form::open('admin/quest/update', 'POST', array('class' => 'well')); }}
<fieldset>
		
	<div class="form-group quest-wizard-page" id="quest-info">	
			<div class="controls form-group">

        {{ Form::text('title', $quest->name, array('placeholder' => 'Quest Name', 'class' => 'input-lg form-control')); }}

        {{ Form::textarea('instructions', $quest->instructions, array('placeholder' => 'Instructions go here...', 'class' => 'wysiwyg-area form-control', 'id' => 'quest-instructions', 'required' => '', 'style' => 'width: 100%')); }}
            </div>
		<a href="#createquest" class="btn btn-default pull-right next-step">Next</a>
    </div>

		
	
    <div class="form-group quest-wizard-page" id="quest-skills-rewards" style="display:none">	
        <div class="controls form-group">

        <p class="help-text">Upon completing a quest, a student is rewarded with points in the skills associated with the quest.  When you grade an attempted quest, you'll be able to assign points per skill based upon the values you create here. Labels show up for you when grading a quest in a drop down list.  Students only see the amount of points rewarded.  <em>You must add skill point values in order to assign points to a quest.</em></p>
        <div class="controls">
            @foreach($quest->skills as $skill)
			<h4>{{$skill['name']}}</h4>
				<div class='skill_reward form-inline'>
				@foreach($skill['rewards'] as $reward)
					{{ Form::label('reward_label', $reward->label, array('class' => 'control-label', 'style' => 'padding-right: 10px;padding-left:10px')); }}
					{{ Form::hidden('skill_reward['.$reward->skill_id.'][label][]', $reward->label); }}
					{{ Form::text('skill_reward['.$reward->skill_id.'][amount][]', $reward->amount, array('placeholder' => 'Point Value', 'class' => 'input-md form-control', 'style' => 'width: 35.5%')); }}
				@endforeach
				</div>
			@endforeach
            </div>
        </div>
		  <a href="#createquest" class="btn btn-default pull-right next-step">Next</a>
    </div>
    
	
	<div class="form-group quest-wizard-page" id="quest-threshold" style="display:none">
        <div class="controls form-group">

		<p class="help-text">By default, quests are available to all students.  Sometimes a quest should only be available to students that have achieved a certain level or higher.  If you want to limit the availability of this quest to a higher skill level, you can set it here.</p>
			@foreach($quest->all_skills as $key => $skill)
				<div class="controls" style="margin-bottom: 10px">
				{{ Form::label('skill_type', $skill, array('class' => 'control-label pull-left', 'style' => 'width:150px')); }}
				{{ Form::select('threshold_skill_level['.$key.'][]', $quest->levels, '', array('id' => 'skill'.$key, 'class' => 'selectpicker', 'data-placeholder' => 'No Threshold', 'tabindex' => '-1')) }}
			</div>	
			
				@if(array_key_exists($key,$quest->locks))			
					<script>
						document.getElementById('skill'+<?=$key;?>).value = <?=$quest->locks[$key]?>;
					</script>
				@endif
			@endforeach
        </div>
		<a href="#createquest" class="btn btn-default pull-right next-step">Next</a>

	</div>

	<div class="form-group quest-wizard-page" id="quest-category" style="display:none">	
        <div class="controls form-group">

        <p class="help-text">Quests can be grouped into categories.  If you'd like to group this quest into a category, just type in the name.</p>
			<div class="controls">
			    {{ Form::text('category', $quest->category, array('placeholder' => 'Category name', 'class' => 'input-md form-control')); }}
			</div>
        </div>
		<a href="#createquest" class="btn btn-default pull-right next-step">Next</a>
	</div>
	
	<div class="form-group quest-wizard-page" id="quest-files" style="display:none">
        <div class="controls form-group">

        <p class="help-text">You can attach supplemental files to each quest.  For example, a web design class might include a starter template.  A math class might have a handout with formulas.</p>
			@if(!empty($quest->files))
				<ul class="list-inline">
				@foreach($quest->files as $file)
					<li>{{$file['friendly']}} {{ Form::hidden('existingFiles[]', $file['encoded'])}} <a class="btn btn-danger btn-xs btn-remove-file" href=''>Remove</a></li>
				@endforeach
				</ul>
			@endif
			<div class="controls">
				<input type="filepicker-dragdrop" name="files" data-fp-button-text="Add Files" data-fp-services="COMPUTER,DROPBOX,BOX,GOOGLE_DRIVE,GMAIL" data-fp-multiple="true" class=""/>
			</div>
            </div>
	       <div class="form-group">
		  {{ Form::hidden('quest_id', $quest->id); }}
		
               {{ Form::submit('Update Quest', array('class' => 'btn btn-submit btn-primary pull-right btn-lg', 'data-loading-text' => 'Updating Quest...')); }}
	       </div>

    </div>


	</fieldset>
	

<?php echo Form::close(); ?>

@endsection