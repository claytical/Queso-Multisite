@layout('layouts.default')
@section('title')
Post Administration
@endsection
@section('content')

<h2>Posts</h1>
	
@if (count($posts) > 0)
<table class="table table-hover sortable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th class="filter-false" data-sorter="false"></th>
                  <th class="filter-false" data-sorter="false"></th>
                </tr>
              </thead>
              <tbody>
            	@foreach($posts as $post)
                <tr>
                  <td><span style="white-space:nowrap;"><strong><a href="{{ URL::to('/admin/post/update/'.$post->id)}}">{{$post->headline}}</a><strong></span></td>
                  <td>{{$post->post}}</td>
                  <td>
					<div class="btn-group pull-right">
						@if($post->position == 0)		
						<a href="{{ URL::to('/admin/post/sticky/'.$post->id);}}" class="btn" title="Make Post Sticky"><i class="icon-flag"></i></a>
						@else
						<a href="{{ URL::to('/admin/post/unstick/'.$post->id);}}" class="btn" title="Unstick Post"><i class="icon-minus-sign"></i></a>

						@endif
						<a href="{{ URL::to('/admin/post/trash/'.$post->id);}}" class="btn btn-danger" title="Delete Post"><i class="icon-trash icon-white"></i></a>

						@if($post->frontpage)
						<a href="{{ URL::to('/admin/post/demote/'.$post->id);}}" class="btn btn-warning" title="Demote from front page"><i class="icon-arrow-down icon-white"></i></a>
						@else
						<a href="{{ URL::to('/admin/post/promote/'.$post->id);}}" class="btn btn-success" title="Promote from front page"><i class="icon-arrow-up icon-white"></i></a>						
						@endif
						@if($post->menu)
						<a href="{{ URL::to('/admin/post/remove-menu/'.$post->id);}}" class="btn" title="Remove from menu" data-original-title="Remove from menu"><i class="icon-minus"></i></a>
						@else
						<a href="{{ URL::to('/admin/post/add-menu/'.$post->id);}}" class="btn" title="Add to menu" data-original-title="Add to menu"><i class="icon-plus"></i></a>
						@endif
					</div>
		          </td>
                </tr>
				@endforeach

              </tbody>
            </table>
@else
<p class="lead">Nothing posted</p>
<a class="btn btn-primary btn-large pull-right" href="{{URL::to('admin/post/create')}}">Create Post</a>

@endif
@endsection