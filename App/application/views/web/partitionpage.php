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
                            <h1> Create Partition</h1>
                            <small> Create Partition features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

<!-- Modal2 -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
         <code> <h4 class="modal-title">Create Partition</h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
                            
                                
                        
                                        <div class="row">
                                            <form class="col s12 m-t-20 1">
                                               <div class="col-md-12">
                                                <div class="input-field form-input col s6">
                                                    <input type="hidden" class="validate" ng-model="id"  >
                                                    <select class="form-control form_k" id="guest" name="task"   ng-model="task">
                                                        <option value="" selected>SELECT CALL</option>
                                                        
                                                        <option value="enrollment" selected>Enrollment</option>
                                                        <option value="identification" selected>Identification</option>
                                                        <option value="verification" selected>Verification</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="input-field form-input col s6">
                                                   
                                                    <select class="form-control form_k" id="room" name="trait"  ng-model="trait">
                                                       <option value="" selected>SELECT TRAIT</option>
                                                        
                                                        <option value="Face" selected>Face</option>
                                                        <!-- <option value="Face,periocular" selected>Face,periocular</option> -->
                                                       
                                                    </select>
                                                </div>
                                               </div>
                                            <div class="col-md-12">     
                                            <div class="input-field form-input col s6">
                                                    <input type="text" class="validate" ng-model="AppID"  placeholder="App UserID" readonly>
                                                    <label>App UserID</label>
                                                  </div>
                                                 <div class="input-field form-input col s6">
                                                  <input type="text" class="validate" ng-model="AppKey" placeholder="App PassKey" readonly >
                                                    <label>App PassKey</label>
                                                   
                                                </div>
                                              </div>
                                               <div class="col-md-12">
                                                
                                                  
                                                  <div class="input-field form-input col s6">
                                                    
                                                    <input type="text" class="validate" ng-model="partition"  ng-pattern="/^\d+$/" placeholder="Partition">
                                                    <label>Partition</label>
                                                  </div>
                                                  <div class="input-field form-input col s6">
                                                    <input type="text" class="validate" ng-model="rr"  ng-pattern="/^\d+$/" placeholder="No of Capture">
                                                    <label>No of Capture </label>
                                                  </div>
                                                    
                                               
                                                
                                                 
                                              </div>
                                              
                                             
                                               <div class="input-field form-input col s12">
                                              <code><button type="submit"  ng-model="CheckName" name="btnName" class="btn btn-success" ng-click="PartIN()">{{btnName}}</button></code>
                                            </div>
                                              </form>
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
                                                    
                                                    <button class="waves-effect waves-light btn m-b-10 m-t-5" data-toggle="modal" data-target="#myModal">Create Partition</button>
                                                    

                                                    <input type="text" placeholder="Quick  Search.." ng-model="userSearch">
                                                </div>

                                            </span>
                                    </div>
                                          <div class="card-header" align="left">
                                    <div class=" col s1">
                                
                                       <select  class="form-control form_k waves-effect waves-light"   ng-model="pageSize" ng-init="pageSize ='20'" ng-options="num for num in [20, 50, 100,500]" ></select>              
                                    </div>
                                        <a class="waves-effect waves-light btn red " onclick="exportExcel()" >Excel</a>
                                        
                                    </div>
                                    <div class="card-content">
                                        <div class="">
                                         <code>   <table  id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       <th>INSTITUTION</th>
                                                        <th>API ID</th>
                                                        <th>API-KEY</th>
                                                        <th> APP USERID</th>
                                                        <th> APP PASSKEY</th>
                                                          <th>PARTITION</th>
                                                          <!-- <th>TRAIT</th> -->
                                                          <th>TASK</th>
                                                         <th>STATUS</th>
                                                      <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:pageSize">
                                                    <tr>
                                                        
                                                         <td> <span class="label label-danger" ng-show="{{x.store_name==null }}">No Institution </span>
                                                            <span class="" ng-show="{{x.store_name!=nul}}">{{x.store_name}}</span></td>
                                                       <td>{{x.KeyID | uppercase}} </td>
                                                        <td>{{x.key | uppercase}} </td>
                                                        <td>{{x.AppID | uppercase}} </td>
                                                        <td>{{x.AppKey | uppercase}} </td>
                                                         <td>{{x.partition | uppercase}} </td>
                                                          <!-- <td>{{x.trait | uppercase}} </td> -->
                                                           <td>{{x.task | uppercase}} </td>
                                                          <td>
                                                              <span class="label label-danger" ng-show="{{x.all_access==0}}">Not Active </span>
                                                               <span class="label label-success" ng-show="{{x.all_access==1}}">Active </span>
                                                            </td>
                                                          <td>
                                                                   <!--tasks-->
                        <div class="list-details dropdown">
                          <button type = "button" class = "btn btn-warning dropdown-toggle btn-sm" data-toggle = "dropdown">
                                                              Action
                                                              <span class = "caret"></span>
                                                           </button>
                            <ul class="dropdown-menu dropdown-message mCustomScrollbar animated bounceIn" data-mcs-theme="minimal" >
                             <li><a class="purple-text" ng-click="update_data2(x.key)" data-toggle="modal" data-target="#myModal2">Add  To Institution</a></li>


                        
                         <li> <a href="#" class="indigo-text"  data-placement="left" title="Update" data-toggle="modal" data-target="#myModal" ng-click="update_data(x.id,x.task, x.trait, x.AppID,x.AppKey,x.partition,x.recordings)">Edit Partition</a></li>

                         <li><a href="#" class="red-text" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="delete_data(x.key)">Delete Partition</a></li>

                         <li>
                         <a href="#" class="green-text"  ng-click="active_data(x.key)" ng-show="{{x.all_access==0}}">Activate</a>
                           <a href="#" class="pink-text"  ng-click="Dactive_data(x.key)" ng-show="{{x.all_access==1}}">Deactivate</a></li>
                               
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
                            
   
        <!-- Modal2 -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-sm"">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
         <code> <h4 class="modal-title"> Add Institution Partition</h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
                            
                                <div class="input-field form-input col s6">
                                  <input type="hidden"  ng-model="key" style="font-size: 13px;">
                                                     <input type="text" placeholder="key" ng-model="key" style="font-size: 13px;" readonly>
                                                    <label>Key</label>
                                                </div>
                        
                                              <div class="input-field form-input col s6">
                                                
                                                    <select class="form-control form_k"   ng-model="store_vid"  onchange="myFunction()" >
                                                        <option value="" selected>SELECT  INSTITUTION</option>
                                                        <option value="{{y.store_vid}}" ng-repeat="y in myPData|orderBy:sortKey:reverse" >{{y.store_name}}  [{{y.store_vid}}]</option>
                                                        
                                                    </select>
                                                </div>
                                             
                                               
                                            
                                         
                                               <div class="input-field form-input col s12">
                                              <code><button type="submit"  ng-model="CheckName" name="btnName" class="btn btn-success" ng-click="STIN()">ADD</button></code>
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
 $scope.btnName = "Create Partition"; 
 $scope.AppID1=Math.random().toString(36).replace('0.', ''); 
 $scope.AppID2=Math.floor((Math.random() * 600666666) + 1); 
