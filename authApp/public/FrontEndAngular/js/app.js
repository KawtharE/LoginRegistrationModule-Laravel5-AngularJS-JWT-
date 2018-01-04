(function() {
	'use strict';

	angular.module('LogRegModule', ['ui.router', 'satellizer'])

		   .config(function($authProvider, $stateProvider, $urlRouterProvider, $provide, $httpProvider){
		   		$authProvider.signupUrl = '/api/register';
		   		$authProvider.loginUrl = '/api/login';
		   		$urlRouterProvider.otherwise('/login');

		   		$stateProvider
		            .state('login', {
		                url: '/login',
		                templateUrl: '/FrontEndAngular/template/login.html',
		                controller: 'LoginController',
		                controllerAs:'lg',
		            })
		            .state('registration', {
		                url: '/registration',
		                templateUrl: '/FrontEndAngular/template/registration.html',
		                controller: 'RegistrationController',
		                controllerAs:'rg',
		            })
		            .state('home', {
		                url: '/home',
		                templateUrl: '/FrontEndAngular/template/home.html',
		                controller: 'HomeController',
		                controllerAs:'hm',
		            })

		        function redirectWhenLoggedOut( $q, $injector) {

		            return {
		              responseError: function(rejection) {

		                // Need to use $injector.get to bring in $state or else we get
		                // a circular dependency error
		                var $state = $injector.get('$state');

		                // Instead of checking for a status code of 400 which might be used
		                // for other reasons in Laravel, we check for the specific rejection
		                // reasons to tell us if we need to redirect to the login state
		                var rejectionReasons = ['token_not_provided', 'token_expired', 'token_absent', 'token_invalid'];
		                angular.forEach(rejectionReasons, function(value, key) {

		                  if(rejection.status === 401) {
		                      localStorage.removeItem('user');
		                      localStorage.removeItem('satellizer_token');
		                      $state.go('login');
		                  }
		                });

		                return $q.reject(rejection);
		              }
		            }
		        }
		        // Setup for the $httpInterceptor
		        $provide.factory('redirectWhenLoggedOut', redirectWhenLoggedOut);
		        // Push the new factory onto the $http interceptor array
		        $httpProvider.interceptors.push('redirectWhenLoggedOut');
		   })
.run(function($rootScope, $state) {

  $rootScope.$on('$stateChangeStart', function(event, toState) {
    var user = JSON.parse(localStorage.getItem('user'));
    if(user) {
      $rootScope.authenticated = true;
      $rootScope.currentUser = user;
      if(toState.name === "login" || toState.name === "registration") {

        // Preventing the default behavior allows us to use $state.go
        // to change states
        event.preventDefault();
        $state.go('home');
      }       
    } else {
      $rootScope.authenticated = false;
      $rootScope.currentUser = null;
        if(toState.name === "home") {
        // Preventing the default behavior allows us to use $state.go
        // to change states
        event.preventDefault();
        $state.go('login');
      }
    }
  });
});
})();