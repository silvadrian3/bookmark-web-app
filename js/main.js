$(document).ready(function(){
	var d = new Date();
	var y = "&copy; " + d.getFullYear() + " Bookmark by Quisi.io. All Rights Reserved.";	
	$('.c-footer-details').html(y);
});

//full date yyyymdHis
function getFulldate() {
	var _newdate = new Date();
	var _year = _newdate.getFullYear().toString().substring(2);
	var _month = _newdate.getMonth() + 1;
	_month = _month.toString();
	var _date = _newdate.getDate().toString();
	var _hour = _newdate.getHours().toString();
	var _minute = _newdate.getMinutes().toString();
	var _second = _newdate.getSeconds().toString();

	var fulldate = _year + _month + _date + _hour + _minute + _second;

	return fulldate;
}

//get QueryString Parameters 
function GetQueryStringParams(e) {
    var t = window.location.search.substring(1);
    var n = t.split("&");
    for (var r = 0; r < n.length; r++) {
        var i = n[r].split("=");
        if (i[0] == e) {
            return i[1]
        }
    }
}

//custom alert message
function loadCustomAlert(msg, direction, color){
	$("#custom-message").text(msg);	
	$("#custom-message").css("color", color);
	setTimeout(function(){
		document.getElementById("custom-alert").style.display="block";
		document.getElementById("container").style.display="none";
		setTimeout(function() {
			window.location = direction;
		},2500);
	},500);
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}