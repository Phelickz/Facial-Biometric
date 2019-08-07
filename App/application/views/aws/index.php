<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<link href="<?=base_url(); ?>assets/aws/idd/css/aws.css" rel="stylesheet" />
<script src="<?=base_url(); ?>assets/aws/idd/js/sweetalert.min.js"></script>

</head>
<body>
  <header class="header">
</header>
<main class="main">
<div class="row">

  
 <div  align="center">
  
   
<div class="select">
    <label for="videoSource"> </label><select id="videoSource"></select>
</div>


 <div  >   
 

  <canvas id="canvas" class="liveview can_vas_center" ></canvas>
<figure>
  <button name="play" class="can_vas_center" id="play" onclick="countdown()"></button>
</figure>
<div id="count" class="can_vas_center" style="font-weight: bolder; font-size: 59px"></div> 
<div id="message" class="can_vas_center" style="font-size: 30px"></div>
<div id="done" class="can_vas_center" style="font-size: 30px"></div>
<div id="message2" class="can_vas_center" style="font-size: 20px"></div>
<div id="quality" class="can_vas_center" style="font-size: 20px"></div>
<div id="biometric" class="can_vas_center" style="font-size: 22px"></div>
<div id="enroll" class="can_vas_center" style="font-size: 22px"></div>



</div>

</div>

</div>
<div class="flex" id="foo">
  <div class="upload1">
    <div id="wait1" class="loader"></div>
    <img src="" id="imageU1" class="image-uploaded"  />
  </div>
  <div class="upload2">
   <div id="wait2" class="loader"></div>
   <img src="" id="imageU2" class="image-uploaded"  />
  </div>
</div>

<form id="Bio_data" action="<?= base_url(); ?>service/api/push/identffy_call_push" method="POST" name="Bio_data">
      <input type="hidden" name="classD"  id="classD" value="">
      <input id="url" type="hidden" name="url" value="<?=$ReturnUrl?>" />
      <input id="UserID" type="hidden" name="UserID" value="<?=$UserID?>" />
       <input id="KeyID" type="hidden" name="KeyID" value="<?=$KeyID?>" />
            <input id="partition" type="hidden" name="partition" value="<?=$partition?>" />
</form>
 
<form id="Bio_data_enrol" action="<?= base_url(); ?>service/api/push/image_call_upload" method="POST" name="Bio_data_enrol">
          <input id="DataURL" type="hidden" name="DataURL" value="" />
          <input id="url" type="hidden" name="url" value="<?=$ReturnUrl?>" />
          <input id="KeyID" type="hidden" name="KeyID" value="<?=$KeyID?>" />
          <input id="UserID" type="hidden" name="UserID" value="<?=$UserID?>" />
          <input type="hidden" name="ClassID"  id="ClassID" value="<?=$classID?>">
               <input id="partition" type="hidden" name="partition" value="<?=$partition?>" />
</form>


</main>
</body>

  <script type="text/javascript">
       // BEGIN OF CONFIGURATION
    var my_url = '<?=base_url();  ?>';
    var token = <?="\"$token\""; ?>;
    var returnURL = <?="\"$ErrorUrl\""; ?>;
    var state = <?="\"$state\"";?>;
    var task = <?="\"$task\"";?>;;
    var trait = <?="\"$trait\"";?>;
    var executions = <?="\"$executions\"";?>;
    var recordings = <?="\"$recordings\"";?>;
    var classID = <?="\"$classID\"";?>;
    var CallURL = <?="\"$ReturnUrl\"";?>;
    var KeyID=<?="\"$KeyID\"";?>;
    var UserID=<?="\"$UserID\"";?>;
    var partition=<?="\"$partition\"";?>;
    var b_mark=<?="\"$b_mark\"";?>;

 document.getElementById("wait1").hidden = true;
 document.getElementById("wait2").hidden = true; 
 document.getElementById("play").hidden = true;
 document.getElementById("imageU1").hidden = true;
 document.getElementById("imageU2").hidden = true;

</script>


<script src="<?=base_url(); ?>assets/aws/idd/js/jquery-3.3.1.min.js"></script>  
<script src="<?=base_url(); ?>assets/aws/idd/js/aws.capture.js"></script>
<script src="<?=base_url(); ?>assets/aws/idd/js/config.js"></script>
<!-- Include the CCV image processing and face detection libraries -->
<script src="<?=base_url(); ?>assets/aws/idd/js/ccv.js"></script>
<script src="<?=base_url(); ?>assets/aws/idd/js/face.js"></script>



</html>
