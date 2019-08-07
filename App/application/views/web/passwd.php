<?php include("include/header.php") ?>
<?php include("include/nav-header.php") ?>
<?php include("include/nav-bar.php") ?>
<!-- Page content -->
            <div id="page-content-wrapper"  ng-app="myStock" ng-controller="StockCtrl" ng-init="show_data()">
                <div class="page-content">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="header-icon">
                            <i class="fa fa-tachometer"></i>
                        </div>
                        <div class="header-title">
                            <h1> Password</h1>
                            <small> Password features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Dashboard">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

                    <!-- page section -->
                    <div class="container-fluid">
                        <div class="row">
                  
                            
                              <!-- basic forms -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-file-text-o fa-lg"></i>
                                        <h2>Change Password</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                    <form class="col s12 m-t-20" method="post" action="<?=base_url()?>User/Passwd">
                                        <?=validation_errors('<div  class="alert alert-danger alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>','</div>'); ?>
                                                                     <?php
                 if(isset($_SESSION['error'])){
                echo '<div  class="alert alert-danger alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 '.$error.'</div>'; 
                 }
                                ?> 
                                 <?php
                                 if(isset($_SESSION['success'])){
                echo '<div  class="alert alert-success alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 '.$this->session->flashdata('success').'</div>'; 
                 }
                                ?> 
                                               <div class="col-sm-12">
                                                
                                                <div class="input-field form-input col s6">
                                                    
                                                    <input type="password" class="validate" name="password" required>
                                                    <label>New Password</label>
                                                </div>

                                                <div class="input-field form-input col s6">
                                                   
                                                    <input type="password" class="validate" name="cpassword" required>
                                                    <label>Confirm Password</label>
                                                </div>
                                                </div>
                                                <button type="submit" class="btn btn-success">Change password<span class="glyphicon glyphicon-send"></span></butto>
                                                
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ./basic forms --> 







                
                            
                        </div>
                        <!-- ./row -->
                    </div>
                    <!-- ./cotainer -->
                </div>
                <!-- ./page-content -->
            </div>
            <!-- ./page-content-wrapper -->
            <!-- End Theme label Script-->



        <script>
            "use strict";
            $(function () {
                $('select').material_select();
                Materialize.updateTextFields();
                
                //datepicker
                $('.datepicker').pickadate({
                    selectMonths: true, // Creates a dropdown to control month
                    selectYears: 15 // Creates a dropdown of 15 years to control year
                });
            });
        </script>
            <?php include("include/footer.php") ?>