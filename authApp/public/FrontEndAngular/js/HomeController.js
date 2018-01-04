(function(){
  'use strict';

	angular
		.module('LogRegModule')
		.controller('HomeController', HomeController);

		function HomeController($http, $state, $auth, $rootScope, $scope) {
			$rootScope.connectedUser = JSON.parse(localStorage.getItem('user'));
			var vm =this;
	        vm.users;
	        vm.error;

	        vm.getAllUsers = function() {
			  $http({
		        method: 'POST',
		        url: '/api/getUsers',
		        data: 'currentUserEmail='+$rootScope.connectedUser.email,
		        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		      }).success(function(response){
		        vm.users = response;
		      }).error(function(error){
		      	vm.error = error;
		      });
	        }
	         vm.logout = function() {

	              $auth.logout().then(function() {
	                
	                    // Remove the authenticated user from local storage
	                    localStorage.removeItem('user');

	                    // Flip authenticated to false so that we no longer
	                    // show UI elements dependant on the user being logged in
	                    $rootScope.authenticated = false;

	                    // Remove the current user info from rootscope
	                    $rootScope.currentUser = null;
	                    $state.go('login');
	              });
	         }
		}
})();