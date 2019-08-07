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
                            <h1> BIOMETRIC LOG</h1>
                            <small>BIOMETRIC LOG features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

<!-- Modal2 -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
         <code> <h4 class="modal-title">Log Details</h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
  <div class="row">
    
      
<table  id="" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       <th>IMAGE ID <span style="color:#FF5B33">{{KeyID}}{{classID}}</span></th>
                                                        <th>DATE</th>
                                                        
                                                    </tr>
                                                </thead >
                                                
                                    <td><img src="<?=base_url()?>/assets/enroll/Api_pull/{{KeyID}}{{classID}}.png" alt="{{KeyID}}{{classID}}" width="240" height="280" /></td>
                                                  <td>{{date_log}} </td>
                                                </tbody>
                                              </table>



 </div>
                             
                            <!-- ./basic forms --> 

        </div>
        <div class="modal-footer">
           
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button></code>
         
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->


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
                                    <div class=" col s2">
                                
                                       <select  class="form-control form_k waves-effect waves-light" ng-model="status" ng-change="show_data()">
                                         <option value="1">Enroll</option>
                                         <option value="0">Identify</option>
                                       </select>              
                                    </div>
                                        <a class="waves-effect waves-light btn red " onclick="exportExcel()" >Excel</a>
                                        
                                    </div>
                                    <div class="card-content">
                                      
                                        <div class="">
                                         <code>   <table  id="" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       <th>KEYID</th>
                                                        <th>IMAGE ID</th>
                                                        <th>TYPE</th>
                                                         
                                                            <th>DATE</th>
                                                            <th>ACTION</th>
                                                            
                                                    </tr>
                                                </thead>
                                                <center><div  style="font: 20px Helvetica, sans-serif; color: #DFAE59;">{{loading}}</div>
                                                  <div  ng-show="loader==5"><img src="<?= base_url() ?>assets/web/img/30.gif" ></div></center>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:pageSize">
                                                    <tr>
                                                       <td>{{x.KeyID | uppercase}} </td>
                                                        <td>{{x.KeyID | uppercase}}{{x.classID | uppercase}} </td>
                                                        
                                                         <td>
                                                              <span class="label label-danger" ng-show="{{x.status==0}}"> Identify</span>
                                                               <span class="label label-success" ng-show="{{x.status==1}}">Enroll</span>
                                                            </td>
                                                       <td>{{x.date_log | uppercase}} </td>
                                                          

                                                            

                                                           <td>
                                                                   <!--tasks-->
                        <div class="list-details dropdown">
                          <button type = "button" class = "btn btn-warning dropdown-toggle btn-sm" data-toggle = "dropdown">
                                                              Action
                                                              <span class = "caret"></span>
                                                           </button>
                            <ul class="dropdown-menu dropdown-message mCustomScrollbar animated bounceIn" data-mcs-theme="minimal" >
                             
                          <li><a class="purple-text" ng-click="update_data(x.classID,x.KeyID, x.r_classID,x.date_log)" data-toggle="modal" data-target="#myModal">View Log</a></li>
                          <li><a href="<?=base_url()?>/Report/DBioLog/{{x.Score_id}}"  class="indigo-text" target="_blank" >View Log Details</a></li>
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
  $scope.loader=5;
  $scope.loading="PLEASE WAIT WHILE DATA IS LOADING";  
$http.post("<?=base_url()?>Report/getBioLog",{
   'status':$scope.status,
})
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


$scope.update_data = function(classID,KeyID, r_classID,date_log) {
        $scope.classID  = classID ;
        $scope.KeyID = KeyID;
        $scope.r_classID = r_classID;
        $scope.date_log = date_log;
       
    }
    $scope.myFunc = function() {

        $scope.status;
      };

 }); 
 </script>





 <script>
    
    
 </script>

   
            <?php include("include/footer.php") ?>
               
            
           