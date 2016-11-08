@extends('layouts.master')
@section('title', 'Hubble - Config')

@section('content')
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
<script type="text/javascript">
	$(document).ready(function() {
		loadList();
	})

function loadList() {
	$("#devices_list").load("/ajax/devices/list");
}
function addNewDevice() {
	var device_name = $("#device_name").val();
	$.post( "/ajax/devices/add", { name: device_name })
  	.done(function( data ) {
  		if(data != "ERROR") {
  			Materialize.toast('Device added ! UUID : '+data, 3000, 'green');
  		} else {
  			Materialize.toast('Error : '+data, 3000, 'red');
  		}
  		loadList();
    	 
  	});

}
function delDevice(uuid) {
	$.ajax({
    url: '/ajax/devices/'+uuid+'/delete',
    type: 'DELETE',
    success: function(result) {
        Materialize.toast('Device deleted !', 3000, 'orange');
        loadList();
    }
});
}
</script>
@endsection