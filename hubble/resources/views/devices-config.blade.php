@extends('layouts.master')
@section('title', 'Devices')

@section('content')
@include('handlebarsjs.device-listed')
<div class="container">
  <div class="col s12">
            <div class="card">
              <div class="card-content">
                <span class="card-title black-text">Add a new device :</span>
                   <form class="col s12">
                <div class="row">
                  <div class="input-field col s12">
                    <i class="fa fa-key prefix"></i>
                    <input id="device_name" type="text" name="device_name" class="validate">
                    <label for="device_name">Device name</label>
                  </div>
                </div>
              </form>
              </div>
              <div class="card-action">
                <a class="btn waves-light indigo white-text waves-effect" onclick="addNewDevice();" href="#"><i class="fa fa-plus-square left" aria-hidden="true"></i>ADD</a>
              </div>
            </div>
  </div>
  <div class="col s12">
    <h5>Registered devices :</h5>
    <ul class="collection" id="devices_list">
    </ul>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		loadDeviceList();
	});
</script>
@endsection