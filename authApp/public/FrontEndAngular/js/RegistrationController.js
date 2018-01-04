(function(){

'use strict';

    angular
        .module('LogRegModule')
		.controller('RegistrationController', RegistrationController );

			function RegistrationController ($state, $auth) {
				  var vm = this;
				  vm.user = {};
				  vm.errorText;
				  vm.regError = false;

				  vm.register = function __register() {
				    $auth.signup({
				      firstName: vm.user.firstname,
				      lastName: vm.user.lastname,
				      age: vm.user.age,
				      email: vm.user.email,
				      password: vm.user.password
				    }).then(function (response) {
				      console.log(response);
				      $state.go('login');
				    }).catch(function (response) {
				      vm.regError = true;
				      if (response.data.email) {
				      	vm.errorText = response.data.email;
				      } else if (response.data.password) {
				      	vm.errorText = response.data.password;
				      } else if (response.data.firstName) {
				      	vm.errorText = response.data.firstName;
				      } else if (response.data.lastName) {
				      	vm.errorText = response.data.lastName;
				      } else if (response.data.age) {
				      	vm.errorText = response.data.age;
				      }				      
				      console.log(response);
				    });
				  };
			};
})();
            
