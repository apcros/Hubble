@extends('layouts.master')
@section('title', 'Hubble - Overview')

@section('content')
@include('handlebarsjs.device')
@include('handlebarsjs.drive')
	<div id="servers">
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
		   $('.collapsible').collapsible();
		   		window.setInterval(function(){
				    updateDevicesList();
				},1000);
		});
	</script>
@endsection
