@extends('layouts.master')
@section('title', 'Devices')

@section('content')
<div class="container">
  <div class="col s12" id="devices_list">
  </div>
  <div class="col s12">
            <div class="card">
              <div class="card-content">
               	<span class="card-title black-text">Authorize a new device :</span>
               	   <form class="col s12">
  				      <div class="row">
  				        <div class="input-field col s6">
  				          <i class="fa fa-key prefix"></i>
  				          <input id="device_name" type="text" name="device_name" class="validate">
  				          <label for="device_name">Device name</label>				        	
  				        </div>
  				      </div>
  				    </form>
              </div>
              <div class="card-action">
                <a class="btn waves-light indigo white-text waves-effect" onclick="addNewDevice();" href="#">ADD</a>
              </div>
            </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		loadList();
	})

function loadList() {
	$("#devices_list").load("/ajax/devices/list");
}
function addNewDevice() {
	var device_name = $("#device_name").val();
	$.post( "/api/v1/devices/add", { name: device_name })
  	.done(function( data ) {
      if(data != "") {
        var json = JSON.parse(data);
        console.log(json);
        if(json.status == 'ok') {
          Materialize.toast(json.message, 3000, 'green');
        } else {
          Materialize.toast(json.message, 3000, 'red');
        }
      } else {
        Materialize.toast("Error : API returned an empty response", 3000, 'red');
      }
  		loadList();
  	});
}

</script>
@endsection