@layout('layouts.default')
@section('title')
{{$data['title']}}
@endsection
@section('content')
<h2>{{$data['title']}}</h2>
@if(!empty($data['quests']))
<table class="table table-hover table-responsive">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th class="visible-md visible-lg" data-placeholder="All Categories">Category</th>
                 </tr>
                </thead>
                <tbody>
              	@foreach($data['quests'] as $quest)
                  <tr>
                    <td><span style="white-space:nowrap;"><strong>{{$quest->name}}</strong></span>                     <a class="btn btn-primary btn-sm pull-right hidden-md hidden-lg" href="{{ URL::to('admin/quest/grade/'.$quest->id);}}">Grade</a>
                      </td>
                    <td class="visible-md visible-lg">{{$quest->category}}
                        <a class="btn btn-primary btn-sm pull-right" href="{{ URL::to('admin/quest/grade/'.$quest->id);}}">Grade</a>
                    </td>
                  </tr>
  				@endforeach

                </tbody>
              </table>
@else
  <p class="lead">No quests available...</p>
  <a class="btn btn-primary btn-lg pull-right" href="{{URL::to('admin/quest/create')}}">Create Quest</a>

@endif
@endsection