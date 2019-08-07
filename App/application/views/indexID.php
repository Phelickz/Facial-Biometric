<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Appmart Identify User Interface</title>
	<link href="<?=base_url(); ?>assets/appmart/idd/css/uui.css" rel="stylesheet" />
	<link href="<?=base_url(); ?>assets/appmart/idd/css/load.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="<?=base_url(); ?>assets/appmart/idd/js/kevin.min.js"></script>
    <script src="<?=base_url(); ?>assets/appmart/idd/js/jquery-3.3.1.min.js"></script>
</head>

<style>
#dvLoading
{
background:#FFF url(<?php echo base_url(); ?>assets/appmart/idd/images/progress-bar.gif) no-repeat center center;
height: 300px;
width: 400px;
position: fixed;
z-index: 1000;
left: 50%;
top: 50%;
margin: -180px 0 0 -180px;

}

</style>
<body>
    <header class="header">

    </header>
	<!---------------------------------------------------------------->
<div id="dvLoading"></div>
    <main class="main">

        <section class="navigation">
            <a id="uuicancel" href=""><img src="<?=base_url(); ?>assets/appmart/idd/images/abort.svg" class="button-grow" alt="abort" title="Abort and navigate back to caller" data-res="buttonCancel" /></a>
            <a id="uuimirror" href="#" class="hidden"><img src="<?=base_url(); ?>assets/appmart/idd/images/mirror.svg" class="button-grow" alt="mirror" title="Mirror the display of the captured images" data-res="buttonMirror" /></a>
        </section>
        <section id="uuisplash">
            <div id="uuiprompt" class="prompt">
                <p data-res="prompt"></p>
                <p id="uuierror" class="alert-danger"></p>
                <a id="uuiskip" class="button" href="" title="Skip biometric process" data-res="buttonContinue">Skip biometrics</a>
                <a id="uuimobileapp" class="button" href="" title="Start the Appmart Biometrics app" data-res="buttonMobileApp">Start Appmart Biometrics app</a>
            </div>
        </section>
        <section id="uuiwebapp" class="webapp">
            <div id="uuiinstruction" class="instruction transparent-background"></div>
            <canvas id="uuicanvas" class="liveview">
            </canvas>
            <div id="uuimessage" class="message"></div>
            <div id="uuihead" class="head"></div>
            <a id="uuistart" class="startbutton" href="#"><img src="<?=base_url(); ?>assets/appmart/idd/images/play.svg" class="button-big-grow" alt="start" title="Start the recording of images" data-res="buttonStart" /></a>
            <div class="uploadstatus">
                <!-- status images for up to 4 recordings -->
                <div id="uuiimage1" class="image">
                    <div id="uuiwait1" class="spinner spinner-wait"></div>
                    <div id="uuiupload1" class="spinner spinner-upload" data-res="uploadInfo">Uploading...</div>
                    <img id="uuiuploaded1" class="image-uploaded" />
                </div>
                <div id="uuiimage2" class="image">
                    <div id="uuiwait2" class="spinner spinner-wait"></div>
                    <div id="uuiupload2" class="spinner spinner-upload" data-res="uploadInfo">Uploading...</div>
                    <img id="uuiuploaded2" class="image-uploaded" />
                </div>
                <div id="uuiimage3" class="image">
                    <div id="uuiwait3" class="spinner spinner-wait"></div>
                    <div id="uuiupload3" class="spinner spinner-upload" data-res="uploadInfo">Uploading...</div>
                    <img id="uuiuploaded3" class="image-uploaded" />
                </div>
                <div id="uuiimage4" class="image">
                    <div id="uuiwait4" class="spinner spinner-wait"></div>
                    <div id="uuiupload4" class="spinner spinner-upload" data-res="uploadInfo">Uploading...</div>
                    <img id="uuiuploaded4" class="image-uploaded" />
                </div>
            </div>
			<div>
				    
				</div>
        </section>
    </main>
<div class="land"> 

<form id="Bio_data" action="<?= base_url(); ?>service/api/push/identffy_call_push" method="POST" name="Bio_data">
 <input type="hidden" name="classD"  id="classD" value="">
 <input id="url" type="hidden" name="url" value="<?=$ReturnUrl?>" />
 <input id="UserID" type="hidden" name="UserID" value="<?=$UserID?>" />
 </form>
 
	<form id="Bio_data_enrol" action="<?php echo base_url(); ?>service/api/push/image_call_upload" method="POST" name="Bio_data_enrol">
                    <input id="DataURL" type="hidden" name="DataURL" value="" />
					<input id="url" type="hidden" name="url" value="<?=$ReturnUrl?>" />
					<input id="KeyID" type="hidden" name="KeyID" value="<?=$KeyID?>" />
					<input id="UserID" type="hidden" name="UserID" value="<?=$UserID?>" />
        	        <input type="hidden" name="ClassID"  id="ClassID" value="">
     </form>


