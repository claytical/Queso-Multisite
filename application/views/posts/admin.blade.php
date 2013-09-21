@layout('layouts.default')
@section('title')
Post Administration
@endsection
@section('content')


<h2>Posts<a href='{{URL::to("admin/post/create")}}' class="btn btn-lg btn-primary pull-right">New Post</a></h2>
<div class="container">
@if (count($posts) > 0)
<table class="table table-hover sortable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th class="filter-false" data-sorter="false"></th>
                </tr>
              </thead>
              <tbody>
            	@foreach($posts as $post)
                <tr>
                  <td><a href="{{ URL::to('/admin/post/update/'.$post->id)}}">{{$post->headline}}</a></td>
                  <td>

                      
                    <div class="visible-sm visible-xs">
                        <a data-toggle="modal" href="#postModal{{$post->id}}" class="btn btn-default pull-right btn-xs">Options</a>
                          <div class="modal fade" id="postModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="postModal{{$post->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title">{{$post->headline}}</h4>
                                </div>
                                <div class="modal-body">
						@if($post->position == 0)		
						<a href="{{ URL::to('/admin/post/sticky/'.$post->id);}}" class="btn btn-default btn-block" title="Make Post Sticky">Make Sticky</a>
						@else
						<a href="{{ URL::to('/admin/post/unstick/'.$post->id);}}" class="btn btn-default btn-block" title="Unstick Post">Remove Sticky</a>
						@endif

						@if($post->frontpage)
						<a href="{{ URL::to('/admin/post/demote/'.$post->id);}}" class="btn btn-block btn-default" title="Demote from front page">Demote from Front Page</a>
						@else
						<a href="{{ URL::to('/admin/post/promote/'.$post->id);}}" class="btn btn-block btn-default" title="Promote from front page">Promote to Front Page</a>						
						@endif
						@if($post->menu)
						<a href="{{ URL::to('/admin/post/remove-menu/'.$post->id);}}" class="btn btn-default btn-block" title="Remove from menu" data-original-title="Remove from menu">Remove from Menu</a>
						@else
						<a href="{{ URL::to('/admin/post/add-menu/'.$post->id);}}" class="btn btn-default btn-block" title="Add to menu" data-original-title="Add to menu">Add to Menu</a>
						@endif
						<a href="{{ URL::to('/admin/post/trash/'.$post->id);}}" class="btn btn-danger btn-block" title="Remove Post Permanently">Trash</a>


                                  </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="btn-group pull-right visible-md visible-lg">
						@if($post->position == 0)		
						<a href="{{ URL::to('/admin/post/sticky/'.$post->id);}}" class="btn btn-default btn-xs" title="Make Post Sticky">Sticky</a>
						@else
						<a href="{{ URL::to('/admin/post/unstick/'.$post->id);}}" class="btn btn-default btn-xs" title="Unstick Post">Unstick</a>

						@endif
						<a href="{{ URL::to('/admin/post/trash/'.$post->id);}}" class="btn btn-danger btn-xs" title="Remove Post Permanently">Trash</a>

						@if($post->frontpage)
						<a href="{{ URL::to('/admin/post/demote/'.$post->id);}}" class="btn btn-warning btn-xs" title="Demote from front page">Demote</a>
						@else
						<a href="{{ URL::to('/admin/post/promote/'.$post->id);}}" class="btn btn-success btn-xs" title="Promote from front page">Promote</a>						
						@endif
						@if($post->menu)
						<a href="{{ URL::to('/admin/post/remove-menu/'.$post->id);}}" class="btn btn-default btn-xs" title="Remove from menu" data-original-title="Remove from menu">Remove from Menu</a>
						@else
						<a href="{{ URL::to('/admin/post/add-menu/'.$post->id);}}" class="btn btn-default btn-xs" title="Add to menu" data-original-title="Add to menu">Add to Menu</a>
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
</div>
@endsection