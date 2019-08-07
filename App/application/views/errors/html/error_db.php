<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<title>DataBase Error</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1>Database Server Busy !</h1>
    <div>
        <p>Go Back  <a href="<?=base_url()?>Homepage">   To My App</a>!</p>
        <p>&mdash; The Team</p>

        <div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
    </div>
</article>
	
