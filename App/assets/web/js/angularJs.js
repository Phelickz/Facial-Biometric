var app = angular.module('myUser', ['angularUtils.directives.dirPagination']);
var Store = angular.module('myStore', ['angularUtils.directives.dirPagination']);
var Menu = angular.module('myMenu', ['angularUtils.directives.dirPagination']);



////// USER QUERY DETAILS///////////
app.controller("UserCtrl", function($scope, $http) {

$http.get("http://localhost/bet9ja/User/get_User")
            .then(function (response) {
               $scope.myUserData = response.data; //data call
            });
			//BY STORE////
			   $scope.show_data = function() {
$http.get("http://localhost/bet9ja/User/get_Userby_store")
            .then(function (response) {
               $scope.myStoreUserData = response.data; //data call
            });
			   }		
			
   //Upadte Database
    $scope.update_data = function(personal_info_id) {
       if (confirm("Are you sure you want to Activate User?")) {
            $http.post("http://localhost/bet9ja/User/Approve_User", {
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
    $scope.delete_data = function(personal_info_id) {
        if (confirm("Are you sure you want to Deactivate User?")) {
              $http.post("http://localhost/bet9ja/User/D_Approve_User", {
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
	
});


////// STORE QUERY DETAILS///////////
Store.controller("StoreCtrl", function($scope, $http) {
	 $scope.show_data = function() {
$http.get("http://localhost/bet9ja/Warehouse/get_Store")
            .then(function (response) {
               $scope.myUserData = response.data; //data call
            });
	 }
	//Delete Store
    $scope.delete_data = function(in_store_id) {
        if (confirm("Are you sure you want to Delete Store ? There is no Undo")) {
              $http.post("http://localhost/bet9ja/Warehouse/Delete_store", {
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



////// MENU QUERY DETAILS///////////
Menu.controller("MenuCtrl", function($scope, $http) {
$http.get("http://localhost/bet9ja/User/get_Menu")
            .then(function (response) {
               $scope.myMenuData = response.data; //data call
            });
//BY STORE////
$http.get("http://localhost/bet9ja/User/get_Userby_store")
            .then(function (response) {
               $scope.myStoreUserData = response.data; //data call
            });
		//Store by user	
		 $scope.show_data = function() {
$http.get("http://localhost/bet9ja/Warehouse/get_Store")
            .then(function (response) {
               $scope.myStoreData = response.data; //data call
            });
		 }

   
	//Delete Store
    $scope.delete_data = function(store_vid) {
        if (confirm("Are you sure you want to Delete Store ?")) {
              $http.post("http://localhost/bet9ja/User/D_Approve_User1", {
                    'store_vid': store_vid
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




