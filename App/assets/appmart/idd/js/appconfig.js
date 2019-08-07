$(document).ready(function() {
    $('#dvLoading').hide();
});
var dataURL = localStorage.getItem("dataURLD");
var EdataURL = sessionStorage.getItem("EdataURLD");
var dataURL1 = localStorage.getItem("dataURL1");
var dataURL2 = localStorage.getItem("dataURL2");
var dataURL3 = localStorage.getItem("dataURL3");
var dataURL4 = localStorage.getItem("dataURL4");
$('#imgg').attr('src', EdataURL);
////IMAGE CHECK
function identify(token) {
    var form = new FormData();
    form.append("livedetection", "false");
    var settings = {
        "async": true,
        "crossDomain": true,
        "dataType": "json",
        "url": "https://bws.bioid.com/extension/identify",
        "method": "GET",
        "headers": {
            "Authorization": "Bearer " + token,
            "Cache-Control": "no-cache",
        },
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
    }
    $.ajax(settings).done(function(response) {
        console.log(response);
        //kevin;
        if (response.Success) {
            console.log('enrollment succeeded');
            var arrClass = []; //array
            var arrScore = []; //array
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
            var taskF = 'identify';
            console.log(response);
             bio_log(taskF);
            if (ScoreClass1 >= 0.20000) {
                alert("Your Biometric Data aready exist!!");
                var CallBackURL = localStorage.getItem("CallBackURL");
                $('#dvLoading').fadeOut(2000);
                
                //$('#url').val(CallBackURL); // Pass Url
                $('#classD').val(DataMatch1);
                document.Bio_data.submit();
                //document.getElementById("Bio_data").submit()
            } else {
                //alert('start enrollment');
                nouploaddata();
            }
        } else {
            alert(' LIVE DETECTION FAILED  : ENSURE YOUR FACE IS WITHIN THE CIRCLE AND SLIGHTLY MOVE YOUR HEAD UP AND DOWN DURING CAPTURE.', response.Error);
            $(".main").hide();
            $('#dvLoading').fadeOut(2000);
            $('#div3').fadeIn(2000);
            $('#div2').fadeIn(2000);
            $('#div1').fadeIn(2000);
        }
    });
}
function Upload(dataURL, Etoken) {
    var traitF = "Face,periocular";
    var form = new FormData();
    form.append("", dataURL);
    var settings = {
        "async": true,
        "crossDomain": true,
        "dataType": "json",
        "url": "https://bws.bioid.com/extension/upload?" + "trait=" + traitF,
        "method": "POST",
        "headers": {
            "Authorization": "Bearer " + Etoken,
            "Cache-Control": "no-cache",
        },
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
    }
    $.ajax(settings).done(function(response) {
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
function UploadAll(dataURL) {
    var Etoken = localStorage.getItem("Enroll_TOKEN_IDD");
    var traitF = "Face,periocular";
    var form = new FormData();
    form.append("", dataURL);
    var settings = {
        "async": true,
        "crossDomain": true,
        "dataType": "json",
        "url": "https://bws.bioid.com/extension/upload?" + "trait=" + traitF,
        "method": "POST",
        "headers": {
            "Authorization": "Bearer " + Etoken,
            "Cache-Control": "no-cache",
        },
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
    }
    $.ajax(settings).done(function(response) {
        console.log(response);
        if (response.Accepted) {
            console.log("upload succeeded", response.Warnings);
            var taskF = '1';
            bio_log(taskF);
            enroll();
            //window.location.href = "Home.php";
        } else {
            console.log("upload error", response.Error);
        }
    });
}
function UploadAllID(dataURL) {
    var Etoken = localStorage.getItem("TOKEN_IDD");
    var traitF = "Face,periocular";
    var form = new FormData();
    form.append("", dataURL);
    var settings = {
        "async": true,
        "crossDomain": true,
        "dataType": "json",
        "url": "https://bws.bioid.com/extension/upload?" + "trait=" + traitF,
        "method": "POST",
        "headers": {
            "Authorization": "Bearer " + Etoken,
            "Cache-Control": "no-cache",
        },
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
    }
    $.ajax(settings).done(function(response) {
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
function enroll() {
    var Etoken = localStorage.getItem("Enroll_TOKEN_IDD");
    var CLassIDV = localStorage.getItem("classIDApi");
    var dataURL = localStorage.getItem("dataURL2");
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
            "Authorization": "Bearer " + Etoken,
            "Cache-Control": "no-cache",
        },
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
    }
    $.ajax(settings).done(function(response) {
        console.log(response);
        if (response.Success) {
            alert('enrollment succeeded');
            $('#dvLoading').fadeOut(2000);
            var eImg = sessionStorage.getItem("EdataURLD");
            var CLassIDV = localStorage.getItem("classIDApi");
            var CallBackURL = localStorage.getItem("CallBackURL");
            var KeyID = localStorage.getItem("KeyID");
            //$('#url').val(CallBackURL); // Pass Url
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


//lOGG 
function bio_log(taskF) {
    var defaultcalID = localStorage.getItem("classIDApi");
    var allScore = localStorage.getItem("ClassScoreV");
    var allclassID = localStorage.getItem("ClassMatchV");
	var KeyID = localStorage.getItem("KeyID");
	var UserID = localStorage.getItem("UserID");
	
    var request = $.ajax({
        url: my_url+'service/api/push/bio_log_controll',
        method: "POST",
        data: {
            "defaultID": defaultcalID,
            "Allscore": allScore,
            "Allclass_id": allclassID,
            "taskFD": taskF,
			"KeyID": KeyID,
			"UserID": UserID,
        },
    });
    request.done(function(msg) {
        if (msg == true) {
            console.log("sucessful");
        } else {
        }
    });
}
function nouploaddata() {
    var dataURL1 = localStorage.getItem("dataURL1");
    var dataURL2 = localStorage.getItem("dataURL2");
    var dataURL3 = localStorage.getItem("dataURL3");
    var dataURL4 = localStorage.getItem("dataURL4");
    var Etoken = localStorage.getItem("Enroll_TOKEN_IDD");
    var urldata = [dataURL1, dataURL2];
    counter = 0;
    while (counter < 1) {
        var demoC = urldata[counter];
        Upload(demoC, Etoken);
        counter++;
        if (counter == 1) break;
    }
    UploadAll(dataURL2);
}
function identifyUrl() {
    var dataURL1 = localStorage.getItem("dataURL1");
    var dataURL2 = localStorage.getItem("dataURL2");
    var dataURL3 = localStorage.getItem("dataURL3");
    var dataURL4 = localStorage.getItem("dataURL4");
    var Etoken = localStorage.getItem("TOKEN_IDD");
    var urldata = [dataURL1, dataURL2];
    counter = 0;
    while (counter < 1) {
        var demoC = urldata[counter];
        Upload(demoC, Etoken);
        counter++;
        if (counter == 1) break;
    }
    UploadAllID(dataURL2);
}
function start_bio() {
    window.location.href = "BiometricID";
}
function start_bio2() {
    window.location.href = "BiometricID";
}
function goBack() {
    location.reload();
}