$scope.AppID=$scope.AppID1+"-"+$scope.AppID2;
$scope.AppKey=$scope.AppID1+".AWS";
$scope.show_data = function() {
$http.get("<?=base_url()?>User/getPat")
            .then(function (response) {
               $scope.myUserData = response.data; //data call

            });
             $http.get("<?=base_url()?>settingpage/get_MyCompany")
            .then(function (response) {
               $scope.myPData = response.data; //data call

            });

 
     }      


//insert 





  $scope.PartIN = function() {
       
        if ($scope.task == null)  {
            alert("Task is required");
        } else if($scope.trait==null){

          alert("Trait is required");
        }else if($scope.AppID==null){
        alert("App ID is required");
        }

        else if($scope.AppKey == null) {
            alert("App Key is required");
        }
        else if($scope.partition == null) {
            alert("Partition is required");
        }
        else if($scope.rr == null) {
            alert("No of Capture is required");
        }
         else if($scope.rr > 3) {
            alert("No of Captures  can not be greater than 3");
        }
         else
        {
 if (confirm("Are you sure you want to perform this action?")) {
            $http.post(
                "<?=base_url()?>User/Create_P", {
                    'id':$scope.id,
                    'task': $scope.task,
                    'trait':$scope.trait,
                    'AppID':$scope.AppID,
                    'AppKey':$scope.AppKey,
                    'partition':$scope.partition,
                    'rr':$scope.rr,
                    'btnName': $scope.btnName,
                    
                    
                }
            ).then(function(response) {
                 alert(response.data);
                 $scope.task = null;
                 $scope.trait = null;
                 $scope.AppID = null;
                 $scope.AppKey= null;
                 $scope.partition= null;
                $scope.rr= null;
                $scope.btnName = "Create Partition"; 
              
                
                $scope.show_data();
            });

 } else {
            return false;
        }
        }
        
    }


$scope.update_data = function(id,task, trait, AppID,AppKey,partition,rr) {
        $scope.id = id;
        $scope.task = task;
        $scope.trait = trait;
        $scope.AppID = AppID;
         $scope.AppKey= AppKey;
           $scope.partition= partition;
             $scope.rr= rr;
        $scope.btnName = "Update";
    }
    $scope.update_data2 = function(key) {
        $scope.key = key;
        
    }

    //alert Database
    $scope.delete_data = function(key) {
        if (confirm("Are you sure you want to delete this record?")) {
              $http.post("<?=base_url()?>User/key_Delete", {
                    'key': key
                })
                .then(function (response) {
                    alert(response.data);
                    $scope.show_data();
                });
        } else {
            return false;
        }
    }

    //alert Database
    $scope.active_data = function(key) {
        if (confirm("Are you sure you want to perform this action?")) {
              $http.post("<?=base_url()?>User/Approve_key", {
                    'key': key
                })
                .then(function (response) {
                    alert(response.data);
                    $scope.show_data();
                });
        } else {
            return false;
        }
    }

        //alert Database
    $scope.Dactive_data = function(key) {
        if (confirm("Are you sure you want to perform this action?")) {
              $http.post("<?=base_url()?>User/DApprove_key", {
                    'key': key
                })
                .then(function (response) {
                    alert(response.data);
                    $scope.show_data();
                });
        } else {
            return false;
        }
    }



$scope.STIN = function() {
      
         if ($scope.store_vid==null) {
          alert("Select Institution")
    
        }else if (confirm("Are you sure you want to perform this action?")) {
            $http.post(
                "<?=base_url()?>User/Inst_key_Ass", {
             
                  'store_vid':$scope.store_vid,
                  'key':$scope.key,  
                    
                }
            ).then(function(response) {
                 alert(response.data);

                $scope.key = null;
                $scope.store_vid=null
             
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
               
            
           