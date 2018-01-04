(function(){
  'use strict';

	angular
		.module('LogRegModule')
		.controller('LoginController', LoginController);

		function LoginController($auth, $state, $http, $rootScope) {
		    var vm = this;
		    vm.loginError = false;
		    vm.loginErrorText;


		    vm.login = function() {

				var credentials = {
					email: vm.email,
					password: vm.password
				} 

				$auth.login(credentials).then(function() {
				  return $http.get('api/authentUser');
				}, function(error) {
				  vm.loginError = true;
				  vm.loginErrorText = error.data.error;
				}).then(function(response) {
				  var user = JSON.stringify(response.data.user);
				  localStorage.setItem('user', user);
				  $rootScope.authenticated = true;
				  $rootScope.currentUser = response.data.user;
				  $state.go('home');
				}).catch(function (response) {			      
				   console.log('Error: Login failed');
				});
			}
		}
})();