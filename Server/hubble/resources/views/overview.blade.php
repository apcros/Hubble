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
		        @foreach ($device->data->drives as $hdd)
		        <p>
		        	<b>{{$hdd->name}} - {{$hdd->label}}</b>
		        	{{$hdd->free_space}} Mb Free out of {{$hdd->total_space}}
		        	<i>{{$hdd->format}}</i>
		        </p>
		        @endforeach
		     @else
		     	<div class="card-panel red">Waiting for first connection</div> 
		     @endif
	        <br>
	        <p>
	        	<b>CPU Usage ({{ isset($device->data->cpu_usage) ? $device->data->cpu_usage : '' }}%)</b>
				<div class="progress green lighten-3">
		      		<div class="determinate green" style="width: {{ isset($device->data->cpu_usage) ? $device->data->cpu_usage : '' }}%"></div>
		  		</div>
	        </p>
	        <br>
	        <ul class="collection ">
	        		 <li class="collection-item"><i class="fa fa-barcode left"></i><b>Computer Name :</b> {{ isset($device->data->name) ? $device->data->name : '' }}</li>
	        		 <li class="collection-item"><i class="fa fa-tv left"></i><b>OS :</b> {{ isset($device->data->os_version) ? $device->data->os_version : '' }}</li>
				     <li class="collection-item"><i class="fa fa-key left"></i><b>UID :</b> {{ $device->uuid }}</li>
				     <li class="collection-item"><i class="fa fa-bolt left"></i><b>Client version :</b> <i>{{ isset($device->data->client_version) ? $device->data->client_version : '' }} </i></li>
				   </ul>
	      </div>
	      <div class="card-action">
	        <a class="red-text btn-flat waves-red waves-effect" href="#">DELETE</a>
	      </div>
	    </div>
	  </div>
	@endforeach
@endsection