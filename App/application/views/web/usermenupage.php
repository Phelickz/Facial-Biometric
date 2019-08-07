<?php include("include/header.php") ?>
<?php include("include/nav-header.php") ?>
<?php include("include/nav-bar.php") ?>
<!-- Page content -->
            <div id="page-content-wrapper"  ng-app="myStock" ng-controller="StockCtrl" ng-init="personal_info_id='<?=$this->uri->segment(3)?>'">


                <div class="page-content">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="header-icon">
                            <i class="fa fa-id-badge"></i>
                        </div>
                        <div class="header-title">
                            <h1>  User Menu</h1>
                            <small> User Menu features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>





                    <!-- page section -->
                    <div class="container-fluid" ng-init="show_data()" >
                        <div class="row">
                   <!-- bootstrap table -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                         <span class="html" >
                                                <div class="ui">
                                                 
                                                    <input type="hidden" name="" value="" ng-model="personal_info_id">
                                                </div>
                                                    <input type="text" placeholder="Quick  Search.." ng-model="userSearch">
                                                

                                            </span>
                                    </div>
                                    <div class="card-header" align="left">
                                        <i class="fa fa-table fa-lg"></i>
                                        <h2>Report table</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                        <code>   <table  id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                      
                                                        <th>SUB MENU TITLE</th>
                                                        
                                                            <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:10">
                                                    <tr>
                                                     
                                                       <td>{{x.submenu_name | uppercase}} </td>
                                                      <td> <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="Dactive_data(x.in_user_menu_id)">Remove Menu</button></td>
                                                         
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
 
$scope.show_data = function() {

 $http.post("<?=base_url()?>User/UserGetMenu", {
                    'personal_info_id': $scope.personal_info_id
                })
                .then(function (response) {
            $scope.myUserData = response.data; //data call
                });


 }  


//insert 


        //alert Database
    $scope.Dactive_data = function(in_user_menu_id) {
        if (confirm("Are you sure you want to perform this action?")) {
              $http.post("<?=base_url()?>User/MenuUser_Delete", {
                    'in_user_menu_id': in_user_menu_id
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
               
            
           