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

<form><form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="me@mybusiness.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="Teddy Bear">
<input type="hidden" name="amount" value="12.99">
<input type="image" src="http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Start Biometric Capture">
</form>

</body>

</html>
