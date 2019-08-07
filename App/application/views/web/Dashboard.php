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
                            <h1> AWS Dashboard</h1>
                            <small>AWS Dashboard features</small>

                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>
                        
                    <!-- page section -->
                    <div class="container-fluid">
                        <div class="row">
                   <?php
                 if(isset($_SESSION['success'])){
                echo '<div class="alert alert-success fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="glyphicon glyphicon-ban-circle alert-icon "></i>
                                <strong>'.$this->session->flashdata('success').'</div>'; 
                 }
                                ?>
                            
                                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="panel cardbox bg-warning">
                                    <div class="panel-body card-item panel-refresh">
                                        <a class="refresh" href="#">
                                            <span class="fa fa-refresh"></span>
                                        </a> 
                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>
                                        <div class="timer" data-to="<?=$enroll?>" data-speed="1500">0</div>
                                        <div class="cardbox-icon">
                                            <i class="material-icons"></i>
                                        </div>
                                        <div class="card-details">
                                            <h4>Total Enrollemt Calls</h4>
                                            <span>Daily Enrollemt Calls : <?=$Denroll?>  </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="panel cardbox bg-primary">
                                    <div class="panel-body card-item panel-refresh">
                                        <a class="refresh" href="#">
                                            <span class="fa fa-refresh"></span>
                                        </a> 
                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>
                                        <div class="timer" data-to="<?=$iden?>" data-speed="1500">0</div>
                                        <div class="cardbox-icon">
                                            <i class="material-icons"></i>
                                        </div>
                                        <div class="card-details">
                                            <h4>Total Identify Calls</h4>
                                            <span>Daily Identify Calls :<?=$Diden?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="panel cardbox bg-success">
                                    <div class="panel-body card-item panel-refresh">
                                        <a class="refresh2" href="#">
                                            <span class="fa fa-refresh"></span>
                                        </a> 
                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>
                                        <div class="timer" data-to="<?=$Api_s?>" data-speed="1500">0</div>
                                        <div class="cardbox-icon">
                                            <i class="material-icons"></i>
                                        </div>
                                        <div class="card-details">
                                            <h4>Api Calls</h4>
                                            <span>Api Calls : 0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!-- ./counter Number -->
                            <!-- chart -->
                            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">
                              
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-bar-chart fa-lg"></i>
                                        <h2>Daily Biometric calls (last 7 days)</h2>
                                    </div>
                                    <div class="card-content">
                                        <canvas id="lineChart" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- ./chart -->
                            <!-- Calender -->
                            <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-bar-chart fa-lg"></i>
                                        <h2>Monthly Biometric calls</h2>
                                    </div>
                                    <div class="card-content">
                                        <canvas id="bar" height="215"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- ./Calender -->
                               
                        </div>
                        <!-- ./row -->
                    </div>
                    <!-- ./cotainer -->
                </div>
                <!-- ./page-content -->
            </div>
            <!-- ./page-content-wrapper -->\



<script type="text/javascript">
   // DAILY Eroll IN graph
    var Enroll = <?=json_encode($GPenroll); ?>;
    var E_status = [];
   
        for(var mem in Enroll ) {
  if (Enroll.hasOwnProperty(mem)) {
    var Cah = Enroll [mem];
   
    E_status.push(Cah.status);
    

  }
}


</script>

<script type="text/javascript">
   // DAILY  graph
    var Iden = <?=json_encode($GPiden); ?>;
    var I_status = [];
      var date = [];
        for(var mem in Iden ) {
  if (Iden.hasOwnProperty(mem)) {
    var FB = Iden [mem];
     date.push(FB.date);
    I_status.push(FB.status);

  }
}

 
</script>

<script type="text/javascript">
   // monthly  graph IDEn
    var MIden = <?=json_encode($Miden); ?>;
    var M_status = [];
    var Mdate=[];
        for(var mem in MIden ) {
  if (MIden.hasOwnProperty(mem)) {
    var FB = MIden [mem];
    Mdate.push(FB.date);
    M_status.push(FB.status);
 }


}
</script>

<script type="text/javascript">
   // monthly  graph Enroll
    var MIenroll = <?=json_encode($Menroll); ?>;
    var MI_status = [];

        for(var mem in MIenroll ) {
  if (MIenroll.hasOwnProperty(mem)) {
    var FB = MIenroll [mem];

    MI_status.push(FB.status);
 }


}
</script>
            <?php include("include/footer.php") ?>