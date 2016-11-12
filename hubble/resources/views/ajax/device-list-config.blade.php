<ul class="collection" id="srvList">
	@foreach ($devices as $device)
	    <li class="collection-item avatar">
			<i class="fa fa-windows circle indigo darken-1"></i>
			<span class="title">{{$device->name}}</span>
			<p>UID : {{$device->id}}</p>
			<p><i>Windows client</i></p>
			<a href="#" onclick="delDevice('{{$device->id}}');" class="secondary-content"><i class="mdi-navigation-close red-text waves-effect waves-light"></i></a>
		</li>
	@endforeach
</ul>