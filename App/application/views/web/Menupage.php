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
                            <h1> Manage Menu</h1>
                            <small> Manage features</small>
                            <ul class="link hidden-xs">
                                <li><a href=""><i class="fa fa-home"></i>Home</a></li>
                                <li><a href="<?=base_url()?>Dashboard">Dashboard</a></li>
                            </ul>
                        </div>
                    </section>

<!-- Modal2 -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm"">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
         <code> <h4 class="modal-title"> Add User Menu</h4></code>
        </div>
        <div class="modal-body">
          
           <!-- basic forms -->
                            
                                
                        
                                              <div class="input-field form-input col s6">
                                                
                                                    <select class="form-control form_k"   ng-model="personal_info_id"  onchange="myFunction()" >
                                                        <option value="" selected>SELECT USER</option>
                                                        <option value="{{y.personal_info_id}}" ng-repeat="y in myPData|orderBy:sortKey:reverse" >{{y.name}}  [{{y.email}}]</option>
                                                        
                                                    </select>
                                                </div>
                                             
                                               
                                            
                                         
                                               <div class="input-field form-input col s12">
                                              <code><button type="submit"  ng-model="CheckName" name="btnName" class="btn btn-success" ng-click="MenuIN()">{{btnName}}</button></code>
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
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                         <span class="html" >
                                                <div class="ui">
                                                    
                                                    

                                                    <input type="text" placeholder="Quick  Search.." ng-model="userSearch">
                                                </div>

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
                                                      <td> <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="right" title="Delete " ng-click="addItem(x.submenu_id,x.submenu_name,x.parent_id )">Add Menu</button></td>
                                                         
                                                    </tr>
                                                    
                                                </tbody>
                                            </table></code>

                                            <!--Pagination --->
                                <dir-pagination-controls
                                    max-size="10"
                                    direction-links="true"
                                    boundary-links="true" >
                                </dir-pagination-controls>
                                <!--Pagination --->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./bootstrap table -->

          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-tablet fa-lg"></i>
                                        <h2>Menu Chart</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="panel panel-primary">
                                            
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="tab1primary">
                                                        <div class="card-content">
                                        <table class="table table-bordered table-responsive table-hover" >
                                            <thead>
                                                <tr>
                                                    <th>Menu Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody ng-repeat="item in itemList " ng-animate="'slide-down'">
                                                <tr >
                                                    <td>

                                                        <input  type="text" class="form-control"  ng-model="item.submenu_name" size="10" readonly style="font-size: 12px; size: 12px" /></td>
                                                    <td> <code> <a href ng-hide="printMode" ng-click="removeItem(item)" class="btn btn-danger btn-sm">&times;</a></code></td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>

                   

                                    </div>


                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-content" id="color-button">
                                        <!--Materialize Buttons -->
                                        <a class="waves-effect waves-light btn red" ng-click="update_button('Save')" data-toggle="modal" data-target="#myModal">Add Menu To User</a>
                                       
                                        
                                    </div>
                            </div>
                            <!-- ./tabs -->

 

                            
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
$http.get("<?=base_url()?>User/get_SubMenu")
            .then(function (response) {
               $scope.myUserData = response.data; //data call

            });
            $http.get("<?=base_url()?>User/getUser")
            .then(function (response) {
               $scope.myPData = response.data; //data call

            });

 
     }      


//insert 

  $scope.itemList =  [];



  $scope.MenuIN = function() {
      
       
         if ($scope.personal_info_id==null) {
          alert("Select User")
        }else if($scope.itemList.length==0){
        alert("Your Menu(item) is empty")

        }else if (confirm("Are you sure you want to perform this action?")) {
            $http.post(
                "<?=base_url()?>User/Menu_Item", {
             
                  'item':$scope.itemList,
                  'personal_info_id':$scope.personal_info_id,  
                    
                }
            ).then(function(response) {
                 alert(response.data);

                $scope.personal_info_id = null;
                $scope.itemList=[]
                $scope.btnName = "Add";
              
                
                $scope.show_data();
            });

 } else {
            return false;
        }
        }
        

// Remotes an item from the invoice
        $scope.removeItem = function(item) {
            $scope.itemList.splice($scope.itemList.indexOf(item), 1);
        };

 // Adds an item to the invoice's items
        $scope.addItem = function(submenu_id,submenu_name,parent_id) {
           var found = false;
         $scope.itemList.forEach(function (item) {
        if (item.submenu_id === submenu_id) {
          alert('The Menu is already in the Menu Chart.')
          found = true;
        }
      });
         if (!found) {
       $scope.itemList.push({ submenu_id: submenu_id, submenu_name: submenu_name,parent_id: parent_id,});
      }
       
           
       
            
        };

 }); 
 </script>


<?php include("include/footer.php") ?>


          
