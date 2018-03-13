function compStartStop(action, mac, hostname, username, password)
{
    if (action=="Start"){
	$.ajax(
	{
		type: "POST",
		url: "/compStartStop.php",
		data: { mac: mac, button: action, room: "room", hostname: hostname },
		dataType: "json",
		async: false,
		success: function(data) {
                    alert(data);
		}
	})
    }
    else if (action=="Stop"){
        $.ajax(
	{
		type: "POST",
		url: "/compStartStop.php",
		data: { mac: mac, button: action, room: "room", hostname: hostname, username: username, password: password },
		dataType: "json",
		async: false,
		success: function(data) {
                    if (data) {
                        alert('Successfull shutdown');
                    }
                    else {
                        alert('Remote shutdown failed');
                    }
		}
	})
//       alert(username + password);
    }
    else if (action=="StartAll"){
        roomID = mac;
//        alert(roomID);
	$.ajax(
	{
		type: "POST",
		url: "/compStartStop.php",
		data: { mac: '', button: action, room: roomID, hostname: '' },
		dataType: "json",
		async: false,
		success: function(data) {
                    alert(data);
		}
	})
    }
    else if (action=="StopAll"){
        roomID = mac;
	$.ajax(
	{
		type: "POST",
		url: "/compStartStop.php",
		data: { mac: '', button: action, room: roomID, hostname: '' },
		dataType: "json",
		async: false,
		success: function(data) {
                    alert(data);
		}
	})
    }
    else {
        alert('Error');
    }
}

function refresh()
{
    //var img = document.getElementById('refreshSpin');
    //img.style.display = "";
    //var btn = document.getElementById('refresh');
    //$.btn.toggleClass('active');
    
    $.ajax(
    {
        type: "POST",
        url: "/refresh.php",
        data: { },
        dataType: "json",
        async: true,
    }).done(function(data) {
        //alert(data);
        window.location.reload(true);
    });
}

function bellStartStop(oObject)
{
	$.ajax(
	{
		type: "POST",
		url: "/bellStartStop.php",
		data: { button: oObject.innerHTML },
		dataType: "json",
		async: false,
		success: function(data) {
			var button = document.getElementById("ringStartStop");
			if (data == "1") {
				button.innerHTML="Stop";
				button.className="btn btn-lg btn-default btn-danger";
			}
			else {
				button.innerHTML="Start";
				button.className="btn btn-lg btn-default btn-success";
			}
		}
	})
}

function bellStop()
{
	$.ajax(
	{
		type: "POST",
		url: "/bellStartStop.php",
		data: { button: "Stop" },
		dataType: "json",
		async: true
	})
}

function groupAddRemove(oObject) {
if (oObject.dataset.acction=="add") {
    alert('Add user: ' + oObject.dataset.user + ' to group: ' + oObject.dataset.group);
    $.ajax(
	{
		type: "POST",
		url: "/admin/groupAddRemove.php",
		data: { action: 'add', group: oObject.dataset.group, user: oObject.dataset.user },
		dataType: "json",
		async: true,
		success: function(data) {
                    alert('success');
                    /*
                    var button = document.getElementById("ringStartStop");
			if (data == "1") {
				button.innerHTML="Stop";
				button.className="btn btn-lg btn-default btn-danger";
			}
			else {
				button.innerHTML="Start";
				button.className="btn btn-lg btn-default btn-success";
			}*/
		}
	})
}
else
    alert('Remove user: ' + oObject.dataset.user + ' from group: ' + oObject.dataset.group);
}

function compListJson()
{
 var table = $('#rooms').tableToJSON();
 alert(JSON.stringify(table));  
}

function netstartstop(oObject) {
    var room = document.getElementById(oObject.id).getAttribute('data-room');
    var stat = document.getElementById(oObject.id).getAttribute('data-stat');
    $.ajax(
    {
        type: "POST",
        url: "netstartstop.php",
        data: { room: room, stat: stat},
        dataType: "json",
        async: false,
        success: function(data) {
                var button = document.getElementById("netstartstopbt");
                if (data == "1") {
                    button.innerHTML="Stop";
                    button.className="btn btn-default btn-danger";
                    button.setAttribute("data-stat", "start");
                }
                else {
                    button.innerHTML="Start";
                    button.className="btn btn-default btn-success";
                    button.setAttribute("data-stat", "stop");
                }
            }
    })
}
