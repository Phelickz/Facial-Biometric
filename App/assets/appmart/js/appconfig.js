$(document).ready(function(){
	$('#page_effect').fadeIn(2000);
});
var dataURL=localStorage.getItem("dataURLD");



var dataURL1 = localStorage.getItem("dataURL1");
var dataURL2 = localStorage.getItem("dataURL2");
var dataURL3 = localStorage.getItem("dataURL3");
var dataURL4 = localStorage.getItem("dataURL4");
$('#imgg').attr('src', dataURL2);
//console.log(dataURL);
var token = localStorage.getItem("TOKEN_IDD");
console.log(localStorage.getItem("TOKEN_IDD"));
var form = new FormData();
form.append("DATAURL", dataURL2);
//form.append("token", token);

var settings = {
  "async": true,
 "url": "qualityCheck",
  "method": "POST",
  "processData": false,
  "contentType": false,
  "dataType": "json",
  "mimeType": "multipart/form-data",
  "data": form
}

$.ajax(settings).done(function(response) {
    console.log(response);
    var tbl = $("<table/>").attr("id", "mytable");
    var tabl = "<table ><thead><tr><th width=''><div class='alert alert-danger'><strong>Your Biometric Capture Failed Because Of The Reasons Below</strong></div> </th></tr></thead></table >";
    $("#div1").append(tabl);
    $("#div1").append(tbl);
    var arrClass = []; //array
    for (var i in response.Errors) {
        var code_res = response.Errors[i].Code;
        arrClass.push(response.Errors[i].Code)
        var resm = response.Errors[i].Message;

         for (var i = 0; i < arrClass.length; i++) {
            if (arrClass[i] === 'NoFaceFound') {
                var result = 1;
				var msgv = "NoFaceFound";
				var msgp = "No face was found in the face biomentic or your image is not clear enough for biometric capture.";
                break;
            }
            if (arrClass[i] === 'NoFaceFound3') {
                var result = 1;
				var msgv = "NoFaceFound3";
				var msgp = "NoFaceFound3";
                break;
            }
            if (arrClass[i] === 'FaceTooDark') {
                var result = 1;
				var msgv = "FaceTooDark";
				var msgp = "Your face area within the image is too dark, Make sure there is enough lighting";
                break;
            }
           
            if (arrClass[i] === 'ImageTooDark') {
                var result = 1;
				var msgv = "ImageTooDark";
				var msgp = "Your image is too dark.";
                break;
            }
            if (arrClass[i] === 'BadImageBrightness') {
                var result = 1;
				var msgv = "BadImageBrightness";
				var msgp = "The image has an improper brightness condition. Make sure there is a good lighting condition ";
                break;
            }
            if (arrClass[i] === 'BadFaceBrightness') {
                var result = 1;
				var msgv = "BadFaceBrightness";
				var msgp = "The face area within the image has an improper brightness condition. Make sure there is a good lighting condition ";
                break;
            }
            if (arrClass[i] === 'FaceContrastTooLow') {
                var result = 1;
				var msgv = "FaceContrastTooLow";
				var msgp = "The face area within the image has too little background interaction. ensure the background is evenly distributed";
                break;
            }
            if (arrClass[i] === 'IrisNotFound') {
                var result = 1;
				var msgv = "IrisNotFound";
				var msgp = "A face was found, however, at least one eye could not be seen.";
                break;
            }
		
		if (arrClass[i] === 'WrongViewingDirection') {
                var result = 1;
				var msgv = "WrongViewingDirection";
				var msgp = "Look straight ahead into the camera.";
                break;
            }
			 if (arrClass[i] === 'BadGrayscaleDensity') {
                var result = 1;
				var msgv = "BadGrayscaleDensity";
				var msgp = "The color intensity of the face area within the image does not have enough color distributed.";
                break;
            }
			if (arrClass[i] === 'ImageTooBlurry') {
                var result = 1;
				var msgv = "ImageTooBlurry";
				var msgp = "The image is too blurry, i.e. is it not sharp enough.";
                break;
            }
			if (arrClass[i] === 'MultipleFacesFound') {
                var result = 1;
				var msgv = "MultipleFacesFound";
				var msgp = "Multiple faces were found in the face sample..";
                break;
            }
			if (arrClass[i] === 'FaceAsymmetry') {
                var result = 1;
				var msgv = "FaceAsymmetry";
				var msgp = "It seems that the face of the found person is somehow asymmetric I.E Face having two sides or halves that are not the same";
                break;
            }
			
			 if (arrClass[i] === 'ImageUnderExposure') {
                var result = 1;
				var msgv = "ImageUnderExposure";
				var msgp = "The image is underexposed,  it has too many very dark background.";
                break;
            } else {
                var result = 0;
            }
        }
		//

	}
	var tr = "<tr>";
    var td1 = "<td width='20%' style='color:#A00'>" + msgv + "</td>";
    var td2 = "<td  width='100%'>" + msgp+ "</td>";
     $("#mytable").append(tr + td2);
console.log(result);
//pass all trail

if(result==0 &&  result==1){
$('#dvLoading').fadeOut(2000);
$('#div3').fadeIn(2000);
$('#div2').fadeIn(2000);
$('#div1').fadeIn(2000);
console.log('fail');
}else if(result==0) {
console.log('redirect');
identifyUrl()

}else if(result==1) {
$('#dvLoading').fadeOut(2000);
$('#div3').fadeIn(2000);
$('#div2').fadeIn(2000);
$('#div1').fadeIn(2000);
console.log('error');

}	// true

});


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
					    bio_log(taskF);
					 if(ScoreClass1 >= 0.20000){
					alert("Your Biometric Data aready exist!!");
						$('#dvLoading').fadeOut(2000);
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
			window.location.href = "BiometricID";
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
var traitF=  "Face,periocular";
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
var CLassIDV=localStorage.getItem("ECLASS_IDD");
var dataURL=sessionStorage.getItem("EdataURLD");
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
		$('#img').val(dataURL); // Pass Img Parameter
        $('#class_id').val(CLassIDV); // Pass Class Parameter
        $('#token_id').val(Etoken); // Pass Token Parameter
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
	       UploadAllID(dataURL2);
	  
	 }
function start_bio(){
window.location.href = "BiometricID";
}
	
	function start_bio2(){
window.location.href = "BiometricID";
}




