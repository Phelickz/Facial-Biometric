$(document).ready(function(){
$('#dvLoading').hide();	
});
var dataURL=localStorage.getItem("dataURLD");

var EdataURL =sessionStorage.getItem("EdataURLD");
var dataURL1 = localStorage.getItem("dataURL1");
var dataURL2 = localStorage.getItem("dataURL2");
var dataURL3 = localStorage.getItem("dataURL3");
var dataURL4 = localStorage.getItem("dataURL4");
$('#imgg').attr('src', EdataURL);

////IMAGE CHECK



function getImageBrightness(imageSrc, callback) {
	
  var img = document.createElement('img'),
    colorSum = 0,
    i = 0,
    len,
    canvas,
    ctx,
    imageData,
    data,
    brightness,
    r,
    g,
    b,
	result,
	msgv,
	msgp,
    avg;
  img.src = imageSrc;
  img.style.display = 'none';

  document.body.appendChild(img);

  img.onload = function () {
    canvas = document.createElement('canvas');
    canvas.width = this.width;
    canvas.height = this.height;

    ctx = canvas.getContext('2d');
    ctx.drawImage(this, 0, 0);

    imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    data = imageData.data;
	var r,g,b, max_rgb;
    var light = 0, dark = 0;

    for (i, len = data.length; i < len; i += 4) {
      r = data[i];
      g = data[i + 1];
      b = data[i + 2];
	  //Gray
     var avgG = Math.floor((r + g + b) / 3);
	  avg = Math.floor((0.2126 * r) + (0.7152 * g) + (0.0722 * b))
      colorSum += avg;
	  max_rgb = Math.max(Math.max(r, g), b);
	  
				
                if (max_rgb < 128)
                    dark++;
                else
                    light++;
    }
	

	var cal_light=light/100;
   var cal_dark=dark/100;
   var cal_dif=cal_light-cal_dark;
  var dl_diff = ((light - dark) / (this.width*this.height));
 brightness = Math.floor(colorSum / (this.width * this.height));
    callback(brightness);

	var tbl = $("<table/>").attr("id", "mytable");
    var tabl = "<table ><thead><tr><th width='100%'><div class='alert alert-danger'><strong>Your Biometric Capture Failed Because Of The Reasons Below</strong></div> </th></tr></thead></table >";
	$("#div1").append(tabl);
    $("#div1").append(tbl);
	
	
	
	   if((cal_light < 250) || cal_dark > 430 ){
	   result = 1;
		 msgv = "FaceContrastTooLow";
	   msgp = "The face area within the image has too little background interaction. ensure the background is evenly distributed";
              // break;
	  }else
	     if(cal_light <= 20){
	     result = 1;
		 msgv = "ImageTooDark";
		 msgp = "Your image is too dark.";
               
	  }else 
	   if(cal_light == 0){
         result = 1;
		 msgv = "FaceTooDark";
		 msgp = "Your face area within the image is too dark, Make sure there is enough lighting";
              // break;
	  }else 
	  if(cal_dark > 470){
        result = 1;
		msgv = "ImageUnderExposure";
		msgp = "The image is underexposed,  it has too many very dark background.";
               // break;
	  }else 
	    if(cal_dif > 200 ){
		 result = 1;
	   msgv = "FaceContrastTooLow";
	   msgp = "The face area within the image has too little background interaction. ensure the background is evenly distributed";
         
              // break;
	  }
	  else
	  if(brightness < 95) {
		 result = 1;
	 msgv = "BadFaceBrightness";
	 msgp = "Your face area within the image is too dark, Make sure there is enough lighting";
	  
         
              // break;
	  }else

	  {
            var result = 0;
			console.log("c",result)
            }
			
	
	var tr = "<tr>";
    var td1 = "<td width='20%' style='color:#A00'>" + msgv + "</td>";
    var td2 = "<td  width='100%'>" + msgp+ "</td>";
     $("#mytable").append(tr + td2);
		    console.log('dl_diff=',dl_diff)
			console.log('light=',light/100)
			console.log('dark=',dark/100)
			console.log('TOTAL=',cal_light-cal_dark)
			console.log('Para:=',msgv)
			console.log('MESSAGE:=',msgp)
			console.log('result:=',result)
			console.log('AVGG:=',avgG )
			console.log('AVG:=',avg )
	////////////////Controlll////////////
			
////IMAGE CHECK
//console.log(dataURL);
//var token = localStorage.getItem("TOKEN_IDD");
console.log(localStorage.getItem("TOKEN_IDD"));
//var result=1;
//console.log(result);
//pass all trail
if(result==0 &&  result==1){
$('#dvLoading').fadeOut(2000);
$('#div3').fadeIn(2000);
$('#div2').fadeIn(2000);
$('#div1').fadeIn(2000);
console.log('fail');
}else if(result==0) {
console.log('redirect');
alert("IMAGE Quality Ok")
identifyUrl()

$('#dvLoading').fadeOut(2000);
$('#div3').fadeIn(2000);
$('#div2').fadeIn(2000);
$('#div1').fadeIn(2000);
//identifyUrl()

}else if(result==1) {
$('#dvLoading').fadeOut(2000);
$('#div3').fadeIn(2000);
$('#div2').fadeIn(2000);
$('#div1').fadeIn(2000);
console.log('error');

}	// true

			
////////////////////////////////////
  };
}


