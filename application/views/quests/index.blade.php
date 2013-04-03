@layout('layouts.default')
@section('title')
{{$data['title']}}
@endsection
@section('content')

<h2>{{$data['title']}}</h2>
@if (count($data['quests']) > 0)
<table class="table table-hover sortable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th class="filter-select" data-placeholder="All">Category</th>
                  <th class="filter-false" data-sorter="false">Instructions</th>
                  <th class="filter-false" data-sorter="false">Max Skills</th>
                  <th class="filter-false" data-sorter="false"></th>
                  <th class="filter-false" data-sorter="false"></th>
                </tr>
              </thead>
              <tbody>
            	@foreach($data['quests'] as $quest)
                <tr>
                  <td><span style="white-space:nowrap;"><strong>{{$quest->name}}<strong></span></td>
                  <td>{{$quest->category}}</td>
                  <td>{{$quest->instructions}}</td>
                  <td>
                    @foreach($quest->max_skills as $skill)
                      <p>
                        <em>{{$skill->amount}} {{$skill->name}}</em>
                      </p>
                    @endforeach
                  </td>

                  <td>
	                  @if($quest->filename)
        						  @foreach(explode(",",$quest->filename) as $file)
        							<a class="btn btn-mini btn-info" href="{{$file}}"><span style="white-space:nowrap;">{{Filepicker::metadata($file)->filename}}</span></a> 
        						  @endforeach
          					@endif
                  </td>

                  <td>
                  @if($quest->type != 1)
                    <a class="btn btn-primary pull-right" href="{{ URL::to('quest/attempt/'.$quest->id);}}">Attempt</a>
        				  @else
				          
                  @endif
                  </td>
                </tr>
				      @endforeach

              </tbody>
            </table>
@else
<p class="lead">No quests available, stay tuned!</p>
@endif
@endsection