<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AWS Biometric panel</title>
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/web/dist/img/ico/fav.png">
        <!-- Start Global Mandatory Style
             =====================================================================-->
        <!-- jquery-ui css -->
        <link href="<?= base_url(); ?>assets/web/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <!-- materialize css -->
        <link href="<?= base_url(); ?>assets/web/plugins/materialize/css/materialize.min.css" rel="stylesheet">
        <!-- Bootstrap css-->
        <link href="<?= base_url(); ?>assets/web/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Animation Css -->
        <link href="<?= base_url(); ?>assets/web/plugins/animate/animate.css" rel="stylesheet" />
        <!-- Material Icons CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?= base_url(); ?>assets/web/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
        <!-- custom CSS -->
        <link href="<?= base_url(); ?>assets/web/dist/css/stylematerial.css" rel="stylesheet">
    </head>
<body class="sign-section">
    <div class="container sign-cont animated zoomIn">
        <div class="row sign-row">
            <div class="sign-title">
                <h2 class="teal-text"><i class="fa fa-user-circle-o"></i></h2>
                <h2 class="teal-text">AWS Biometric Login</h2>
            </div>

            <?php
                 if(isset($_SESSION['error'])){
                echo '<div  class="alert alert-danger alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 '.$this->session->flashdata('error').'</div>'; 
                 }
                                ?> 
                                <?php
                 if(isset($_SESSION['success'])){
                echo '<div  class="alert alert-danger alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 '.$this->session->flashdata('success').'</div>'; 
                 }
                                ?> 
                    <?=validation_errors('<div  class="alert alert-danger alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 ','</div>');
                     ?> 

          <form class="col s12" id="reg-form" method="post" action="<?=base_url()?>Auth/SLogin">
                <div class="row sign-row">
                    <div class="input-field col s12">
                        <input id="email" name="email" type="text" class="validate" required>
                        <label for="u_name">Email</label>
                    </div>
                </div>
                <div class="row sign-row">
                    <div class="input-field col s12">
                        <input id="password" name="password"  type="password" class="validate" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row sign-row">
                    <div class="input-field col s12 m-b-30">
                        <label class="pull-left"><a class='pink-text' href='#!'><b>Forgot Password?</b></a></label>
                    </div>
                </div>
                <div class="row sign-row">
                    <div class="input-field col s6">
                        <div class="sign-confirm">
                            <input type="checkbox" id="sign-confirm" />
                            <label for="sign-confirm">Remember me!</label>
                        </div>
                    </div>
                    <div class="input-field col s6">
                        <button class="btn btn-large btn-register waves-effect waves-light green" type="submit" name="action">Login
                           
                        </button>
                    </div>
                </div>
            </form>

        </div>
       
    </div>

    <!-- Start Core Plugins
         =====================================================================-->

  <!-- jQuery -->
        <script src="<?= base_url(); ?>assets/web/plugins/jQuery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <!-- jquery-ui -->
        <script src="<?= base_url(); ?>assets/web/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?= base_url(); ?>assets/web/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- materialize  -->
    <script src="<?= base_url(); ?>assets/web/plugins/materialize/js/materialize.min.js" type="text/javascript"></script>
    <!-- End Core Plugins
         =====================================================================-->
    <script>
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>
</body>

</html>