  const video = document.createElement('video');
  const canvas = document.querySelector('canvas');
  const copycanvas = document.createElement('canvas')
  copycanvas.width = 360
  copycanvas.height = 480
  const motioncanvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');
  const image = document.querySelector('img');
  var doneCallback, Uploadstarter, FrameintervalID, noActivityTimer, token, starter=0 , errorUrl="WebCam/error.html"; // arguments: error
  var url="https://aws.appmartgroup.com//app/api/v1.0/face/";
  var countdown;

  var default_setting = {
      recordings: 2,
      maxupload: 20,
      motionareaheight: 160,
      threshold: 25,
      mirror: true,
      task:"enrollment"
  };
  var uploaded = 0,
      uploading = 0,
      captured = 0,
      capturing = false;
  const msg = "capturing..",color = "white";
      // template for motion detection
      // apply options to our default settings
  const settings = $.extend({}, default_setting);


  window.onload = function() {
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      // Older browsers might not implement mediaDevices at all, so we set an empty object first
      if (navigator.mediaDevices === undefined) {
          navigator.mediaDevices = {};
      }
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


 //start Biometric
  function start_biomtric(){
    starter=1;
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
      window.location.href = "/"+errorUrl+"?token=" + token + "?error=" + name;
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
      if(starter==1){
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
      var FaceTimer=setTimeout(noFaceMsg, 3000);
    
      for (var i = 0; i < faces.length; i++) {
            var face = faces[i];
            //  console.log("face found ",faces.length)
            // console.log(face.x, face.y, face.width, face.height)
            
            if(faces.length == 1){
              clearTimeout(FaceTimer)
               document.getElementById("message").hidden = true;
             
              //Start Dataurl uploading //
            
              if (face.confidence > 0.4) {
              document.getElementById("message2").hidden = true;
               document.getElementById("done").innerHTML = msg;
              console.log("SCORE ",face.confidence)
                  uploadTest()
              }else{
             
              document.getElementById("message2").innerHTML = "Adjust lighting";

              }

            
            }else{
             CanvasMsg("Mutiple Face ", color)

            }
         }
 }


 function noFaceMsg() {
 document.getElementById("message").innerHTML = "No Face Found";
}


  // uploads an image to the AWS
   function upload() {
 
         
      uploading = captured++;
      
      if(uploading >= settings.recordings){
             $("#uploadIcon").show()
              $("#message").hide()
                video.pause();

              }
      if ( uploaded + uploading < settings.recordings) {
          var res = true
          if (res) {
             var result = copycanvas.toDataURL();
              //indexOf base64 url
            let dataURL = result.substr(result.indexOf(',') + 1);
              document.getElementById("wait"+captured).hidden = false;

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
            console.log("capture",uploading)
            console.log("recording",settings.recordings)

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
    function performTask()
         {

        var res = true
          if (res) {
             
              console.log('Biometric succeeded', 'response.Warnings');
              document.getElementById("done").hidden = true;
              document.getElementById("biometric").innerHTML = "Performing Biometric.";
              PerformBiometricTask() 
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
    
    let jqxhr = {
          "async": true,
          "crossDomain": true,
          "url": url,
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
          alert('Biometric Enrollment succeeded')

          window.location.href = "http://localhost:8080/WebCam/success.html";

  
      });
      $.ajax(jqxhr).fail(function(response, jqXHR, textStatus, responseJSON) {
          console.log("error: ", response.responseJSON);
      });

    
  }



///Test


/// Upload Image for processFrame
  function uploadTest() {
    // $("#uploadIcon").css({display: "block"});
     
      uploading = captured++;
      
      if(uploading >= settings.recordings){
             $("#uploadIcon").show()
              $("#message").hide()
                video.pause();

              }
      if ( uploaded + uploading < settings.recordings) {
          var res = true
          if (res) {
             var result = copycanvas.toDataURL();
              //indexOf base64 url
            let dataURL = result.substr(result.indexOf(',') + 1);
              document.getElementById("wait"+captured).hidden = false;

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
            console.log("capture",uploading)
            console.log("recording",settings.recordings)

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


