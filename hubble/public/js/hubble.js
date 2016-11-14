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
	$("#devicename_"+uuid).html(json.name);
	
	$("#info_"+uuid).attr("class","card-panel blue");
	$("#info_"+uuid).html("In sync");

	$("#cpu_"+uuid).html(json.cpu_usage+"%");
	$("#cpubar_"+uuid).width(json.cpu_usage+"%");
	applyProgressBarColor(json.cpu_usage,"cpubar_"+uuid);

	var ram_percent = 100 - Math.round((json.ram_free/json.ram_total)*100);
	applyProgressBarColor(ram_percent,"rambar_"+uuid);
	
	$("#ram_"+uuid).html(ram_percent+"%");
	$("#rambar_"+uuid).width(ram_percent+"%");
	$("#ramfree_"+uuid).html(json.ram_free);
	$("#ramtotal_"+uuid).html(json.ram_total);
	$("#name_"+uuid).html(json.name);
	$("#os_"+uuid).html(json.os_version);
	$("#clientversion_"+uuid).html(json.client_version);
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
}
/*{  
   "name":"MERCURY",
   "os_version":"Microsoft Windows NT 6.2.9200.0",
   "client_version":"ALPHA\/0.31\/WIN",
   "ram_total":"8110",
   "ram_free":"1366",
   "cpu_usage":"15",
   "drives":[  
      {  
         "format":"NTFS",
         "free_space":"69763",
         "total_space":"199770",
         "name":"C:\\",
         "label":"",
         "type":"Fixed"
      },
      {  
         "format":"NTFS",
         "free_space":"191313",
         "total_space":"645293",
         "name":"E:\\",
         "label":"Stockage",
         "type":"Fixed"
      },
      {  
         "format":"NTFS",
         "free_space":"342765",
         "total_space":"437314",
         "name":"Z:\\",
         "label":"files",
         "type":"Network"
      }
   ]
}*/