<script id="device-list-template" type="text/x-handlebars-template">
	<li class="collection-item avatar" id="{{uuid}}">
		<i class="fa fa-windows circle indigo darken-1"></i>
		<span class="title">{{name}}</span>
		<p>UID : {{uuid}}</p>
		<p><i>Windows client</i></p>
		<a href="#" onclick="delDevice('{{uuid}}');" class="secondary-content"><i class="mdi-navigation-close red-text waves-effect waves-light"></i></a>
	</li>
</script>