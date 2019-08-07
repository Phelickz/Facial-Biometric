<?php include("include/header.php") ?>
<?php include("include/nav-header.php") ?>
<?php include("include/nav-bar.php") ?>
<style type="text/css">

    #lightbox .modal-content {
    display: inline-block;
    text-align: center;   
}

#lightbox .close {
    opacity: 1;
    color: rgb(255, 255, 255);
    background-color: rgb(25, 25, 25);
    padding: 5px 8px;
    border-radius: 30px;
    border: 2px solid rgb(255, 255, 255);
    position: absolute;
    top: -15px;
    right: -55px;
    
    z-index:1032;
}
</style>
<?php 

 foreach ($dataDD as $key) {
         $clasID= $key["r_classID"];
         $Score= $key["Score"];
         $class= $key["classID"];
          $KeyID = $key["KeyID"];
         $date_log= $key["date_log"];
        }
     
     $ScoreDD=preg_split ("/\,/",$Score);
     $classDD = preg_split ("/\,/", $clasID); 

$d=strtotime($date_log);



?>
<!-- Page content -->
            <div id="page-content-wrapper"  ng-app="myStock" ng-controller="StockCtrl" ng-init="show_data()">


                <div class="page-content">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="header-icon">
                            <i class="fa fa-id-badge"></i>
                        </div>
                        <div class="header-title">
                            <h1> BIOMETRIC PHOTOS</h1>
                            <small>BIOMETRIC PHOTOS features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Report/BioLog">Bio Log</a></li>
                            </ul>
                        </div>
                    </section>


<!-- page section -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="mail-box">
                                <aside class="sm-side hidden-xs">
                                    <div class="user-head" style="background-color: #ffffff">
                                        
                                           <!-- <img class="thumbnail" src='<?=base_url()?>/assets/enroll/Api_pull/<?=$KeyID.$class?>.png' alt='".<?=$KeyID.$class?>."' width="240" height="300" /> -->
                                      <img class="thumbnail" src='https://aws.appmartgroup.com/upload/<?=$this->session->userdata("partition_id").$class?>1.png' alt='".<?=$KeyID.$class?>."' width="240" height="300" />
                                      
                                        
                                    </div>
                                    <div class="inbox-body">
                                        <center><a href="" class="indigo-text" >
                                           <?=$KeyID.$class?>
                                        </a></center>
                                 
                                        <a href="" class="btn btn-compose">
                                           <?=date("Y-m-d h:i:sa", $d);?>
                                        </a>
                                    </div>
                                 
                                        
                                  
                                    
                                </aside>
                                <aside class="lg-side">
                                    <div class="inbox-head">
                                        <h3>BIOMETRIC MATCH RECORD </h3>
                                        <form action="#" class="pull-right position">
                                            <div class="input-append">
                                                <input type="text" class="sr-input" placeholder="Search Mail">

                                            </div>
                                        </form>
                                    </div>

                                    <div class="inbox-body">
                                       <div class="col-md-6">
                                        <table class="table table-bordered table-hover table-responsive">
                                            <tbody>

                                              <?php $i=1; foreach (array_unique($classDD) as $KeyClass):?>
                                                <tr class="unread" id="tabl">
                                                <td>
                                                        <?=$i++?>
                                                        <label for="test1"></label>
                                                    </td>
                            <td class="view-message"> <a href="#" class="tb" data-toggle="modal" data-target="#lightbox"> 
           <img src='https://aws.appmartgroup.com/upload/<?=$this->session->userdata("partition_id").$KeyClass?>1.png' data-lightbox="example-1" alt="NO IMAGE" width="100" height="80" >
        </a>
        <?=$KeyID.$KeyClass?> 
            <!--light  box-->
            <div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="" />
            </div>
        </div>
    </div>
</div>


    </td>
                                                    
                                                </tr> 
                                              <?php endforeach;?>

                                            </tbody>
                                        </table>
                                        </div>
                                        <!--score-->
                                        <div class="col-md-6">
                                        <table class="table table-bordered table-hover table-responsive">
                                            <tbody>
                                              <?php $i=1; foreach (array_unique($ScoreDD) as $KeyScore):?>
                                                <tr class="unread" id="tabl">
                                                  <td>
                                                        <?=$i++?>
                                                        <label for="test1"></label>
                                                    </td>
                                                    <td class="view-message" ><?=$KeyScore?></td>
                                                    
                                                </tr> 
                                              <?php endforeach;?>

                                            </tbody>
                                        </table>
                                        </div>


                                    </div>
                                </aside>
                            </div>

                        </div>
                        <!-- ./row -->
                    </div>
                    <!-- ./cotainer -->
                </div>
                <!-- ./page-content -->
            </div>
            <!-- ./page-content-wrapper -->
        </div>
        <!-- ./page-wrapper -->
<script type="text/javascript">
    $(document).ready(function() {
    var $lightbox = $('#lightbox');
    
    $('[data-target="#lightbox"]').on('click', function(event) {
        var $img = $(this).find('img'), 
            src = $img.attr('src'),
            alt = $img.attr('alt'),
            css = {
                'maxWidth': $(window).width() - 100,
                'maxHeight': $(window).height() - 100
            };
    
        $lightbox.find('.close').addClass('hidden');
        $lightbox.find('img').attr('src', src);
        $lightbox.find('img').attr('alt', alt);
        $lightbox.find('img').css(css);
    });
    
    $lightbox.on('shown.bs.modal', function (e) {
        var $img = $lightbox.find('img');
            
        $lightbox.find('.modal-dialog').css({'width': $img.width()});
        $lightbox.find('.close').removeClass('hidden');
    });
});

</script>
   
            <?php include("include/footer.php") ?>

               
            
           