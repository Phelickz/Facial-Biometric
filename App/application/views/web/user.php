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
                            <h1> User</h1>
                            <small> Create User</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Homepage">Dashboard</a></li>
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
                                        <h2>Create User</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                    <form class="col s12 m-t-20" method="post" action="<?=base_url()?>/Homepage/Create_User">
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
                                               
                                                
                                                <div class="input-field form-input col s6">
                                                    <i class="material-icons prefix">account_circle</i>
                                                    <input type="text" class="validate" name="fname" required>
                                                    <label>First Name</label>
                                                </div>
												 <div class="input-field form-input col s6">
                                                    <i class="material-icons prefix">account_circle</i>
                                                    <input type="text" class="validate" name="lname" required>
                                                    <label>Last Name</label>
                                                </div>

                                                <div class="input-field form-input col s6">
                                                    <i class="material-icons prefix">phone</i>
                                                    <input type="text" class="validate" name="phone" required>
                                                    <label>Phone</label>
                                                </div>
                                                <div class="input-field form-input col s6">
                                                    <i class="material-icons prefix">email</i>
                                                    <input type="email" class="validate" name="email" required>
                                                    <label>email</label>
                                                </div>
                                               
                                               

                                                <button type="submit" class="btn btn-success">Create<span class="glyphicon glyphicon-send"></span></butto>
                                                
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ./basic forms --> 






                            <!-- bootstrap table -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-table fa-lg"></i>
                                        <h2>User</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                         <code>   <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                       
                                                        <th>Name </th>
                                                        <th>Phone</th>
                                                        <th> Email</th>
                                                         <th> Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody dir-paginate="x in myUserData|orderBy:sortKey:reverse|filter:userSearch|itemsPerPage:20">
                                                    <tr>
                                                       <td>{{x.first_name}}  {{x.last_name}}</td>
                                                        <td>{{x.phone}}</td>
                                               <td>{{x.email}} </td>
                                                
                                                    <td>{{x.status}}</td> 
                                                        
                                                        <td><span class="btn-sm  btn-success" ng-show="{{x.status==1}}">Active</span>
                                                       <span class="btn-sm  btn-danger" ng-show="{{x.status==0}}">Not Active</span>
                                                        </td>
                                                        <td>
                                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="left" title="Use as Contact" ng-click="update_data(x.id)">ADD</button>
                                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="delete_data(x.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
     $scope.show_data = function() {
$http.get("<?=base_url()?>Homepage/get_User")
            .then(function (response) {
               $scope.myUserData = response.data; //data call
            });
     }      


//Upadte Database
    $scope.update_data = function(id) {
       if (confirm("Are you sure you want to Activate User?")) {
            $http.post("<?=base_url()?>Homepage/Users_Update", {
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
    //alert Database
    $scope.delete_data = function(id) {
        if (confirm("Are you sure you want to Delete Contact?")) {
              $http.post("<?=base_url()?>Homepage/Users_Delete", {
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