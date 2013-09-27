@layout('layouts.default')
@section('title')
{{$data['title']}}
@endsection
@section('content')
<div class="container">
    <h2>{{$data['title']}}</h2>
    <form class="form-inline form-group pull-right" role="form">
      <div class="form-group">
          {{ Form::text('quest_title', '', array('id' => 'quest_filter', 'placeholder' => 'Quest Title', 'class' => 'form-control input-md')); }}
      </div>
      <div class="form-group">
          {{ Form::select('category', $data['categories'], '', array('class' => 'selectpicker', 'data-placeholder' => 'Category Filter', 'id' => 'category-select')) }}
      </div>
    </form>

</div>
@if (count($data['quests']) > 0)
@foreach($data['quests'] as $quest)
<div class="col-md-4 quest-box">
    <span style="display:none" class="quest_category">{{$quest->category}}</span>    
    <div class="panel panel-default"  style="min-height: 140px">
    <div class="panel-heading">             
     <button class="btn btn-default btn-xs pull-right" data-toggle="collapse" data-target="#quest{{$quest->id}}" type="button">
         <span class="glyphicon glyphicon-chevron-down"></span>
     </button>  
            <h3 class="panel-title" data-toggle="collapse" data-target="#quest{{$quest->id}}">{{$quest->name}}</h3>
        </div>
        <div class="panel-body">
            @if($quest->type != 1)
                    <a class="btn btn-primary btn-sm pull-right" href="{{ URL::to('quest/attempt/'.$quest->id);}}">Attempt</a>
            @else
            <span class="btn btn-default disabled pull-right">In Class</span>
            @endif

            <h5>{{$quest->category}}</h5>
            
                        
            <div id="quest{{$quest->id}}" class="more-info collapse">
            @foreach($quest->max_skills as $skill)
              <h6>{{$skill->amount}} {{$skill->name}}</h6>
            @endforeach

            <div>{{$quest->instructions}}</div>
            @if($quest->filename)
                <h6>Files</h6>
                <ul class="list-unstyled">
                  @foreach(explode(",",$quest->filename) as $file)
                    <li><a href="{{$file}}">{{Str::limit(Filepicker::metadata($file)->filename,25)}}</a></li>
                  @endforeach
                </ul>
            @endif



            
            </div>

            

        </div>
    </div>

</div>
@endforeach

@else
<p class="lead">No quests available, stay tuned!</p>
@endif
@endsection