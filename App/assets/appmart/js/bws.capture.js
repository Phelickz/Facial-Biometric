/*! BioID Web Service - 2018-04-07
*   image capture and recognition library - v2.0.0
*   https://www.bioid.com
*   Copyright (C) BioID GmbH.
*/


(function (bws, $, undefined) {
    // execute javascript in 'strict mode'
    'use strict';

    // init image capture and recognition library
    bws.initcapture = function (canvasElement, issuedToken, options) {
        var defaults = {
            apiurl: 'https://bws.bioid.com/extension/',
            task: 'verification', // | identification | enrollment | livenessdetection
            trait: 'FACE',
            maxheight: 480,
            recordings: 2,
            maxupload: 20,
            challengeResponse: false,
            motionareaheight: 160,
            threshold: 25,
            mirror: true   
        };

        // apply options to our default settings
        var settings = $.extend({}, defaults, options);
        // for backward compatibility apply host if it has been set 
        if (typeof settings.host !== 'undefined') { settings.apiurl = 'https://' + settings.host + '/extension/'; }

        // the canvas to draw the image and overlays
        var canvas = canvasElement;
        if (!canvas) { // we can't do anything without a canvas
            alert('Please provide a valid canvas element to initialize the BWS capture module!');
        }

        // the issued token
        var token = issuedToken;

        // private helper elements
        var video = document.createElement('video');
        // required for iOS 11 Safari
        video.setAttribute('playsinline', '');
        var copycanvas = document.createElement('canvas');
        var motioncanvas = document.createElement('canvas');

        // template for motion detection
        var template = null;

        // we need to put some additional things into our closure
        var videoStream;
        var processInterval; 

        // timer for 'No Motion' and 'No Activity'
        var noMotionTimer;
        var noActivityTimer;

        // possible status values: 
        //  UserInstruction-Start, UserInstruction-1, UserInstruction-2, UserInstruction-3, UserInstruction-NoMovement, 
        //  Uploading, Uploaded, DisplayTag, Perform-verification, Perform-identification, Perform-enrollment, Perform-livenessdetection,
        //  NoFaceFound, MultipleFacesFound, LiveDetectionFailed, ChallengeResponseFailed, NotRecognized, NoTemplateAvailable
        var statusCallback; // arguments: status { message | tag } { dataURL }
        var doneCallback; // arguments: error

        var uploaded = 0, uploading = 0, captured = 0, capturing = false;
        var tag = 'any'; // any, up, down, left, right
        var tags = [];

        /* ----------------------- Public function for capturing ------------------------- */

        // public method to start capturing. The functions
        // onSuccess(), onFailure(error) and onDone(error) must be applied,
        // onStatus(status, message, dataURL) is optional
        var start = function (onSuccess, onFailure, onDone, onStatus) {
            console.log('Starting capture...');
            doneCallback = onDone;          
            statusCallback = onStatus;
           
            if (videoStream) {
                // we have been started already
                return;
            }
            
            var constraints = { audio: false, video: { facingMode: "user" } }; 
            navigator.mediaDevices.getUserMedia(constraints)
                .then(function (mediaStream) {
                    console.log('Video capture stream has been created with constraints:', constraints);
                    videoStream = mediaStream;
                    video.srcObject = mediaStream;
                    video.onloadedmetadata = function (e) {
                        video.play();
                        console.log('Playing live media stream');        
                        // init the various canvases ...
                        initializeCanvases();
                        console.log('capture started');
                        onSuccess();
                    };
                })
                .catch(function (err) {
                    console.log('getUserMedia failed with error:', err);
                    onFailure(err);
                });
        };

        // public method to pause capturing
        var stop = function () {
            console.log('Pausing capture...');
            recording(false);
            video.pause();
            clearInterval(processInterval);
            videoStream = null;
        };

        // public method to mirror the display of the captured image
        var mirror = function () {
            let copy = copycanvas.getContext('2d');
            copy.translate(copycanvas.width, 0);
            copy.scale(-1, 1);
        };

        // public method to start the biometric process
        var startRecording = function (challenges, countdown) {
            recording(false);
            tags = challenges ? challenges : [];
            if (countdown && statusCallback) {
                // use countdown
                statusCallback('UserInstruction-3');
                setTimeout(function () { statusCallback('UserInstruction-2'); }, 400);
                setTimeout(function () { statusCallback('UserInstruction-1'); }, 800);
                setTimeout(initRecording, 1200);
            }
            else {
                initRecording();
            }
        };

        /* ------------------------ Private image capturing functions ------------------ */

        // private method to init the size of the canvases
        function initializeCanvases() {
            canvas.width = canvas.clientWidth;
            canvas.height = canvas.clientHeight;

            // we prefer 3 : 4 face image resolution
            let aspectratio = video.videoWidth / video.videoHeight < 3 / 4 ? video.videoWidth / video.videoHeight : 3 / 4;
            copycanvas.height = video.videoHeight > settings.maxheight ? settings.maxheight : video.videoHeight;
            copycanvas.width = copycanvas.height * aspectratio;
            motioncanvas.height = settings.motionareaheight;
            motioncanvas.width = motioncanvas.height * aspectratio;

            // if mirroring required
            if (settings.mirror) { mirror(); }

            // set an interval-timer to grab about 20 frames per second
            processInterval = setInterval(processFrame, 50);
        }

        function initRecording() {
            if (statusCallback) { statusCallback('UserInstruction-Start'); }
            recording(true);
            startActivityTimer();
        }

        // start or stop recording
        function recording(capture) {
            clearInterval(noMotionTimer);
            clearInterval(noActivityTimer);
            uploaded = 0;
            uploading = 0;
            template = null;
            capturing = capture;
        }

        // private worker method for each frame
        function processFrame() {
            let x = 0, y = 0, w = copycanvas.width, h = copycanvas.height, aspectratio = w / h;
            let cutoff = video.videoWidth - (video.videoHeight * aspectratio);
            let draw = canvas.getContext('2d');
            let copy = copycanvas.getContext('2d');

            // we draw the frames manually using the private video element and the copy interim canvas
            copy.drawImage(video, cutoff / 2, 0, video.videoWidth - cutoff, video.videoHeight, 0, 0, copycanvas.width, copycanvas.height);

            // ensure that the canvas does not scale internally
            canvas.width = canvas.clientWidth;
            canvas.height = canvas.clientHeight;

            // white background
            draw.fillStyle = 'white';
            draw.fillRect(0, 0, canvas.width, canvas.height);

            // center image in canvas
            if (canvas.width / canvas.height > aspectratio) {
                // center horizontally
                y = 0;
                h = canvas.height;
                w = h * aspectratio;
                x = (canvas.width - w) / 2;
            }
            else {
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
            let gradient = draw.createRadialGradient(canvas.width/2 * 1/scaleX, canvas.height/2 * 1/scaleY, 0, canvas.width/2 * 1/scaleX, canvas.height/2 * 1/scaleY, w * 0.5);
            gradient.addColorStop(0.98, 'transparent');
            gradient.addColorStop(0.99, 'rgba(255, 255, 255, 1)');
            draw.fillStyle = gradient;
            draw.setTransform(scaleX, 0, 0, scaleY, 0, 0);
            draw.fillRect(0, 0, canvas.width * 1 / scaleX, canvas.height * 1 / scaleY);       

            if (capturing && uploaded < settings.recordings) {
                // we may need to switch on the tags again ??????
                //if (settings.challengeResponse && tag === 'any') { setTag(); }

                if (captured > settings.maxupload) {
                    stop();
                    doneCallback('The maximum number of uploads has been reached!');
                }

                // scale current image into the motion canvas
                let motionctx = motioncanvas.getContext('2d');
                motionctx.drawImage(copycanvas, copycanvas.width / 8, copycanvas.height / 8, copycanvas.width - copycanvas.width / 4, copycanvas.height - copycanvas.height / 4, 0, 0, motioncanvas.width, motioncanvas.height);
                let currentImageData = motionctx.getImageData(0, 0, motioncanvas.width, motioncanvas.height);

                let movement = 100;
                if (template) {
                    // calculate motion
                    movement = motionDetection(currentImageData, template);
                }

                // trigger if movement is above threshold (default: when 20% of maximum movement is exceeded)
                if (movement > settings.threshold) {
                    if (uploaded + uploading < settings.recordings) {
                        // in case we are not already bussy with some uploads start upload procedure
                        upload();
                        // current image is the new reference frame - create template
                        template = createTemplate(currentImageData);
                    }
                }
            }
        }

        /* ------------------------ Timer functions ----------------------------------- */

        // we give a NoMovement response every 6 seconds
        function startMotionTimer() {
            clearInterval(noMotionTimer);
            noMotionTimer = setInterval(function () {
                if (uploading + uploaded < settings.recordings) {
                    if (statusCallback) { statusCallback('UserInstruction-NoMovement'); }
                }
            }, 5000);
        }

        // after a given time without activity from the user we abort the process
        function startActivityTimer() {
            clearInterval(noActivityTimer);
            noActivityTimer = setInterval(function () {
                if (uploading === 0) {
                    stop();
                    doneCallback('Activity time is over!');
                }
                else {
                    startActivityTimer();
                }
            }, 30000);
        }

        /* ------------------------ BWS Web Api calls --------------------------------- */

        // uploads an image to the BWS
        function upload() {
            startMotionTimer();

            // start upload procedure, but only if we still have to
            if (capturing && uploaded + uploading < settings.recordings) {
                captured++;
                uploading++;
				//settings.color ? copycanvas.toDataURL() : bws.toGrayDataURL(copycanvas);
				let EdataURL = copycanvas.toDataURL();
				sessionStorage.setItem("EdataURLD", EdataURL);
                let dataURL = settings.color ? copycanvas.toDataURL() : bws.toGrayDataURL(copycanvas);
                console.log('sizeof dataURL', dataURL.length);

                if (statusCallback) {
                    statusCallback('Uploading');
                }

                if (!$.support.cors) {
                    // the call below typically requires Cross-Origin Resource Sharing!
                    console.log('this browser does not support cors, e.g. IE8 or 9');
                }

                let jqxhr = $.ajax({
                    type: 'POST',
                    url: settings.apiurl + 'upload?tag=' + tag + '&index=' + captured + '&trait=' + settings.trait,
                    data: dataURL,
                    // don't forget the authentication header
                    headers: { 'Authorization': 'Bearer ' + token }
                }).done(function (data, textStatus, jqXHR) {
                    uploading--;
                    if (data.Accepted) {
                        uploaded++;
                        console.log('upload succeeded', data.Warnings);
                        if (statusCallback) { statusCallback('Uploaded', data.Warnings.toString(), dataURL); }
                    } else {
                        console.log('upload error', data.Error);
                        if (statusCallback) { statusCallback(data.Error); }
                        if (uploaded < 1) {
                            // restart process (retry)
                            // TODO: hmmm, really?
                            doneCallback('NoFaceFound', true);
                        }
                        else {
                            // use performTask to cleanup already uploaded image
                            // TODO: this is a dummy call!
                            performTask();
                        }
                    }
                    if (uploaded >= settings.recordings && uploading === 0) {
                        // go for biometric task
                        performTask();
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    // ups, call failed, typically due to
                    // Unauthorized (invalid token) or
                    // BadRequest (Invalid or unsupported sample format) or
                    // InternalServerError (An exception occured)
                    console.log('upload failed', textStatus, errorThrown, jqXHR.responseText);
                    stop();
                    // redirect to caller with error response..
                    doneCallback(errorThrown);
                });
                // show a new tag if neccessary
                if (uploaded < settings.recordings-1) {
                    setTag();
                }
            }
        }

        // perform biometric task enrollment, verification or identification with already uploaded images
        function performTask() {
			 //performGET()
            // we already have all images the motion timer is no longer required
            clearInterval(noMotionTimer);

            // check which task should be executed and set right url extension
            let url = settings.apiurl;
            if (settings.task === 'enrollment') { url += 'enroll'; }
            else if (settings.task === 'identification') { url += 'identify'; }
            else if (settings.task === 'livenessdetection') { url += 'livenessdetection'; }
            else { url += 'verify'; }

            if (statusCallback) { statusCallback('Perform-' + settings.task); }

            // perform the call
            let jqxhr = $.ajax({
                type: 'GET',
                url: url,
                headers: { 'Authorization': 'Bearer ' + token }
            }).done(function (data, textStatus, jqXHR) {
                if (data.Success) {
                    console.log('task succeeded');
					performGET();
                   // stop();
                   // doneCallback();
                } else {
                    console.log('task failed', data.Error);
                    let err = data.Error ? data.Error : 'NotRecognized';
                    if (statusCallback) { statusCallback(err); }
                    recording(false); // stop() -> in case of NoTemplateAvailable or no re-tries any more!?
                    doneCallback(err, err !== 'NoTemplateAvailable');
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // ups, call failed, typically due to
                // Unauthorized (invalid token) or
                // BadRequest (Invalid package) or
                // InternalServerError (An exception occured)
                console.log('task failed', textStatus, errorThrown, jqXHR.responseText);
                stop();
                // redirect to caller with error response..
                doneCallback(errorThrown);
            });
        }

		
		/*-------------------------Get all image ---------------------------------------*/
		// perform biometric task enrollment or verification with already uploaded images
        function performGET() {
            clearInterval(noMotionTimer);
			 var guiuploaded1= $('#uuiuploaded1').attr('src');
			 var guiuploaded2= $('#uuiuploaded2').attr('src');
			 var guiuploaded3= $('#uuiuploaded3').attr('src');
			 var guiuploaded4= $('#uuiuploaded4').attr('src');
			     localStorage.setItem("dataURL1", guiuploaded1);
				 localStorage.setItem("dataURL2", guiuploaded2);
				 localStorage.setItem("dataURL3", guiuploaded3);
				 localStorage.setItem("dataURL4", guiuploaded4);
				 var eImg=sessionStorage.getItem("EdataURLD");
				 var arraydataURL = [guiuploaded1,guiuploaded2,guiuploaded3];//array
				 var CLassIDV=localStorage.getItem("classIDApi");
                $('#DataURL').val(eImg); // Pass Img Parameter
                $('#ClassID').val(CLassIDV); // Pass Class Parameter
		        document.Bio_data_enrol.submit();
				 
				 
						
        }
        /* ------------------------ Set challenge response tag ------------------------- */
		
		/*-------------------------Upload Images --------------------------------------- */

        // generate a new challenge response tag or resets it to 'any'
        function setTag() {
            if (settings.challengeResponse) {
                let currentRecording = uploaded + uploading;
                if (currentRecording > 0 && currentRecording < settings.recordings) {
                    if (tags.length >= currentRecording) {
                        // use the preset (typically via the BWS access token) tags!
                        tag = tags[currentRecording - 1];
                    }
                    else {
                        let newtag = tag;
                        if (currentRecording % 2 === 1) {
                            // create a random tag
                            let r = Math.random();
                            if (currentRecording === 1) {
                                if (r < 0.25) { newtag = 'up'; }
                                else if (r < 0.5) { newtag = 'down'; }
                                else if (r < 0.75) { newtag = 'left'; }
                                else { newtag = 'right'; }
                            }
                            else {
                                // create a tag in a direction different to the last movement axis 
                                if (tag === 'up' || tag === 'down') {
                                    if (r < 0.5) { newtag = 'left'; }
                                    else { newtag = 'right'; }
                                }
                                else {
                                    if (r < 0.5) { newtag = 'up'; }
                                    else { newtag = 'down'; }
                                }
                            }
                        }
                        else {
                            // create a tag in the opposite direction of the last tag
                            switch (tag) {
                                case 'left':
                                    newtag = 'right';
                                    break;
                                case 'right':
                                    newtag = 'left';
                                    break;
                                case 'up':
                                    newtag = 'down';
                                    break;
                                case 'down':
                                    newtag = 'up';
                                    break;
                                default:
                                    break;
                            }
                        }
                        console.log('Switched tag for recording #' + currentRecording + ' from ' + tag + ' to ' + newtag);
                        tag = newtag;
                    }
                }
                else { tag = 'any'; }
            }

            if (statusCallback) { statusCallback('DisplayTag', tag); }
            
            if (capturing) {
                // give user some time to react!
                capturing = false;
                setTimeout(function () { if (template !== null) capturing = true; }, 1000);
            }        
        }

        /* ------------------------ Motion Detection functions ------------------------ */

        // template for cross-correlation
        function createTemplate(imageData) {
            // cut out the template
            // we use a small width, quarter-size image around the center as template
            var template = {
                centerX: imageData.width / 2,
                centerY: imageData.height / 2,
                width: imageData.width / 4,
                height: imageData.height / 4 + imageData.height / 8
            };

            template.xPos = template.centerX - template.width / 2;
            template.yPos = template.centerY - template.height / 2;
            template.buffer = new Uint8ClampedArray(template.width * template.height);

            let counter = 0;
            let p = imageData.data;
            for (let y = template.yPos; y < template.yPos + template.height; y++) {
                // we use only the green plane here 
                let bufferIndex = (y * imageData.width * 4) + template.xPos * 4 + 1;
                for (let x = template.xPos; x < template.xPos + template.width; x++) {
                    let templatepixel = p[bufferIndex];
                    template.buffer[counter++] = templatepixel;
                    // we use only the green plane here 
                    bufferIndex += 4;
                }
            }
            console.log('Created new cross-correlation template', template);
            return template;
        }

        // motion detection by a normalized cross-correlation
        function motionDetection(imageData, template) {
            // this is the major computing step: Perform a normalized cross-correlation between the template of the first image and each incoming image
            // this algorithm is basically called "Template Matching" - we use the normalized cross correlation to be independent of lighting changes
            // we calculate the correlation of template and image over the whole image area
            let bestHitX = 0,
                bestHitY = 0,
                maxCorr = 0,
                searchWidth = imageData.width / 4,
                searchHeight = imageData.height / 4,
                p = imageData.data;

            for (let y = template.centerY - searchHeight; y <= template.centerY + searchHeight - template.height; y++) {
                for (let x = template.centerX - searchWidth; x <= template.centerX + searchWidth - template.width; x++) {
                    let nominator = 0, denominator = 0, templateIndex = 0;

                    // Calculate the normalized cross-correlation coefficient for this position
                    for (let ty = 0; ty < template.height; ty++) {
                        // we use only the green plane here 
                        let bufferIndex = x * 4 + 1 + (y + ty) * imageData.width * 4;
                        for (let tx = 0; tx < template.width; tx++) {
                            let imagepixel = p[bufferIndex];
                            nominator += template.buffer[templateIndex++] * imagepixel;
                            denominator += imagepixel * imagepixel;
                            // we use only the green plane here 
                            bufferIndex += 4;
                        }
                    }
                       
                    // The NCC coefficient is then (watch out for division-by-zero errors for pure black images)
                    let ncc = 0.0;
                    if (denominator > 0) {
                        ncc = nominator * nominator / denominator;
                    }
                    // Is it higher than what we had before?
                    if (ncc > maxCorr) {
                        maxCorr = ncc;
                        bestHitX = x;
                        bestHitY = y;
                    }
                }
            }
            // now the most similar position of the template is (bestHitX, bestHitY). Calculate the difference from the origin
            let distX = bestHitX - template.xPos,
                distY = bestHitY - template.yPos,
                movementDiff = Math.sqrt(distX * distX  + distY * distY);
            // the maximum movement possible is a complete shift into one of the corners, i.e
            let maxDistX = searchWidth - template.width / 2,
                maxDistY = searchHeight - template.height / 2,
                maximumMovement = Math.sqrt(maxDistX * maxDistX + maxDistY * maxDistY);

            // the percentage of the detected movement is therefore
            var movementPercentage = movementDiff / maximumMovement * 100;
            if (movementPercentage > 100) {
                movementPercentage = 100;
            }
            //console.log('Calculated movement: ', movementPercentage);
            return movementPercentage;
        }

        return {
            start: start,
            stop: stop,
            startRecording: startRecording,
            stopRecording: function () { recording(false); },
            upload: upload,
            mirror: mirror,
            getUploading: function () { return uploading; },
            getUploaded: function () { return uploaded; }
        };   
    };
	
	// replacement of the HTMLCanvasElement.toDataURL method that creates 8bit gray PNGs
    // see: http://www.w3.org/TR/PNG/, http://www.ietf.org/rfc/rfc1950.txt and http://www.ietf.org/rfc/rfc1951.txt
    bws.toGrayDataURL = function (canvas) {
        var i, j,
            width = canvas.width,
            height = canvas.height,
            depth = 8;
        // pixel data and row filter identifier size
        var pix_size = height * (width + 1);
        // deflate header, pix_size, block headers (N 64kB blocks), adler32 checksum
        var data_size = 2 + pix_size + 5 * Math.floor((0xfffe + pix_size) / 0xffff) + 4;
        // offsets and sizes of Png chunks (= 4byte length + 4byte type + data + 4 byte crc = 12byte + data)
        var ihdr_offs = 8,								    // IHDR offset and size
            ihdr_size = 12 + 13,                            // width 4, height 4, depth 1, Colour type 1, Compression method 1, Filter method 1, Interlace method 1
            idat_offs = ihdr_offs + ihdr_size,	            // IDAT offset and size
            idat_size = 12 + data_size,
            iend_offs = idat_offs + idat_size,	            // IEND offset and size
            iend_size = 12,
            buffer_size = iend_offs + iend_size;            // total PNG size

        var buffer = new Uint8ClampedArray(buffer_size);
        var _crc32 = [];

        // initialize non-zero elements
        // first 8 bytes (in decimal: 137 80 78 71 13 10 26 10)
        writeString(buffer, 0, '\x89PNG\r\n\x1A\n');
        var offset = ihdr_offs;
        offset += writeByte4(buffer, offset, ihdr_size - 12);
        offset += writeString(buffer, offset, 'IHDR');
        offset += writeByte4(buffer, offset, width);
        offset += writeByte4(buffer, offset, height);
        buffer[offset] = 8;
        writeByte4(buffer, idat_offs, idat_size - 12);
        writeString(buffer, idat_offs + 4, 'IDAT');
        writeByte4(buffer, iend_offs, iend_size - 12);
        writeString(buffer, iend_offs + 4, 'IEND');

        // initialize deflate header
        var header = ((8 + (7 << 4)) << 8) | (3 << 6); // CMF(deflate + 32K windows size)|FLG(compression level 3))
        header += 31 - (header % 31); // check bits
        writeByte2(buffer, idat_offs + 8, header);

        // initialize deflate block headers
        var totalsize = 0;
        for (i = 0; totalsize < pix_size; i++) {
            var size, bits;
            if (totalsize + 0xffff < pix_size) {
                size = 0xffff;
                bits = 0; // BTYPE = 00 (Non-compressed blocks)
            } else {
                size = pix_size - totalsize;
                bits = 1; // BFINAL | BTYPE = 00
            }
            var offs = idat_offs + 8 + 2 + i * 5 + totalsize;
            buffer[offs++] = bits;
            buffer[offs++] = size & 0xff;
            buffer[offs++] = (size >> 8) & 0xff;
            buffer[offs++] = ~size & 0xff;
            buffer[offs++] = (~size >> 8) & 0xff;
            totalsize += size;
        }

        // create crc32 lookup table
        for (i = 0; i < 256; i++) {
            var c = i;
            for (j = 0; j < 8; j++) {
                if (c & 1) {
                    c = -306674912 ^ ((c >> 1) & 0x7fffffff);
                } else {
                    c = (c >> 1) & 0x7fffffff;
                }
            }
            _crc32[i] = c;
        }

        var setGrayValues = function (canvas) {
            // compute gray values for dest buffer
            var d = canvas.getContext('2d').getImageData(0, 0, width, height).data; // this is a Uint8ClampedArray
            var offset = idat_offs + 8 + 2 + 5, i = 0, r = 0, gray, c;

            // at the same time we compute adler32 of output pixels and row filter bytes (about 50ms faster than doing it in seperate loops)
            var BASE = 65521; // largest prime smaller than 65536 
            var NMAX = 5552;  // NMAX is the largest n such that 255n(n+1)/2 + (n+1)(BASE-1) <= 2^32-1
            var s1 = 1;
            var s2 = 0;
            var n = NMAX;

            for (var y = 0; y < height; y++) {
                // adler32 for row filter value 0
                //s1 += 0;
                s2 += s1;
                if ((n -= 1) === 0) {
                    s1 %= BASE;
                    s2 %= BASE;
                    n = NMAX;
                }
                // skip row filter byte
                if (++i === 0xffff) {
                    // skip block header
                    offset += i + 5;
                    i = 0;
                }

                for (var x = 0; x < width; x++) {
                    gray = d[r] * 0.3 + d[r + 1] * 0.59 + d[r + 2] * 0.11;
                    buffer[offset + i] = gray;
                    // adler32
                    s1 += buffer[offset + i];
                    s2 += s1;
                    if ((n -= 1) === 0) {
                        s1 %= BASE;
                        s2 %= BASE;
                        n = NMAX;
                    }
                    r += 4;
                    if (++i === 0xffff) {
                        // skip block header
                        offset += i + 5;
                        i = 0;
                    }
                }
            }
            // adler32
            s1 %= BASE;
            s2 %= BASE;
            writeByte4(buffer, idat_offs + idat_size - 8, (s2 << 16) | s1);
        };

        // helper functions for that ctx
        function crc32(buf, offs, size) {
            var crc = -1;
            for (var i = 4; i < size - 4; i += 1) {
                crc = _crc32[(crc ^ buf[offs + i]) & 0xff] ^ ((crc >> 8) & 0x00ffffff);
            }
            writeByte4(buf, offs + size - 4, crc ^ -1);
        }

        function writeString(buf, offs, s) {
            for (var i = 0; i < s.length; i++) {
                buf[offs++] = s.charCodeAt(i);
            }
            return s.length;
        }

        function writeByte2(buf, offs, w) {
            buf[offs++] = (w >> 8) & 0xff;
            buf[offs++] = w & 0xff;
            return 2;
        }

        function writeByte4(buf, offs, w) {
            buf[offs++] = (w >> 24) & 0xff;
            buf[offs++] = (w >> 16) & 0xff;
            buf[offs++] = (w >> 8) & 0xff;
            buf[offs++] = w & 0xff;
            return 4;
        }

        // we immediately perform the conversion
        setGrayValues(canvas);

        // compute crc32 of the PNG chunks
        crc32(buffer, ihdr_offs, ihdr_size);
        crc32(buffer, idat_offs, idat_size);
        crc32(buffer, iend_offs, iend_size);

        // encode the image
        // convert PNG to string (needs to be done in blocks, as chrome throws stack overflow exception)
        var s = '';
        for (i = 0; i < buffer_size; i += 0xffff) {
            var elements = i + 0xffff < buffer_size ? 0xffff : buffer_size - i;
            var view = new Uint8ClampedArray(buffer.buffer, i, elements);
            s += String.fromCharCode.apply(null, view); 
        }
        // Base64 encoding
        s = btoa(s);
        return 'data:image/png;base64,' + s;
    };
	
}(window.bws = window.bws || {}, jQuery));