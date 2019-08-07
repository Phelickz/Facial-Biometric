//BIOMETRIC LOG 
function Bio_log(taskF,defaultcalID,KeyID,allScore,allclassID,UserID) {

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


//Successful Action 
//BIOMETRIC LOG 
function S_Enroll(DataURL,ClassID,KeyID,UserID,my_url,CallURL) {

    var request = $.ajax({
        url: my_url+'service/api/push/image_call_upload',
        method: "POST",
        data: {
            "DataURL": DataURL,
            "ClassID": ClassID,
            "KeyID": KeyID,
            "UserID": UserID,
            "CallURL": CallURL,
        },
    });
    request.done(function(msg) {
        if (msg == true) {
            console.log("sucessful");
        } else {
        }
    });
}