<center>
<div class="well well-sm" id="div2"  style="display:none" >
<table >
  <tr>
    <th><img src="<?php echo base_url(); ?>assets/appmart/idd/images/bad.png " width="50" height="50"> <b>Bad Image</b></th>
    <th colspan="2"><img src="<?php echo base_url(); ?>assets/appmart/idd/images/good.png " width="50" height="50"><b>Sample Of Good Image</b> </th> 
   
  </tr>
   <tr>
    <td width='30%' style="padding-top:45px;"><img src="" width="200" height="200" class="img-thumbnail" id="imgg"></td>
    <td width='30%' style="padding-top:45px;"><img src="<?php echo base_url(); ?>assets/appmart/idd/images/okk.png " width="200" height="200" class="img-thumbnail">
	  </td>
	  <td width='40%'>
	
	<ol class="list-group"  align="center">
	<a href="#" class="list-group-item active" style="font-size:13px">CONDITIONS TO ENSURE A GOOD CAPTURE</a>
  <li class="list-group-item fd">Consistent lighting conditions.Ensure image is not dark and avoid dark environment. </li>
  <li class="list-group-item fd">Avoid reflection on your glasses.</li>
  <li class="list-group-item fd">Don't use sun-glasses.</li>
  <li class="list-group-item fd">When using a smartphone, capture youe face at eye-level.</li>
  <li class="list-group-item fd">Always center your face on your screen.</li>
  <li class="list-group-item fd">Turn your head slightly and slowly while keeping your  eyes on the camera/screen.</li>
 <li class="list-group-item fd">Please continue moving your head up and down and ensure your face is within the blue circle background</li>
  
</ol>
</td>
   
  </tr>
  
  </tr>
</table>
</div>
<div id="div1" class="" style="display:none" ></div>
<div id="div3" class="" style="display:none"  >	<button type="button" class="btn btn-success btn-block" onclick="goBack()">Start Biometric Again</button></div>
</center>
<div id="flash"></div>
</div>
<!------------------------------------------------->

    <script src="<?=base_url(); ?>assets/appmart/idd/js/jquery-3.3.1.min.js"></script>
    <script src="<?=base_url(); ?>assets/appmart/idd/js/getUserMedia.min.js"></script>
    <script src="<?=base_url(); ?>assets/appmart/idd/js/three.min.js"></script>
    <script src="<?=base_url(); ?>assets/appmart/idd/js/objLoader.min.js"></script>
	<script src="<?=base_url(); ?>assets/appmart/idd/js/appconfig.js"></script>
<script src="<?=base_url(); ?>assets/appmart/idd/js/bws.capture.js"></script>
   <script type="text/javascript">  
  
	
   </script>
	<script type="text/javascript">
       // BEGIN OF CONFIGURATION
		var my_url = '<?=base_url();  ?>';
		var token = <?="\"$token\""; ?>;
		var EToken = <?="\"$EToken\""; ?>;
        var returnURL = <?="\"$ErrorUrl\""; ?>;
        var state = <?="\"$state\"";?>;
        var apiurl = 'https://bws.bioid.com/extension/';
        var task = <?="\"$task\"";?>;;
        var trait = <?="\"$trait\"";?>;
        var executions = <?="\"$executions\"";?>;
        var recordings = <?="\"$recordings\"";?>;
		var classID = <?="\"$classID\"";?>;
		var CallURL = <?="\"$ReturnUrl\"";?>;
		var KeyID=<?="\"$KeyID\"";?>;
		var UserID=<?="\"$UserID\"";?>;
        var autostart = false;
        var challengeResponse = false;
        var challenges = [];
        var maxHeight = task === 'enrollment' ? 480 : 320;


        // BWS capture jQuery plugin
        var bwsCapture = null;
         // counter for current execution
        var currentExecution = 0;

        var currentTag = '';
        var parentTag = ''; 
    </script>
	<script src="<?=base_url(); ?>assets/appmart/idd/js/config.js"></script>
	
  
</body>
</html>