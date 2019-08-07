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
                            <h1> Create User</h1>
                            <small> Create User features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

<!-- Modal2 -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm"">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
         <code> <h4 class="modal-title"> {{btnName}} User</h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
                            
                                
                        
                                              <p id="alertmsg" style="color: red; font-weight: bold; text-align: center;"></p>
                                                 <input type="hidden"  ng-model="personal_info_id" style="font-size: 13px;">
                                               
                                                <div class="input-field form-input col s6">
                                                     <input type="text" placeholder="Full Name" ng-model="name" style="font-size: 13px;">
                                                    <label>Full Name</label>
                                                </div>
                                                
                                              <div class="input-field form-input col s6">
                                                     <input type="email" placeholder="Email" ng-model="email" style="font-size: 13px;">
                                                    <label>Email</label>
                                                </div>
                                             <div class="input-field form-input col s6">
                                                     <input type="text" placeholder="Phone" ng-model="phone" style="font-size: 13px;">
                                                    <label>Phone</label>
                                                </div>
                                            
                                            <div class="input-field form-input col s6">
                                                     <input type="text" placeholder="*******" ng-model="password" style="font-size: 13px;" >
                                                    <label>Password</label>
                                                </div>
                                                
                                             
                                               
                                            
                                         
                                               <div class="input-field form-input col s12">
                                              <code><button type="submit"  ng-model="CheckName" name="btnName" class="btn btn-success" ng-click="UserIN()">{{btnName}}</button></code>
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
                                                    
                                                    <button class="waves-effect waves-light btn m-b-10 m-t-5" data-toggle="modal" data-target="#myModal" ng-click="new()">Create User</button>
                                                    

                                                    <input type="text" placeholder="Quick  Search.." ng-model="userSearch">
                                                </div>

                                            </span>
                                    </div>
                                    <div class="card-header" align="left">
                                        <i class="fa fa-table fa-lg"></i>
                                        <h2>Report table</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="">
                                         <code>   <table  id="" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       
                                                        <th>NAME</th>
                                                        <th>EMAIL</th>
                                                        <th> PHONE</th>
                                                          <th>INSTITUTION</th>
                                                            <th>STATUS</th>
                                                            <th>ACTION</th>
                                                            
                                                    </tr>
                                                </thead>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:20">
                                                    <tr>
                                                       <td>{{x.name | uppercase}} </td>
                                                        <td>{{x.email | uppercase}} </td>
                                                        <td>{{x.phone | uppercase}} </td>
                                                          <td> <span class="label label-danger" ng-show="{{x.store_name==null }}">No Institution </span>
                                                            <span class="" ng-show="{{x.store_name!=nul}}">{{x.store_name}}</span></td>

                                                            <td>
                                                              <span class="label label-danger" ng-show="{{x.active==0 }}">Not Active </span>
                                                               <span class="label label-success" ng-show="{{x.active==1 }}">Active </span>
                                                            </td>

                                                           <td>
                                                                   <!--tasks-->
                        <div class="list-details dropdown">
                          <button type = "button" class = "btn btn-warning dropdown-toggle btn-sm" data-toggle = "dropdown">
                                                              Action
                                                              <span class = "caret"></span>
                                                           </button>
                            <ul class="dropdown-menu dropdown-message mCustomScrollbar animated bounceIn" data-mcs-theme="minimal" >
                             <li><a class="purple-text" ng-click="update_data(x.personal_info_id,x.name, x.email, x.phone,'null')" data-toggle="modal" data-target="#myModal2">Add  To Institution</a></li>


                         <li><a href="<?=base_url()?>User/staffMenu/{{x.personal_info_id}}" class="teal-text">View Menu</a></li>

                         <li> <a href="#" class="indigo-text"  data-placement="left" title="Update" data-toggle="modal" data-target="#myModal" ng-click="update_data(x.personal_info_id,x.name, x.email, x.phone,'null')">Edit User</a></li>

                         <li><a href="#" class="red-text" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="delete_data(x.personal_info_id)">Delete User</a></li>

                         <li>
                         <a href="#" class="green-text"  ng-click="active_data(x.personal_info_id)" ng-show="{{x.active==0}}">Activate</a>
                           <a href="#" class="pink-text"  ng-click="Dactive_data(x.personal_info_id)" ng-show="{{x.active==1}}">Deactivate</a></li>
                               
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
         <code> <h4 class="modal-title"> Add Institution User</h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
                            
                                <div class="input-field form-input col s6">
                                  <input type="hidden"  ng-model="personal_info_id" style="font-size: 13px;">
                                                     <input type="text" placeholder="Full Name" ng-model="name" style="font-size: 13px;" readonly>
                                                    <label>Full Name</label>
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
 $scope.btnName = "Add";     
$scope.show_data = function() {
$http.get("<?=base_url()?>User/getUser")
            .then(function (response) {
               $scope.myUserData = response.data; //data call

            });
            $http.get("<?=base_url()?>settingpage/get_MyCompany")
            .then(function (response) {
               $scope.myPData = response.data; //data call

            });

 
     }      


//insert 
 $scope.UserIN = function() {
       
        if ($scope.name == null)  {
            alert("Full name is required");
        } else if($scope.email==null){

          alert("Email is required");
        }else if($scope.password==null){
        alert("Password is required");
        }

        else if($scope.phone == null) {
            alert("Phone is required");
        }
         else
        {
 if (confirm("Are you sure you want to perform this action?")) {
            $http.post(
                "<?=base_url()?>User/Create_User", {
                    'personal_info_id':$scope.personal_info_id,
                    'name': $scope.name,
                    'phone':$scope.phone,
                    'email':$scope.email,
                    'password':$scope.password,
                    'btnName': $scope.btnName,
                    
                    
                }
            ).then(function(response) {
                 alert(response.data);
                 $scope.name = null;
                 $scope.phone = null;
                 $scope.email = null;
                 $scope.password= null;
                $scope.btnName = "Add";
              
                
                $scope.show_data();
            });

 } else {
            return false;
        }
        }
        
    }



$scope.update_data = function(personal_info_id,name, email, phone,password) {
        $scope.personal_info_id = personal_info_id;
        $scope.name = name;
        $scope.email = email;
        $scope.phone = phone;
         $scope.password= password;
        $scope.btnName = "Update";
    }

//new
$scope.new=function(){
  $scope.name = null;
                 $scope.phone = null;
                 $scope.email = null;
                 $scope.password= null;
                $scope.btnName = "Add";
}
    //alert Database
    $scope.delete_data = function(personal_info_id) {
        if (confirm("Are you sure you want to delete this record?")) {
              $http.post("<?=base_url()?>User/user_Delete", {
                    'personal_info_id': personal_info_id
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
    $scope.active_data = function(personal_info_id) {
        if (confirm("Are you sure you want to perform this action?")) {
              $http.post("<?=base_url()?>User/Approve_User", {
                    'personal_info_id': personal_info_id
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
    $scope.Dactive_data = function(personal_info_id) {
        if (confirm("Are you sure you want to perform this action?")) {
              $http.post("<?=base_url()?>User/D_Approve_User", {
                    'personal_info_id': personal_info_id
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
                "<?=base_url()?>User/Inst_Ass", {
             
                  'store_vid':$scope.store_vid,
                  'personal_info_id':$scope.personal_info_id,  
                    
                }
            ).then(function(response) {
                 alert(response.data);

                $scope.personal_info_id = null;
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
               
            
           