@layout('layouts.default')
@section('title')
{{$data['title']}}
@endsection
@section('content')
<h2>{{$data['title']}}</h2>
@if(!empty($data['quests']))
  <table class="table table-hover sortable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th class="filter-select" data-placeholder="Select...">Category</th>
                    <th>Instructions</th>
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
                    <a class="btn btn-primary pull-right" href="{{ URL::to('admin/quest/grade/'.$quest->id);}}">Grade</a>
                    </td>
                  </tr>
  				@endforeach

                </tbody>
              </table>
@else
  <p class="lead">No quests available...</p>
  <a class="btn btn-primary btn-large pull-right" href="{{URL::to('admin/quest/create')}}">Create Quest</a>

@endif
@endsection