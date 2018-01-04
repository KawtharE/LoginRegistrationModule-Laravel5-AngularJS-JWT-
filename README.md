# Login & Registration Module with Laravel 5.4, AngularJS 1.5.11, JWT authentication 1.0.0-beta.3v and Satellizer 0.15.5

**This example is totaly responsive and can be tested on phones, tablets, desktops.**

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

    $ cd /var/www/html *(preferably to place our project in this emplacement so that the laravel development server will be **localhost** which will make the development process easier)*
    $ composer create-project laravel/laravel --prefer-dist authApp 5.4 *(for the last Laravel version just remove 5.4)*
    $ cd authApp
    $ php artisan serve

Now the laravel project is ready on **http://localhost:8000**

![The Starting Screen](https://github.com/KawtharE/LoginRegistrationModule-Laravel5-AngularJS-JWT-/blob/master/assets/LaravelStartinPage.png)

**In case an Error 500 occur**, then there is some permission that need to be added:

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

   1- we need to remove the *VerifyCsrfToken* class from *$middlewareGroups* since JWT already do that, so we just comment this line:
      
        \App\Http\Middleware\VerifyCsrfToken::class,
      
   2- add *'jwt.auth'* and *'jwt.refresh'* classes to *$routeMiddleware*:
   
        'jwt.auth' => Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => TymonJWTAuth\Middleware\RefreshToken::class,
        
###### g- edit config/auth.php file:

since laravel will be used to develop an api and a web app, we need to make a change in the auth.php file:

              'default' => [
                   'guard' => '**api**',
                   'passwords' => 'users',
              ];
and since we will use jwt for authentication and not token, another change have to be made:

              'guards' => [
                  ...
                  'api' => [
                      'driver' => 'jwt',
                      'provider' => 'users'
                  ]
              ]
               
               
