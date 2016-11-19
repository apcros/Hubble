@extends('layouts.master')
@section('title', 'Hubble - Overview')

@section('content')
@include('handlebarsjs.device')
@include('handlebarsjs.drive')
	<div id="servers" class="row">
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
		   		window.setInterval(function(){
				    updateDevicesList();
				},1000);
		});
	</script>
@endsection
