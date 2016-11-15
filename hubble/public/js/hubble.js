function updateDevicesList() {
	$.get("/api/v1/devices/list", function(data){
	 	var devices = JSON.parse(data);
	 	for (var i = 0; i < devices.length; i++) {
	 		var device_uuid = devices[i];
	 		updateOrCreateDevice(device_uuid);
	 	};
	})
}

function updateOrCreateDevice(device_uuid) {
	$.get("/api/v1/devices/"+device_uuid+"/latest",function(data) {
		if(!$("#devicename_"+device_uuid).length) {
			var source = $("#device-template").html();
			var template = Handlebars.compile(source);
			var context = {"uuid": device_uuid};
			var html = template(context);
			$("#servers").append(html);
		} else {
			updateDevice(device_uuid,data);
		}

		
	});
}

function updateDevice(uuid, data) {
	if(data == "") {
		$("#info_"+uuid).attr("class", 'card-panel orange');
		$("#info_"+uuid).html("Waiting for first connection...");
		return;
	};
	var json = $.parseJSON(data);
	$("#devicename_"+uuid).html(json.hubble_name);

	if(json.status == "ok") {
		$("#info_"+uuid).attr("class","card-panel blue");
	} else if (json.status == "warning") {
		$("#info_"+uuid).attr("class","card-panel orange");
		$("#info_"+uuid).html(json.message);
		return; // The rest is not going to be set so no point in trying
	} else {
		$("#info_"+uuid).attr("class","card-panel red");
	}

	$("#info_"+uuid).html(json.message);
	$("#cpu_"+uuid).html(json.cpu_usage+"%");
	applyProgressBarColor(json.cpu_usage,"cpubar_"+uuid);

	var ram_percent = 100 - Math.round((json.ram_free/json.ram_total)*100);
	applyProgressBarColor(ram_percent,"rambar_"+uuid);
	
	$("#ram_"+uuid).html(ram_percent+"%");
	$("#ramfree_"+uuid).html(json.ram_free);
	$("#ramtotal_"+uuid).html(json.ram_total);
	$("#name_"+uuid).html(json.name);
	$("#os_"+uuid).html(json.os_version);
	$("#clientversion_"+uuid).html(json.client_version);
	$("#lastupdated_"+uuid).html(json.last_updated);

	for (var i = 0; i < json.drives.length; i++) {
		console.log(json.drives[i]);
		updateOrCreateDrive(uuid,i,json.drives[i]);
	};
}
function updateOrCreateDrive(uuid,id,data) {
	if(!$("#hdd_"+uuid+"_"+id).length) {
			var source = $("#drive-template").html();
			var template = Handlebars.compile(source);
			var context = {"uuid": uuid, "hddid": id};
			var html = template(context);
			$("#drives_"+uuid).append(html);
	} else {
			updateDrive(uuid+"_"+id,data);
	}
}
function updateDrive(id, data) {
	$("#hdd_"+id).html(data.name);
	$("#hddname_"+id).html(data.label);
	$("#hddformat_"+id).html(data.format);
	$("#freespace_"+id).html(data.free_space);
	$("#totalspace_"+id).html(data.total_space);

	var percent = 100- Math.round((data.free_space/data.total_space)*100);
	applyProgressBarColor(percent,"hddbar_"+id);

}
function applyProgressBarColor(value, barid) {
	if(value <= 25) {
		$("#"+barid).attr("class","determinate blue");
	}
	if(value > 25 && value < 80) {
		$("#"+barid).attr("class","determinate orange");
	}
	if(value >= 80) {
		$("#"+barid).attr("class","determinate red");
	}
	$("#"+barid).width(value+"%");
}

function delDevice(uuid) {
	$.ajax({
    url: '/api/v1/devices/'+uuid+'/delete',
    type: 'DELETE',
    success: function(result) {
        Materialize.toast('Device deleted !', 3000, 'orange');
        loadList();
    }
});
}