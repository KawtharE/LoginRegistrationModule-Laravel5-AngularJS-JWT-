# Login & Registration Module with Laravel 5.4, AngularJS 1.5.11, JWT authentication 1.0.0-beta.3v and Satellizer 0.15.5

**This example is totaly responsive and can be tested on phones, tablets and desktops.**

**Note:** when downloding this example you need to execute this command line from the project folder:

          $ composer update --no-scripts
          
   -> In order to create the autoload files.

## The implemented functions in this example:
##### 1- Login.
##### 2- Registration.
##### 3- Listing users who have already sign up.

## Steps
#### 1- Install local development environment:
Install local server:

        -WAMP: Windows,
        -LAMP: Linux,
        -MAMP: MAC,
        -XAMPP: Windows, Linux, OSx
Server requirements to start a Laravel 5.4 project:

        -php>= 5.6.4
        -OpenSSL PHP extension
        -PDO PHP extension
        -Mbstring PHP extension
        -Tokenizer PHP extension
        -XML PHP extension
        -Enable mcrypt extension

**[Server requirements](https://laravel.com/docs/5.4/installation#server-requirements) from the Official documentation of Laravel 5.4**

#### 2- Install Composer

    $ sudo apt-get update
    $ curl -sS https://getcomposer.org/installer | php
    $ sudo mv composer.phar /usr/local/bin/composer
    $ sudo chmod +X /usr/local/bin/composer
  
#### 3- Install Laravel 5.4 with Composer

    $ cd /var/www/html
    $ composer create-project laravel/laravel --prefer-dist authApp 5.4
    $ cd authApp
    $ php artisan serve

Now the laravel project is ready on **http://localhost:8000**

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/LaravelStartinPage.png)

**In case an Error 500 occur**, then there are some permissions that need to be added:

    $ sudo chmod -R 755 /var/www/html/authApp
    $ sudo chmod -R 777 /var/www/html/authApp/storage
    $ sudo chmod -R 777 /var/www/html/authApp/bootstrap/cache
  
#### 3- Setting up the backend authentication tool: JWT
###### a- edit composer.json file:
              "requirement": {
                  "tymon/jwt-auth": "1.0.0-beta.3",
                  "nesbot/Carbon": "^1.0",
                  ...
               };
               
###### b- from CLI:
              $ composer update

###### c- edit config/app.php:
              'providers' => [
                  ...
                  Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
                  ...
               ],
               'aliases' => [
                  ...
                  'JWTAuth'   => Tymon\JWTAuth\Facades\JWTAuth::class,
                  'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class
               ]
               
###### d- from CLI:
            $ php artisan vendor:publish
            $ php arisan vendor:publish --provider="Tymon\JWTAuthProviders\LaravelServiceProvider"
            
###### e- generate a secret key:
            $ php artisan jwt:secret
   -> the secret key will be automatically configured in the **.env** file
               
###### f- edit kernel.php file:

   1- we need to remove the *VerifyCsrfToken* class from *$middlewareGroups* since JWT already do that, so we just need to comment this line:
      
        \App\Http\Middleware\VerifyCsrfToken::class,
      
   2- add *'jwt.auth'* and *'jwt.refresh'* classes to *$routeMiddleware*:
   
        'jwt.auth' => Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => TymonJWTAuth\Middleware\RefreshToken::class,
        
###### g- edit config/auth.php file:

since laravel will be used to develop an API and not a web app, we need to change the 'guard' value from 'web' to **'api'**:

              'default' => [
                   'guard' => 'api',
                   'passwords' => 'users',
              ];
and since we will use JWT for authentication and not token, we need to change the 'driver' value from 'token' to **'jwt'**:

              'guards' => [
                  ...
                  'api' => [
                      'driver' => 'jwt',
                      'provider' => 'users'
                  ]
              ]
#### 4- Configure the user migration table & model

###### a- the migration table:
just inside the **up()** function we add the necessary elements:

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('Age');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

###### b- the user model:
we need to fill the fillable array:

                protected $fillable = [
                  'firstName', 'lastName', 'Age', 'email', 'password'
                ];
      
and implement the JWT classe:

            ...
            use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

            class User extends Authenticatable implements AuthenticatableUserContract {
               ...
          
               /**
               * Get the identifier that will be stored in the subject claim of the JWT
               *
               * @return mixed
               */

              public function getJWTIdentifier()
              {
                  return $this->getKey();  // Eloquent model method
              }

              /**
               * Return a key value array, containing any custom claims to be added to the JWT
               *
               * @return array
               */
              public function getJWTCustomClaims()
              {
                  return [];
              }
            }
            
#### 5- Setting up the Front-end: AngularJS & Satellizer

###### a- create an Angular project:

   Inside the **public** folder create the angular project folder:
   
          $ cd public
          $ mkdir FrontEndAngular
         
 ###### b- Install Angular 1.5.11 and the necessary dependencies:
 
          $ cd FrontEndAngular
          $ npm install angular@1.5.11 satellizer angular-ui-router bootstrap@3
          
###### c- create the master.php file:
  
   This file should be placed in **resources/views** and it will be the base file of our template. It should contain all CSS    and JS files and essentially it hosts the **ui-view** tag.
   
       <div class="container">
         <div class="row">
          <div class="col-xs-10 col-sm-8 col-md-8 col-lg-6 col-xs-offset-1 col-sm-offset-2 col-md-offset-2 col-lg-offset-3">
	 	<div class="panel panel-logreg">
	    		<ui-view></ui-view>
	 	</div>			
          </div>
         </div>
       </div>
   
###### d- create the js/app.js, templates/login.html, templates/registration.html, templates/home.html, js/LoginController.js, js/RegistrationController.js, js/HomeController.js

- **app.js:** this main js file will handle routing in the front-end side using **ui.router** ($stateProvider):

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
			    
- **LoginController.js:** in this file we handle the login scenario

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
		    
- **RegistrationController.js:** in this file we handle the registration scenario

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
				  
- **HomeController.js:** in this file we handle the listing of already registered users and the logout scenarios

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
		 

#### 6- Create the AuthenticationController.php for the server side development which contain the Login, Registration and extracting users data functions

    public function register(RegistrationRequest $request) {
    	$password = $request->get('password');
    	$newUser = $this->user->create([
    					'firstName' => $request->get('firstName'),
    					'lastName' => $request->get('lastName'),
    					'Age' => $request->get('age'),
    					'email' => $request->get('email'),
    					'password' => bcrypt($password)
    				]);
    	if (!$newUser) {
          return response()->json(['failed_to_create_new_user'], 500);
        }
        return response()->json([
            'token' => JWTAuth::fromUser($newUser)
        ]);

    }
    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
    public function getAuthenticatedUser() {
          try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

          } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

          } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

          } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

          }

          // the token is valid and we have found the user via the sub claim
          return response()->json(compact('user'));
    }
    public function getAllUsers(Request $request) {
        $currentUser = $request->get('currentUserEmail');
        $otherUsers = User::where('email', '<>', $currentUser)
        					->orderBy('firstName')
        					->get();
        return $otherUsers;
    }
    
#### 7- configure routes in routes/api.php

	Route::post('/getUsers', 'AuthenticateController@getAllUsers');
	Route::post('/register', 'AuthenticateController@register');
	Route::post('/login', 'AuthenticateController@login');
	Route::get('/authentUser', 'AuthenticateController@getAuthenticatedUser');

## Testing

#### 1- Login, Registration and Listing data from server

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/LoginPage.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationPage.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/HomePage1.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/HomePage2.png)

#### 2- Error handling

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/LoginPageError.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationError1.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationError2.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationError3.png)
