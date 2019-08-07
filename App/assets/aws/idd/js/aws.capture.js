  //mutiple camera select 
  var videoSelect = document.querySelector('select#videoSource');

  const video = document.createElement('video');
  const canvas = document.querySelector('canvas');
  const copycanvas = document.createElement('canvas')
  copycanvas.width = 360
  copycanvas.height = 480
  const motioncanvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');
  const image = document.querySelector('img');
  var doneCallback, Uploadstarter, FrameintervalID, noActivityTimer, token, starter = 0,
      Dataurl, arrClass = [], arrScore = [],errorUrl = returnURL; // arguments: error
  var url = "https://aws.appmartgroup.com//app/api/v1.0/face/";
  var countdown;
  var default_setting = {
      recordings: 2,
      maxupload: 20,
      motionareaheight: 160,
      threshold: 25,
      mirror: true,
      task: "identification"
  };
  var uploaded = 0,
      uploading = 0,
      captured = 0,
      capturing = false;
  const msg = "capturing..",
      color = "white";
  // template for motion detection
  // apply options to our default settings
  const settings = $.extend({}, default_setting);

 //mediaDevice 
  window.onload = function() {
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      // Older browsers might not implement mediaDevices at all, so we set an empty object first
      if (navigator.mediaDevices === undefined) {
          navigator.mediaDevices = {};
      }
//////////////////////
navigator.mediaDevices.enumerateDevices()
  .then(gotDevices).then(getStream).catch(handleError);
  videoSelect.onchange = getStream;
  //

      if (navigator.mediaDevices.getUserMedia === undefined) {
          navigator.mediaDevices.getUserMedia = function(constraints) {
              // First get ahold of the legacy getUserMedia, if present
              var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
              if (!getUserMedia) {
                  return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
              }
              return new Promise(function(resolve, reject) {
                  getUserMedia.call(navigator, constraints, resolve, reject);
              });
          }
      }
      navigator.mediaDevices.getUserMedia({
              audio: false,
              video: true
          })
          .then(function(stream) {
              // var video = document.querySelector('video');
              // Older browsers may not have srcObject
              if ("srcObject" in video) {
                  video.srcObject = stream;
              } else {
                  // Avoid using this in new browsers, as it is going away.
                  video.src = window.URL.createObjectURL(stream);
              }
              video.onloadedmetadata = function(e) {
                  video.play();
                  document.getElementById("play").hidden = false;
              };
          })
          .catch(function(err) {
              console.log(err.name + ": " + err.message);
              /* handle the error */
              if (err.name == "NotFoundError" || err.name == "DevicesNotFoundError") {
                  console.log('required track is missing')
              } else if (err.name == "NotReadableError" || err.name == "TrackStartError") {
                  console.log('webcam or mic are already in use')
              } else if (err.name == "OverconstrainedError" || err.name == "ConstraintNotSatisfiedError") {
                  console.log('constraints can not be satisfied by avb. devices')
              } else if (err.name == "NotAllowedError" || err.name == "PermissionDeniedError") {
                  console.log('permission denied in browser')
              } else if (err.name == "TypeError" || err.name == "TypeError") {
                  console.log('empty constraints object ')
              } else {
                  //other errors
              }
          });
  }

//Get type of camera devices
function gotDevices(deviceInfos) {
  for (var i = 0; i !== deviceInfos.length; ++i) {
    var deviceInfo = deviceInfos[i];
    var option = document.createElement('option');
    option.value = deviceInfo.deviceId;
    if (deviceInfo.kind === 'videoinput') {
      option.text = deviceInfo.label || 'camera ' +
        (videoSelect.length + 1);
      videoSelect.appendChild(option);
    } else {
      console.log('Found one other kind of source/device: ', deviceInfo);
    }
  }
}



function getStream() {
  if (window.stream) {
    window.stream.getTracks().forEach(function(track) {
      track.stop();
    });
  }

  var constraints = {
    video: {
      deviceId: {exact: videoSelect.value}
    }
  };

  navigator.mediaDevices.getUserMedia(constraints).
    then(gotStream).catch(handleError);
}

function gotStream(stream) {
 window.stream = stream; // make stream available to console
   video.srcObject = stream;
   //video.play();
}