function identify(token){
var form = new FormData();
form.append("livedetection", "false");
var settings = {
  "async": true,
  "crossDomain": true,
  "dataType": "json",
  "url": "https://bws.bioid.com/extension/identify",
  "method": "GET",
  "headers": {
    "Authorization": "Bearer "+token,
    "Cache-Control": "no-cache",
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form											 
}
$.ajax(settings).done(function (response) {
	console.log(response);
    //kevin;
	if (response.Success) {
        console.log('enrollment succeeded');
    
					var arrClass = [];//array
					var arrScore = [];//array
           		    //looping ALL
					var ScoreClass1 = response.Matches[0].Score;
					var DataMatch1 = response.Matches[0].ClassID;
				 for (var i in response.Matches) {
					var ScoreClass = response.Matches[i].Score;
					var DataMatch = response.Matches[i].ClassID;
					 arrClass.push(response.Matches[i].ClassID)
					 arrScore.push(response.Matches[i].Score)
					console.log(arrClass);
					console.log(arrScore);
					
					} 
					//alert(ScoreClass1)
					//alert(response.Matches[i].Score)
				   //looping signle matach data
					localStorage.setItem("ScoreMatchV", ScoreClass1);
					localStorage.setItem("ClassIDMatchV", DataMatch1);
					//looping all matach data
					localStorage.setItem("ClassScoreV", JSON.stringify(arrScore));
					localStorage.setItem("ClassMatchV", JSON.stringify(arrClass));
					var taskF ='identify';
                     console.log(response);
					    //bio_log(taskF);
					 if(ScoreClass1 >= 0.20000){
					alert("Your Biometric Data aready exist!!");
					var CallBackURL =localStorage.getItem("CallBackURL");
					
						$('#dvLoading').fadeOut(2000);
							alert(DataMatch1)
						 $('#url').val(CallBackURL); // Pass Url
					     $('#classD').val(DataMatch1);
							document.Bio_data.submit();
				  
					 //document.getElementById("Bio_data").submit()
					
					 }else{
					//alert('start enrollment');
					 nouploaddata();
					 }
					} else {
		alert(' LIVE DETECTION FAILED  : ENSURE YOUR FACE IS WITHIN THE CIRCLE AND SLIGHTLY MOVE YOUR HEAD UP AND DOWN DURING CAPTURE.', response.Error);
		$('#dvLoading').fadeOut(2000);
			window.location.href = URLID+"service/api/push/BiometricAppID";
			$('#dvLoading').fadeOut(2000);
			
             
        
    }
   
});
	
} 

function Upload(dataURL,Etoken){

var traitF= "Face,periocular";
var form = new FormData();

form.append("", dataURL);

var settings = {
  "async": true,
  "crossDomain": true,
  "dataType": "json",
  "url": "https://bws.bioid.com/extension/upload?"+"trait="+traitF,
  "method": "POST",
  "headers": {
    "Authorization": "Bearer "+Etoken,
    "Cache-Control": "no-cache",
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}
$.ajax(settings).done(function (response) {
	console.log(response);
    if (response.Accepted) {
    console.log("upload succeeded", response.Warnings);
		console.log("upload succeeded", response.Warnings);
		
	//window.location.href = "Home.php";
	
  } else {
    console.log("upload error", response.Error);
  }
});

}

	function UploadAll(dataURL){
var Etoken =localStorage.getItem("Enroll_TOKEN_IDD");
var traitF= "Face,periocular";
var form = new FormData();

form.append("", dataURL);

var settings = {
  "async": true,
  "crossDomain": true,
  "dataType": "json",
  "url": "https://bws.bioid.com/extension/upload?"+"trait="+traitF,
  "method": "POST",
  "headers": {
    "Authorization": "Bearer "+Etoken,
    "Cache-Control": "no-cache",
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}
$.ajax(settings).done(function (response) {
	console.log(response);
    if (response.Accepted) {
    console.log("upload succeeded", response.Warnings);
		var taskF ='1';
	     bio_log(taskF);
		 enroll();
	//window.location.href = "Home.php";
	
  } else {
    console.log("upload error", response.Error);
  }
});

}

function UploadAllID(dataURL){
var Etoken=localStorage.getItem("TOKEN_IDD");
var traitF= "Face,periocular";
var form = new FormData();

form.append("", dataURL);

var settings = {
  "async": true,
  "crossDomain": true,
  "dataType": "json",
  "url": "https://bws.bioid.com/extension/upload?"+"trait="+traitF,
  "method": "POST",
  "headers": {
    "Authorization": "Bearer "+Etoken,
    "Cache-Control": "no-cache",
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}
$.ajax(settings).done(function (response) {
	console.log(response);
    if (response.Accepted) {
    console.log("upload succeeded", response.Warnings);
//pass all trail
identify(Etoken)
	//window.location.href = "Home.php";
	
  } else {
    console.log("upload error", response.Error);
  }
});

}


function enroll(){
var Etoken =localStorage.getItem("Enroll_TOKEN_IDD");
var CLassIDV=localStorage.getItem("classIDApi");
var dataURL=localStorage.getItem("dataURL2");
//alert(Etoken)
var proxy = 'https://cors-anywhere.herokuapp.com/';
	var form = new FormData();
	form.append("livedetection", "false");
var settings = {
  "async": true,
  "crossDomain": true,
  "dataType": "json",
  "url": "https://bws.bioid.com/extension/enroll",
  "method": "GET",
  "headers": {
    "Authorization": "Bearer "+Etoken,
    "Cache-Control": "no-cache",

  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}
$.ajax(settings).done(function (response) {
	console.log(response);
    if (response.Success) {
        alert('enrollment succeeded');
		$('#dvLoading').fadeOut(2000);
		var eImg=sessionStorage.getItem("EdataURLD");
		var CLassIDV=localStorage.getItem("classIDApi");
		var CallBackURL =localStorage.getItem("CallBackURL");
		var KeyID =localStorage.getItem("KeyID");
		$('#url').val(CallBackURL); // Pass Url
        $('#DataURL').val(eImg); // Pass Img Parameter
		 $('#KeyID').val(KeyID); // Pass Key Parameter
        $('#ClassID').val(CLassIDV); // Pass Class Parameter
		        document.Bio_data_enrol.submit();
    } else {
        alert('enrollment failed', response.Error);
		$('#dvLoading').fadeOut(2000);
    }
});

}

//NT
function bio_logOLD(taskF){
	
	             var defaultcalID=localStorage.getItem("CLASS_IDD");
				  var allScore=localStorage.getItem("ClassScoreV");
				  var allclassID=localStorage.getItem("ClassMatchV");
				  //var taskF=localStorage.GetItem("task");
				     $('#defaultID').val(defaultcalID);
				     $('#Allscore').val(allScore);
					 $('#Allclass_id').val(allclassID);
					 $('#taskFD').val(taskF);
					 document.Bio_log_control.submit();
	
}


//lOGG 
function bio_log(taskF) {
	var defaultcalID=localStorage.getItem("CLASS_IDD");
	var allScore=localStorage.getItem("ClassScoreV");
	var allclassID=localStorage.getItem("ClassMatchV");
    var request = $.ajax({
        url: 'bio_log_controll',
        method: "POST",
        data: {
            "defaultID": defaultcalID,
			 "Allscore": allScore,
			  "Allclass_id": allclassID,
			   "taskFD": taskF,
        },
    });
   request.done(function(msg) {
		if(msg==true){
		console.log("sucessful");
		}else{

	
		}
    });
}


function nouploaddata(){
	      var dataURL1 = localStorage.getItem("dataURL1");
	      var dataURL2 = localStorage.getItem("dataURL2");
		  var dataURL3 = localStorage.getItem("dataURL3");
		  var dataURL4 = localStorage.getItem("dataURL4");
		  var Etoken =localStorage.getItem("Enroll_TOKEN_IDD");
		  var urldata = [dataURL1 , dataURL2];
	      counter = 0;
     while (counter < 1) {
    var demoC = urldata[counter] ;
	 Upload(demoC ,Etoken);
    counter++;
	if(counter == 1) break;
	}	
	UploadAll(dataURL2);	  
		  
	 }
	 
	 function identifyUrl(){
	
	      var dataURL1 = localStorage.getItem("dataURL1");
	      var dataURL2 = localStorage.getItem("dataURL2");
		  var dataURL3 = localStorage.getItem("dataURL3");
		  var dataURL4 = localStorage.getItem("dataURL4");
		  var Etoken=localStorage.getItem("TOKEN_IDD");
		  var urldata = [dataURL1,dataURL2];
    counter = 0;
     while (counter < 1) {
    var demoC = urldata[counter] ;
	 Upload(demoC ,Etoken);
    counter++;
	if(counter == 1) break;
	
    }	
	UploadAllID(dataURL2);
	  
	 }
	 
function start_bio(){
window.location.href = "BiometricID";
}
	
	function start_bio2(){
window.location.href = "BiometricID";
}

function goBack() {
    window.history.back()
}



