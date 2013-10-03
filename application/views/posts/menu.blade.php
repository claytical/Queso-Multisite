<ul class="dropdown-menu">
@foreach($items as $item)
	<li class="dropdown"><a href="{{ URL::to('post/'.$item->id);}}">{{ $item->headline }}</a></li>
@endforeach
</ul>