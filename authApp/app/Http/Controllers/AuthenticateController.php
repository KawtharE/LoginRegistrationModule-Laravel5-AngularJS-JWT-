<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\LoginRequest;

class AuthenticateController extends Controller
{
	private $user;
	private $jwtauth;

	public function __construct(User $user, JWTAuth $jwtauth) {
		$this->middleware('jwt.auth', ['except' => ['register', 'login']]);
		$this->user = $user;
		$this->jwtauth = $jwtauth;
	}
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
}
