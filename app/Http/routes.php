<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\User, Illuminate\Http\Request;

Route::get('/', function () {
	
	//a little map-reduce never hurt anyone
	$users=User::all()->map(function ($user) {
		$user = $user->toArray();
		//singleton is pretty good here
		$jwt = app()->make('JWTHelper');
		$user['token'] = $jwt->createToken($user);
		return $user;
	});
    return view('index', ['users' => $users]);
});

Route::get('/restricted', ['middleware' => 'jwt', function (Request $request){
	
	$token = $request->get('token', FALSE);
	$jwt = app()->make('JWTHelper');
	return view('restricted', ['token' => $token, 'pieces' => $jwt->disect($token)]);
}]);