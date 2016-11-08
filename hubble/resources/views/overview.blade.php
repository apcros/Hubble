@extends('layouts.master')
@section('title', 'Hubble - Overview')

@section('content')
	@foreach ($devices as $device)        
	  <div class="col s12 m6">
	    <div class="card">
	      <div class="card-content">
	        <span class="card-title black-text">{{ $device->name }}</span>

	        <p></p>
	        <br>
	       	@if (isset($device->data))
	       	<ul class="collapsible" data-collapsible="accordion">
		        @foreach ($device->data->drives as $hdd)
		        <li>
		        	<div class="collapsible-header"><i class="fa fa-hdd-o left"></i>{{$hdd->name}}</div>
      				<div class="collapsible-body">
      				<p>
      					Name : <b>{{$hdd->label}}</b>
      					<br>
      					Format : <b>{{$hdd->format}}</b>
      					<br>
      					<b>{{$hdd->free_space}}</b> MB Free out of <b>{{$hdd->total_space}} </b>MB
      					<br>
      					<div class="progress blue lighten-3">
		      				<div class="determinate blue" style="width: {{ $hdd->percent }}%"></div>
		  				</div>
		  			</p>
      				</div>
      			</li>
		        @endforeach
		     </ul>
		     @else
		     	<div class="card-panel red">Waiting for first connection</div> 
		     @endif

		     @if ($device->timeout_since != 0)
		     	<div class="card-panel red">Error ! Timeout since {{ $device->timeout_since }} seconds !</div> 
		     @endif
	        <br>

	        <p>
	        	<b>CPU Usage (<b id="{{$device->uuid}}_cputxt">{{ isset($device->data->cpu_usage) ? $device->data->cpu_usage : '' }}%</b>)</b>
				<div class="progress blue lighten-3">
		      		<div id="{{$device->uuid}}_cpubar"class="determinate blue" style="width: {{ isset($device->data->cpu_usage) ? $device->data->cpu_usage : '' }}%"></div>
		  		</div>
	        </p>
	        <p>
	        	<b>RAM Usage (<b id="{{$device->uuid}}_ramtxt">{{ isset($device->data->ram_percent) ? $device->data->ram_percent : '' }}%</b>)</b>
	        	<i id="{{$device->uuid}}_ramfree">{{ isset($device->data->ram_free) ? $device->data->ram_free : '?' }}</i> MB free on <i id="{{$device->uuid}}_ramtotal">{{ isset($device->data->ram_total) ? $device->data->ram_total : '?' }}</i> MB
				<div class="progress blue lighten-3">
		      		<div id="{{$device->uuid}}_rammbar" class="determinate blue" style="width: {{ isset($device->data->ram_percent) ? $device->data->ram_percent : '' }}%"></div>
		  		</div>
	        </p>
	        <br>
	        <ul class="collection ">
	        		 <li class="collection-item"><i class="fa fa-barcode left"></i><b>Computer Name :</b> {{ isset($device->data->name) ? $device->data->name : '' }}</li>
	        		 <li class="collection-item"><i class="fa fa-laptop left"></i><b>OS :</b> {{ isset($device->data->os_version) ? $device->data->os_version : '' }}</li>
				     <li class="collection-item"><i class="fa fa-key left"></i><b>UID :</b> {{ $device->uuid }}</li>
				     <li class="collection-item"><i class="fa fa-clock-o left"></i><b>Last Updated :</b> {{ $device->last_updated }}</li>
				     <li class="collection-item"><i class="fa fa-bolt left"></i><b>Client version :</b> <i>{{ isset($device->data->client_version) ? $device->data->client_version : '' }} </i></li>
				   </ul>
	      </div>
	      <div class="card-action">
	        <a class="red-text btn-flat waves-red waves-effect" href="#">DELETE</a>
	      </div>
	    </div>
	  </div>
	  <script type="text/javascript">
	 	$(document).ready(function(){
	    	$('.collapsible').collapsible();
	    });

	    window.setInterval(function(){
	    	updateDevicesList();
	    },1000);

	 	function updateDevicesList() {
	 		$.get("/api/v1/devices/list", function(data){
	 			var devices = JSON.parse(data);
	 			for (var i = 0; i < devices.length; i++) {
	 				var de = devices[i];
	 				updateOrCreateDevice(de);
	 			};
	 		})
	 	}

	 	function updateOrCreateDevice(uuid) {
			$.get("/api/v1/devices/"+uuid+"/latest",function(data) {
				var dev_json = $.parseJSON(data);
	 			if($("#"+uuid).length){
	 			//Create the device
	 			} else {
	 			//Update
	 				$("#"+uuid+"_cputxt").html(dev_json.cpu_usage+"%");
	 				$("#"+uuid+"_cpubar").width(dev_json.cpu_usage+"%");

	 				var ramTot = dev_json.ram_total;
	 				var ramFre = dev_json.ram_free;
	 				var ramPerc = Math.round(((ramTot-ramFre)/ramTot)*100);

	 				$("#"+uuid+"_rammbar").width(ramPerc+"%");
	 				$("#"+uuid+"_ramtxt").html(ramPerc+"%");
	 				$("#"+uuid+"_ramtotal").html(ramTot);
	 				$("#"+uuid+"_ramfree").html(ramFre);

	 			}
	 		});
	 	}

	 	function removeDevice(uuid) {

	 	}

	  </script>
	@endforeach
@endsection