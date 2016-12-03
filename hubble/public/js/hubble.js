function updateDevicesList() {
    $.get("/api/v1/devices/list", function(data){
         var devices = JSON.parse(data);
         for (var i = 0; i < devices.length; i++) {
             var device_uuid = devices[i].id;
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
/*
    Not even going to pretend it's my code :
    http://stackoverflow.com/questions/3177836/how-to-format-time-since-xxx-e-g-4-minutes-ago-similar-to-stack-exchange-site
*/
function timeSince(seconds) {
    var interval = Math.floor(seconds / 31536000);
    if (interval > 1) {
        return interval + " years";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes";
    }
    return Math.floor(seconds) + " seconds";
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
        $("#info_"+uuid).html(json.message);
    } else if (json.status == "warning") {
        $("#info_"+uuid).attr("class","card-panel orange");
        $("#info_"+uuid).html(json.message);
        return; // The rest is not going to be set so no point in trying
    } else if (json.status == "timeout") {
        $("#info_"+uuid).html("Last refresh was "+timeSince(json.message)+" ago !");
        $("#info_"+uuid).attr("class","card-panel red");
    } else {
        $("#info_"+uuid).attr("class","card-panel red");
        $("#info_"+uuid).html(json.message);
    }

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
           $("#"+uuid).remove();
    }
});
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
          $("#device_name").val("");

        } else {
          Materialize.toast(json.message, 3000, 'red');
        }
      } else {
        Materialize.toast("Error : API returned an empty response", 3000, 'red');
      }
          loadDeviceList();
      });
}

function loadDeviceList() {
  $.get("/api/v1/devices/list", function(data){
    var devices = JSON.parse(data);
    for (var i = 0; i < devices.length; i++) {
        var current_device = devices[i]; 
        if(!$("#"+current_device.id).length) {
            var source = $("#device-list-template").html();
            var template = Handlebars.compile(source);
            var context = {
                "uuid": current_device.id,
                "name": current_device.name,
                "key": current_device.key,
                "status": current_device.status,
                "device-icon": getIconForDevice(current_device.system)
            };
            var html = template(context);
            $("#devices_list").append(html);
            $('.collapsible').collapsible();
        }
    };
  })
}
//Handlebars.js offer no easy way to compare a variable to a string
//In order to keep the template simple it's the simplest.
function getIconForDevice(system) {
    if (system == "WIN") {
        return "fa-windows";
    } else if (system == "LINUX") {
        return "fa-linux";
    } else {
        return "fa-question-circle";
    }
}