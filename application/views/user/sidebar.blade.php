@if($info)
    @if($info->is_instructor)
			@if(!$info->setup_complete)
				<h5>Course Setup</h5>
				<h6>
					@if (!$info->skills)
					@else
						<i class="icon-ok"></i>
					@endif
					<a href='{{URL::to("admin/skills")}}'>Skills</a>
				</h6>

				<h6>
					@if(!$info->current_level)
					@else 
						<i class="icon-ok"></i>
					@endif
				<a href='{{URL::to("admin/levels")}}'>Levels</a>
				</h6>
				<h6>
				    @if(!$info->has_quests)
					@else 
						<i class="icon-ok"></i>
					@endif
				<a href='{{URL::to("admin/quest/create")}}'>Quests</a>
				</h6>

				<h6>
					@if(!$info->has_posts)
					@else 
						<i class="icon-ok"></i>
					@endif
				<a href='{{URL::to("admin/post/create")}}'>Posts</a>
				</h6>

			@endif
                

                @if($info && $info->setup_complete)
                <div class="visible-md visible-lg">

                    <ul class="nav nav-stacked">
                        <li><h6>Grade</h6></li>
                        <li><a class="nowrap" href="{{ URL::to('admin/submissions');}}">Submissions <span class="badge">{{$info->ungraded}}</span></a></li>
				  		<li><a href="{{ URL::to('admin/grade');}}">In Class Work</a></li>
                        <li><h6>Manage</h6></li>
				  		<li><a href="{{ URL::to('admin/quests');}}">Quests</a></li>
                        <li><a href="{{ URL::to('admin/students');}}">Students</a></li>
				  		<li><a href="{{ URL::to('admin/posts');}}">Posts</a></li>
				  	</ul>
                </div>

                <div class="visible-sm visible-xs">

                    <ul class="nav nav-pills">
				  		<li><a href="{{ URL::to('admin/quests');}}">Quests</a></li>
                        <li><a href="{{ URL::to('admin/students');}}">Students</a></li>
				  		<li><a href="{{ URL::to('admin/posts');}}">Posts</a></li>
                        <li><a href="{{ URL::to('admin/submissions');}}">Submissions</a></li>
				  		<li><a href="{{ URL::to('admin/grade');}}">In Class Work</a></li>
				  	</ul>
                </div>


                @endif

        @else

			@if($info)
				@if ($info->available_quests || $info->completed_quests)

                    <ul class="nav nav-stacked">
                        <li><h6>Quests</h6></li>
    
                    @if ($info->available_quests)
                        <li><a href="{{ URL::to('quests');}}">{{$info->available_quests}} Available</a></li>
                    @endif
                        
                    @if($info->completed_quests)
                        <li><a href="{{ URL::to('quests/completed');}}">{{$info->completed_quests}} Completed</a></li>
                    @endif
                    </ul>
            <hr>
            @endif
                @if($info->current_level)
					<h5>{{$info->current_level->label}}</h5>
				@else
					<h5><span class="label label-important">No Levels Created Yet</span></h5>
				@endif
				@if ($info->skills)
					@foreach($info->skills as $skill)
					
					<h6 class="muted">{{$skill['name']}}</h6>
					<div class="progress">
						@if($info->next_level == 0)
						<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        <span class="sr-only">{{$skill['amount']}}</span>
                        </div>
                        @else
						<div class="progress-bar progress-bar-success" role="progressbar" style="width: {{$skill['amount']/$info->next_level*100}}%;" aria-valuenow="{{$skill['amount']/$info->next_level*100}}" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">{{$skill['amount']}}</span>
                        </div>
						@endif
					</div>
					@endforeach
				@endif
			@endif
		@endif
	@endif