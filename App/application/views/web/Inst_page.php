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
                            <h1> Institution  Setting</h1>
                            <small> Institution  features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
         <code> <h4 class="modal-title">{{btnName}} Institution </h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
                            
                        
                                        <div class="row">
                                            <form class="col s12 m-t-20">
                                    
                                              <div class="col-md-12">
                                                <div class="input-field form-input col s6">
                                                   <input id="icon_prefix" type="hidden" class="validate" ng-model="in_store_id" required>
                                                    <input type="text" class="validate" ng-model="store_name" placeholder="Company Name" required>
                                                    <label>Company Name</label>
                                                </div>
                                                <div class="input-field form-input col s6">
                                                  
                                                    <input type="text" class="validate" ng-model="address" placeholder="Address Line" required>
                                                    <label>Address Line </label>
                                                </div>
                                                
                                              </div>
                                              <div class="col-md-12">
                                                <div class="input-field form-input col s6">
                                                   
                                                    <input id="icon_telephone" type="tel" class="validate" ng-model="in_phone" placeholder="Telephone" required>
                                                    <label for="icon_telephone">Telephone</label>
                                                </div>
                                                <div class="input-field form-input col s6">
                                                    
                                                    <input type="text" id="autocomplete-input" class="validate" ng-model="in_email" placeholder="Email">
                                                    <label for="autocomplete-input">Email</label>
                                                </div>
                                              </div>

                                                 <code><button type="submit"  ng-model="btnName" name="btnName" class="btn btn-success" ng-click="insert()">{{btnName}}</button></code>
                                          
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
                    <div class="container-fluid">
                        <div class="row">
                   <!-- bootstrap table -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <?php
                 if(isset($_SESSION['error'])){
                echo '<center><div  class="alert alert-danger alert-dismissable fade in z-depth-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 '.$this->session->flashdata('error').'</div></center>'; 
                 }
                                ?> 
                                <div class="card">
                                     <div class="card-header">
                                         <span class="html" >
                                                <div class="ui">
                                                    
                                                    <button class="waves-effect waves-light btn m-b-10 m-t-5" data-toggle="modal" data-target="#myModal">Create Institution</button>
                                                    

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
                                         <code>   <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       
                                                       
                                                        <th>COMPANY NAME</th>
                                                        <th> PHONE</th>
                                                        
                                                        <th>EMAIL</th>
                                                        
                                                        <th>ADDRESS </th>
                                                       
                                                        <th>ACTION </th>
                                                       
                                                    
                                                    </tr>
                                                </thead>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:20">
                                                    <tr>
                                                
                                                        <td>{{x.store_name}} </td>
                                                         <td>{{x.in_phone}} </td>
                                                         <td>{{x.in_email}} </td>
                                                         <td>{{x.address}} </td>
                                              
                                                                 <td>
                                                                   <!--tasks-->
                        <div class="list-details dropdown">
                          <button type = "button" class = "btn btn-warning dropdown-toggle btn-sm" data-toggle = "dropdown">
                                                              Action
                                                              <span class = "caret"></span>
                                                           </button>
                            <ul class="dropdown-menu dropdown-message mCustomScrollbar animated bounceIn" data-mcs-theme="minimal" >
                           


                         <li><a href="<?=base_url()?>Homepage/Navg/{{x.store_vid}}" class="teal-text" onclick="return confirm('You are about to  Navigate to another Institution ARE YOU SURE ?')">Enter Institution</a></li>

                         <li> <a href="#" class="indigo-text"  data-placement="left" title="Update" data-toggle="modal" data-target="#myModal" ng-click="update_data(x.in_store_id,x.store_name, x.in_phone, x.in_email,x.address)">Edit Institution </a></li>

                         <li><a href="#" class="red-text" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="delete_data(x.in_store_id)">Delete Institution </a></li>

                       
                               
                            </ul>
                        </div>
                        <!-- /.tasks -->
                                                            
                                                         </td>


                                                    
                                                    
                                                          
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
     $scope.show_data = function() {
$http.get("<?=base_url()?>settingpage/get_MyCompany")
            .then(function (response) {
               $scope.myUserData = response.data; //data call

            });

            $http.get("<?=base_url()?>User/getUser")
            .then(function (response) {
               $scope.myPData = response.data; //data call

            });
     }  
     

//insert 

    $scope.insert = function() {
        if ($scope.store_name == null)  {
            alert("Enter  Company Name");
        } else if($scope.address == null) {
          alert("Enter Address")
        }else
 if (confirm("Are you sure you want to perform this action?")) {
            $http.post(
                "<?=base_url()?>settingpage/compProfile", {
                    'in_store_id':$scope.in_store_id,
                    'store_name': $scope.store_name,
                    'in_phone': $scope.in_phone,
                    'in_email':$scope.in_email,
                    'address':$scope.address,
                  
                    'btnName': $scope.btnName,
                    
                    
                }
            ).then(function(response) {
                 alert(response.data);
                 $scope.store_name = null;
                 $scope.in_phone = null;
                 $scope.in_email = null;
                 $scope.address = null; 
                $scope.btnName = "Add";
                $scope.in_store_id=null;
                $scope.show_data();
            });

 } else {
            return false;
        }
        }
        


//Upadte Database

  $scope.update_data = function(in_store_id,store_name, in_phone,in_email,address) {
     
                 $scope.in_store_id = in_store_id;
                 $scope.store_name = store_name;
                 $scope.in_phone= in_phone;
                 $scope.in_email = in_email;
                   $scope.address = address;
                 
                  $scope.btnName = "Update";
    }

    //alert Database
    $scope.delete_data = function(in_store_id) {
        if (confirm("Are you sure you want to delete this record?")) {
              $http.post("<?=base_url()?>settingpage/store_Delete", {
                    'in_store_id': in_store_id
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

       
            <?php include("include/footer.php") ?>