<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<script src="<?= base_url(); ?>assets/appmart/js/jquery-3.2.1.min.js"></script>
<script language=javascript>
function redirect(){
  window.location = "<?=base_url(); ?>Dashboard/usercall";
}
</script>

<body >

<?php
echo " <br><b>from url without decoding we get :</b> $_GET[DataURL]<br>";
echo " <br><b>from url after decoding we get :</b> ".urlencode($_GET['DataURL'])."<br>";
echo " <br><b>from url after decoding we get :</b> ".urldecode($_GET['ImageID'])."<br>";
?>

</body>

</html>
