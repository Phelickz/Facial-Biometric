<?php include("include/header.php") ?>
<?php include("include/nav-header.php") ?>
<?php include("include/nav-bar.php") ?>
<!-- Page content -->
            <div id="page-content-wrapper"  ng-app="myStock" ng-controller="StockCtrl" ng-init="show_data()">


                <div class="page-content">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="header-icon">
                            <i class="fa fa-id-badge"></i>
                        </div>
                        <div class="header-title">
                            <h1> API LOG</h1>
                            <small> API LOG features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>




                    <!-- page section -->
                    <div class="container-fluid"  >
                        <div class="row">
                   <!-- bootstrap table -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                         <span class="html" >
                                                <div class="ui">

                                                    <input type="text" placeholder="Quick  Search.." ng-model="userSearch">
                                                </div>

                                            </span>
                                    </div>
                                        <div class="card-header" align="left">
                                    <div class=" col s1">
                                
                                       <select  class="form-control form_k waves-effect waves-light"   ng-model="pageSize" ng-init="pageSize ='30'" ng-options="num for num in [20, 50, 100,500]" ></select>              
                                    </div>
                                        <a class="waves-effect waves-light btn red " onclick="exportExcel()" >Excel</a>
                                        
                                    </div>
                                    <div class="card-content">
                                        <div class="">
                                         <code>   <table  id="" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       <th>KEY</th>
                                                        <th>API URL</th>
                                                        <th>IP-ADDRESS</th>
                                                         
                                                            <th>RESPOND</th>
                                                            <th>ACTION</th>
                                                            
                                                    </tr>
                                                </thead>
                                                <center><div  style="font: 20px Helvetica, sans-serif; color: #DFAE59;">{{loading}}</div>
                                                  <div  ng-show="loader==5"><img src="<?= base_url() ?>assets/web/img/30.gif" ></div></center>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:pageSize">
                                                    <tr>
                                                       <td>{{x.api_key | uppercase}} </td>
                                                        <td>{{x.uri | uppercase}} </td>
                                                        <td>{{x.ip_address | uppercase}} </td>
                                                         <td>
                                                              <span class="label label-danger" ng-show="{{x.response_code !=0}}"> {{x.response_code | uppercase}} </span>
                                                               <span class="label label-success" ng-show="{{x.response_code==0}}">200  </span>
                                                            </td>
                                                       
                                                          

                                                            

                                                           <td>
                                                                   <!--tasks-->
                        <div class="list-details dropdown">
                          <button type = "button" class = "btn btn-warning dropdown-toggle btn-sm" data-toggle = "dropdown">
                                                              Action
                                                              <span class = "caret"></span>
                                                           </button>
                            <ul class="dropdown-menu dropdown-message mCustomScrollbar animated bounceIn" data-mcs-theme="minimal" >
                             
                                
                         <li><a href="#" class="red-text" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="delete_data(x.id)">Delete Log</a></li>

                         
                               
                            </ul>
                        </div>
                        <!-- /.tasks -->
                                                            
                                                         </td>


                                                         
                                                           


                                                   
                                                    </tr>
                                                    
                                                </tbody>
                                            </table></code>

                                            <!--Pagination --->
                                <dir-pagination-controls
                                    max-size="20"
                                    direction-links="true"
                                    boundary-links="true" >
                                </dir-pagination-controls>
                                <!--Pagination --->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./bootstrap table -->

          

 

                            
                        </div>
                        <!-- ./row -->
                    </div>
                    <!-- ./cotainer -->
                   
                            
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
    
    var Stock = angular.module('myStock', ['angularUtils.directives.dirPagination']);
    ////// STOCK QUERY DETAILS///////////
Stock.controller("StockCtrl", function($scope, $http) {
 $scope.btnName = "Add";  
  $scope.status=1; 
 $scope.loader=5;
 $scope.loading="PLEASE WAIT WHILE DATA IS LOADING";    
$scope.show_data = function() {
$http.get("<?=base_url()?>Report/getApiLog")
            .then(function (response) {
                 $scope.loader=null;
              $scope.loading=null;
               $scope.myUserData = response.data; //data call

            });

 
     }      

    //alert Database
    $scope.delete_data = function(id) {
        if (confirm("Are you sure you want to delete this record?")) {
              $http.post("<?=base_url()?>Report/Log_Delete", {
                    'id': id
                })
                .then(function (response) {
                    alert(response.data);
                    $scope.show_data();
                });
        } else {
            return false;
        }
    }


 }); 
 </script>





 <script>
    
    
 </script>

   
            <?php include("include/footer.php") ?>
               
            
           