<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>BioiD</title>
  <link href="<?=base_url(); ?>assets/appmart/idd/css/uui.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://cdn.rawgit.com/konvajs/konva/2.3.0/konva.min.js"></script>
    <script src="<?=base_url(); ?>assets/appmart/idd/js/jquery-3.3.1.min.js"></script>


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
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 2px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

#div1{
width: 800px
}
#div2{
width: 850px
}
#div3{
width: 850px;
margin:20px;
}
.fd{
	font-size: 13px;
	color: #933D3D;
	font-wight:bold;
	
}
</style>
</head>
<body>
<div class="land"> 
<div id="dvLoading"></div>
<form id="Bio_data" action="<?= base_url(); ?>service/api/push/identffy_call_push" method="POST" name="Bio_data">
 <input type="hidden" name="classD"  id="classD" value="">
 <input id="url" type="hidden" name="url" value="" />
 </form>
	<form id="Bio_data_enrol" action="<?php echo base_url(); ?>service/api/push/image_call_upload" method="POST" name="Bio_data_enrol">
                    <input id="DataURL" type="hidden" name="DataURL" value="" />
					<input id="url" type="hidden" name="url" value="" />
					<input id="KeyID" type="hidden" name="KeyID" value="" />
					
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
<script src="<?=base_url(); ?>assets/appmart/idd/js/appconfig.js"></script>
<script src="<?=base_url(); ?>assets/appmart/idd/js/bws.capture.js"></script>
   <script type="text/javascript">  </script>

  </body>
</html>


