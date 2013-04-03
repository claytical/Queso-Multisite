<ul class="dropdown-menu">
@foreach($items as $item)
	<li><a href="{{ URL::to('post/'.$item->id);}}">{{ $item->headline }}</a></li>
@endforeach
</ul>