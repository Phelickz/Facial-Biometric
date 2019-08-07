
var CLASS_ID =Math.floor((Math.random() * 600666666) + 1);
 var token
$("#buttonStart").hide();
var settings_token = {
  "async": true,
  "crossDomain": true,
  "url": "https://aws.appmartgroup.com/app/api/v1.0/api/token?partition=19920&callID="+CLASS_ID+"&task=face",
  "method": "GET",
  "headers": {
    "Authorization": "Basic QXBwbWFydEJpbzoxMjM0NTY=",
  }
}

$.ajax(settings_token).done(function (response) {
  token=response;
  $("#buttonStart").show();

});
console.log("token",token)
