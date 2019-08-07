<?php include("include/header.php") ?>
<?php include("include/nav-header.php") ?>
<?php include("include/nav-bar.php") ?>
<!-- Page content -->
            <div id="page-content-wrapper">
                <div class="page-content">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="header-icon">
                            <i class="fa fa-tachometer"></i>
                        </div>
                        <div class="header-title">
                            <h1> Dashboard</h1>
                            <small> Dashboard features</small>
                            <ul class="link hidden-xs">
                                <li><a href="index.html"><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="index.html">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

                    <!-- page section -->
                    <div class="container-fluid">
                        <div class="row">
                  <?php
                            foreach ($data2 as $key ) {
  $a=$key['classID'];
  $b=$key['KeyID'];
  $var1=$b.$a;
  ?>
<img src='<?=base_url()?>/assets/enroll/Api_pull/<?=$b.$a?>.png' data-lightbox="example-1" alt="NO IMAGE" width="100" height="80" >
  <?php
 
 
     }                      
  ?>                          
                            
                            
                        </div>
                        <!-- ./row -->
                    </div>
                    <!-- ./cotainer -->
                </div>
                <!-- ./page-content -->
            </div>
            <!-- ./page-content-wrapper -->
            <?php include("include/footer.php") ?>