function handleError(error) {
  console.log('Error: ', error);
}






  //start Biometric
  function start_biomtric() {
      starter = 1;
      console.log(starter);
  }
  //start Camera
  $(document).ready(function() {
      initializeCanvases()
          //Set Timer for noActivityTimer
  });
  //  Time Activities to abort capture
  function startActivityTimer(callback) {
      clearInterval(noActivityTimer);
      noActivityTimer = setInterval(function() {
          if (uploading === 0) {
              stop(FrameintervalID);
              callback('Activity time is over!');
          } else {
              startActivityTimer();
          }
      }, 1600000);
  }
  //Number Count down 
  function countdown() {
      document.getElementById("play").hidden = true;
      countdown = setInterval(myClock, 1000);
      var c = 5;
      function myClock() {
          document.getElementById("count").innerHTML = --c;
          if (c == 0) {
              clearInterval(countdown);
              document.getElementById("count").hidden = true;
              //start biometric after countdown
              start_biomtric();
          }
      }
  }
  //Error Call Back
  function callback(name) {
      document.location = errorUrl + "?error=" + name;
  }
  // initializing Process Frame
  function initializeCanvases() {
      // if mirroring required
      if (settings.mirror) {
          mirror();
      }
      //errorMsg() 
      FrameintervalID = window.setInterval(processFrame, 16);
      startActivityTimer(callback) // Start Activivty Timer
  }
  // Capture Frame Process
  function processFrame() {
      const width = video.videoWidth;
      const height = video.videoHeight;
      canvas.width = width; // using same size for the canvas
      canvas.height = height;
      let x = 0,
          y = 0,
          w = copycanvas.width,
          h = copycanvas.height,
          aspectratio = w / h;
      let cutoff = video.videoWidth - (video.videoHeight * aspectratio);
      let draw = ctx;
      let copy = copycanvas.getContext('2d');
      // we draw the frames manually using the private video element and the copy interim canvas
      copy.drawImage(video, cutoff / 2, 0, video.videoWidth - cutoff, video.videoHeight, 0, 0, copycanvas.width, copycanvas.height);
      // ensure that the canvas does not scale internally
      canvas.width = canvas.clientWidth;
      canvas.height = canvas.clientHeight;
      // center image in canvas
      if (canvas.width / canvas.height > aspectratio) {
          // center horizontally
          y = 0;
          h = canvas.height;
          w = h * aspectratio;
          x = (canvas.width - w) / 2;
      } else {
          // center vertically
          x = 0;
          w = canvas.width;
          h = w / aspectratio;
          y = (canvas.height - h) / 2;
      }
      draw.drawImage(copycanvas, 0, 0, copycanvas.width, copycanvas.height, x, y, w, h);
      // Drawing ellipse liveview
      let scaleX = 0.8;
      let scaleY = 1.1;
      let gradient = draw.createRadialGradient(canvas.width / 2 * 1 / scaleX, canvas.height / 2 * 1 / scaleY, 0, canvas.width / 2 * 1 / scaleX, canvas.height / 2 * 1 / scaleY, w * 0.5);
      gradient.addColorStop(0.98, 'transparent');
      gradient.addColorStop(0.99, 'rgba(255, 255, 255, 1)');
      draw.fillStyle = gradient;
      draw.setTransform(scaleX, 0, 0, scaleY, 0, 0);
      draw.fillRect(0, 0, canvas.width * 1 / scaleX, canvas.height * 1 / scaleY);
      //Scaling througt face detection 
      if (starter == 1) {
          detectFaces(copycanvas) // detect and Upload Image: Start uploading capture image for Biometric OPERATION 
      }
  }
  // Mirror Camera
  function mirror() {
      let copy = copycanvas.getContext('2d');
      copy.translate(copycanvas.width, 0);
      copy.scale(-1, 1);
  };
  // Message display on canvas
  function CanvasMsg(msg, color, fx, fy, fwidth, fheight) {
      //Controll Message in the Canvas
      const width = video.videoWidth;
      const height = video.videoHeight;
      canvas.width = width; // using same size for the canvas
      canvas.height = height;
      let x = 0,
          y = 0,
          w = copycanvas.width,
          h = copycanvas.height,
          aspectratio = w / h;
      let cutoff = video.videoWidth - (video.videoHeight * aspectratio);
      let draw = ctx;
      let copy = copycanvas.getContext('2d');
      // we draw the frames manually using the private video element and the copy interim canvas
      copy.drawImage(video, cutoff / 2, 0, video.videoWidth - cutoff, video.videoHeight, 0, 0, copycanvas.width, copycanvas.height);
      // ensure that the canvas does not scale internally
      canvas.width = canvas.clientWidth;
      canvas.height = canvas.clientHeight;
      // center image in canvas
      if (canvas.width / canvas.height > aspectratio) {
          // center horizontally
          y = 0;
          h = canvas.height;
          w = h * aspectratio;
          x = (canvas.width - w) / 2;
      } else {
          // center vertically
          x = 0;
          w = canvas.width;
          h = w / aspectratio;
          y = (canvas.height - h) / 2;
      }
      draw.drawImage(copycanvas, 0, 0, copycanvas.width, copycanvas.height, x, y, w, h);
      //Text Message
      draw.font = 'bold 35px Arial';
      draw.fillStyle = color;
      draw.textAlign = "center";
      draw.fillText(msg, 650 / 2, copycanvas.height / 2, x, y, 10, 20);
      // //Draw Line
      //  draw.beginPath();
      // draw.rect(fx, fy, fwidth, fheight, * Math.PI);
      //  draw.lineWidth = 3;
      //  draw.strokeStyle = 'red';
      //  draw.stroke();
      // Drawing ellipse liveview
      let scaleX = 0.8;
      let scaleY = 1.1;
      let gradient = draw.createRadialGradient(canvas.width / 2 * 1 / scaleX, canvas.height / 2 * 1 / scaleY, 0, canvas.width / 2 * 1 / scaleX, canvas.height / 2 * 1 / scaleY, w * 0.5);
      gradient.addColorStop(0.98, 'transparent');
      gradient.addColorStop(0.99, 'rgba(255, 255, 255, 1)');
      draw.fillStyle = gradient;
      draw.setTransform(scaleX, 0, 0, scaleY, 0, 0);
      draw.fillRect(0, 0, canvas.width * 1 / scaleX, canvas.height * 1 / scaleY);
  };
  // capture Frame
  function aws_capture() {
      var dataURL = copycanvas.toDataURL('image/png');
      var faces = detectFaces()
      console.log(faces)
          //console.log('Face',dataURL);
      console.log()
  }
  // public method to pause capturing
  function stop(starter) {
      console.log('Pausing capture...');
      //recording(false);
      video.pause();
      clearInterval(starter);
      //videoStream = null;
  };
  // detectFaces
  function detectFaces(canvas) {
      let faces = ccv.detect_objects({
          canvas: (ccv.pre(canvas)),
          cascade: cascade,
          interval: 2,
          min_neighbors: 1
      });
      //FaceTimer = wait 6 second if no facefound show message
      var FaceTimer = setTimeout(noFaceMsg, 30000);
      for (var i = 0; i < faces.length; i++) {
          var face = faces[i];
          //  console.log("face found ",faces.length)
          // console.log(face.x, face.y, face.width, face.height)
          if (faces.length == 1) {
              clearTimeout(FaceTimer)
              document.getElementById("message").hidden = true;
              var percentage = 100 * face.height / canvas.height;
              //Start Dataurl uploading //
             if (face.confidence > 1.5  && percentage > 40 ) {
                  document.getElementById("message2").hidden = true;
                  document.getElementById("done").innerHTML = msg;
                  console.log("SCORE ", face.confidence)
                  console.log("percentage ", percentage)
                  uploadTest()
              } else {
                  document.getElementById("message2").innerHTML = "Adjust lighting & Camera";
              }
          } else {
              CanvasMsg("Mutiple Face ", color)
          }
      }
  }
  function noFaceMsg() {
      document.getElementById("message").innerHTML = "";
  }
  // uploads an image to the AWS
  function upload() {
      uploading = captured++;
      if (uploading >= settings.recordings) {
          $("#uploadIcon").show()
          $("#message").hide()
          video.pause();
      }
      if (uploaded + uploading < settings.recordings) {
          var res = true
          if (res) {
              Dataurl = copycanvas.toDataURL('image/png');
              //indexOf base64 url
              let dataURL = Dataurl.substr(Dataurl.indexOf(',') + 1);
              document.getElementById("wait" + captured).hidden = false;
              ////////////////////////////////////// AJAX///////////////////////
              let jqxhr = $.ajax({
                  type: 'POST',
                  url: "https://aws.appmartgroup.com/app/api/v1.0/upload",
                  data: "{\n\t\"DataUrl\": \"" + dataURL + "\",\n\t\"index\": \"" + captured + "\"\n}",
                  // don't forget the authentication header
                  headers: {
                      "Content-Type": "application/json",
                      'aws-token': token
                  }
              }).done(function(data, textStatus, jqXHR) {
                  console.log(data.Accepted)
                  console.log("capture", uploading)
                  console.log("recording", settings.recordings)
                  if (captured >= settings.recordings) {
                      console.log('when captured is equal to settings')
                      stop(FrameintervalID);
                      performTask()
                  }
              }).fail(function(jqXHR, textStatus, errorThrown) {
                  callback('Network connection fail!');
                  console.log('upload failed', textStatus, errorThrown, jqXHR.responseText);
              });
              /////////////////////////////////////
          }
      }
  }
  // perform biometric task enrollment, verification or identification with already uploaded images
  function performTask() {
      var res = true
      if (res) {
          console.log('Biometric succeeded', 'response.Warnings');
          document.getElementById("done").hidden = true;
      
          document.getElementById("quality").innerHTML = "Processing Image ...";
        // PerformBiometricTask()
         PerformDetectLivness()
        
              //if (statusCallback) { statusCallback('Uploaded', response.Warnings.toString(), 'data:image/png;base64,'+dataURL); }
      } else {
          console.log('upload error', 'Error');
          stop(Uploadstarter)
      }
  }
  /// Upload Image for processFrame
  function PerformBiometricTask() {
      if (settings.task === 'enrollment') {
          url += 'enroll';
      } else if (settings.task === 'identification') {
          url += 'identy';
      } else if (settings.task === 'livenessdetection') {
          url += 'livenessdetection';
      } else {
          url += 'verify';
      }
      var urls = 'https://aws.appmartgroup.com//app/api/v1.0/face/identy';
      let jqxhr = {
          "async": true,
          "crossDomain": true,
          "url": urls,
          "method": "POST",
          "headers": {
              "Content-Type": "application/json",
              "aws-token": token,
              "cache-control": "no-cache",
          },
      }
      $.ajax(jqxhr).done(function(response) {
          console.log(response)
              ////////////////////////
          
          //looping ALL
          var ScoreClass1 = response.Matches[0].score;
          var DataMatch1 = response.Matches[0].classID;
          for (var i in response.Matches) {
              var ScoreClass = response.Matches[i].score;
              var DataMatch = response.Matches[i].classID;
              arrClass.push(response.Matches[i].classID)
              arrScore.push(response.Matches[i].score)
              console.log(arrClass);
              console.log(arrScore);
          }
          //looping all matach data
          //Biometric Log
          Bio_log(0, classID, KeyID, arrScore, arrClass, UserID)
          
          if (ScoreClass1 >= b_mark) {
              //swal("Duplicate", "Your Biometric Data already exist!!", "warning");
                    //   swal({
                    //   title: "Duplicate",
                    //   text: "Your Biometric Data already exist!!",
                    //   icon: "warning",
                    // });
              alert("Your Biometric Data already exist!!");
              $('#classD').val(DataMatch1);
              document.Bio_data.submit();;
          } else {
              ////////////////
              document.getElementById("biometric").hidden = true;
              document.getElementById("enroll").innerHTML = "Enrolling...";
              PerformEnrollMentTask()
          }
      });
      $.ajax(jqxhr).fail(function(response, jqXHR, textStatus, responseJSON) {
          callback('Network connection fail Identify!');
          console.log("error: ", response.responseJSON);
      });
  }
  ///Test
  /// Upload Image for processFrame
  function uploadTest() {
      // $("#uploadIcon").css({display: "block"});
      uploading = captured++;
      if (uploading >= settings.recordings) {
          $("#uploadIcon").show()
          $("#message").hide()
          video.pause();
      }
      if (uploaded + uploading < settings.recordings) {
          var res = true
          if (res) {
              Dataurl = copycanvas.toDataURL('image/png');
              var result = copycanvas.toDataURL('image/png');
              //indexOf base64 url
              let dataURL = result.substr(result.indexOf(',') + 1);
              document.getElementById("wait" + captured).hidden = false;
              ////////////////////////////////////// AJAX////////////////////////
              let jqxhr = $.ajax({
                  type: 'POST',
                  url: "https://aws.appmartgroup.com/app/api/v1.0/upload",
                  data: "{\n\t\"DataUrl\": \"" + dataURL + "\",\n\t\"index\": \"" + captured + "\"\n}",
                  // don't forget the authentication header
                  headers: {
                      "Content-Type": "application/json",
                      'aws-token': token
                  }
              }).done(function(data, textStatus, jqXHR) {
                  uploading--;
                  //if upload successful
                  if (data.Accepted) {
                      uploaded++;
                      console.log(data.Accepted)
                      console.log("uploaded", uploaded)
                          //upload done
                      document.getElementById("wait" + uploaded).hidden = true;
                      document.getElementById("imageU" + uploaded).hidden = false;
                      $("#imageU" + uploaded).attr('src', result);
                      if (uploaded == 1) {
                          // use performTask to cleanup already uploaded image
                          console.log('when captured is equal to settings')
                          stop(FrameintervalID);
                          console.log("Done")
                          performTask()
                      } else {
                          // restart process (retry)
                          // TODO: hmmm, really?
                          document.getElementById("message").hidden = false;
                          noFaceMsg();
                      }
                  } else {
                      console.log('upload error', data.Error);
                  }
              }).fail(function(jqXHR, textStatus, errorThrown) {
                  setTimeout(uploadControl, 30000);
                  console.log('upload failed', textStatus, errorThrown, jqXHR.responseText);
              });
              /////////////////////////////////////
          }
      }
  }
  //Perform Biometric Enrollmemt
  /// Upload Image for processFrame
  function PerformEnrollMentTask() {
      var urls = 'https://aws.appmartgroup.com//app/api/v1.0/face/enroll';
      let jqxhr = {
          "async": true,
          "crossDomain": true,
          "url": urls,
          "method": "POST",
          "headers": {
              "Content-Type": "application/json",
              "aws-token": token,
              "cache-control": "no-cache",
          },
      }
      $.ajax(jqxhr).done(function(response) {
          console.log(response)
              ////////////////////////
              //Biometric Log
          Bio_log(1, classID, KeyID, arrScore, arrClass, UserID)
          alert('Biometric Enrollment succeeded')
          
              //indexOf base64 url
          let dataURL = Dataurl.substr(Dataurl.indexOf(',') + 1);
          $('#DataURL').val(dataURL); // Pass Img Parameter
          //$('#DataURL').val(Dataurl); // Pass Img Parameter
          document.Bio_data_enrol.submit();
          // window.location.href = "http://localhost:8080/WebCam/success.html";
      });
      $.ajax(jqxhr).fail(function(response, jqXHR, textStatus, responseJSON) {
          console.log("error: ", response.responseJSON);
      });
  }
//lIVNESS DETECTION
function PerformDetectLivness() {
      var urls = 'https://aws.appmartgroup.com/app/api/v1.0/face/liveness';
      let jqxhr = {
          "async": true,
          "crossDomain": true,
          "url": urls,
          "method": "POST",
          "headers": {
              "Content-Type": "application/json",
              "aws-token": token
             
          },
      }
      $.ajax(jqxhr).done(function(response,textStatus, jqXHR) {
          console.log("live",response.Accepted)
              ////////////////////////
              if (response.Accepted) {
                  document.getElementById("quality").hidden = true;
                document.getElementById("biometric").innerHTML = "Identifying .. Please Wait";
               
                PerformBiometricTask()
              }else {
                  callback("Liveness Image Quality Failed")
              }
   
      });
      $.ajax(jqxhr).fail(function(response, jqXHR, textStatus, responseJSON) {
          callback('Network connection failed  !!!')
          console.log("error failed: ", response);
      });
  }
  function uploadControl() {
      callback('Network connection failed  !!!')
  }