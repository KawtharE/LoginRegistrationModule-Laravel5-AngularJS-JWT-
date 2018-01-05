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
  
   This file should placed in **resources/views** and it will be the base file of our template. It should contain all CSS      and JS files and essentially it hosts the **<ui-view></ui-view>** element.
   
###### d- create the js/app.js, templates/login.html, templates/registration.html, templates/home.html, js/LoginController.js, js/RegistrationController.js, js/HomeController.js

#### 6- Create the AuthenticationController.php for the server side development which contain the Login, Registration and extracting users data functions
#### 7- configure routes in routes/api.php


## Testing

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/LoginPage.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationPage.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/HomePage1.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/HomePage2.png)

#### 2- Error handling

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/LoginPageError.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationError1.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationError2.png)

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/RegistrationError3.png)
