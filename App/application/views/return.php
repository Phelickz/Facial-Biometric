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
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<body >

<article>
    <h1>Error Found !</h1>
    <div>
        <h2> <?php
$error=$_GET["error"];
$this->output->set_output(json_encode($error));
?></h2>
       
    </div>
</article>



</body>

</html>
