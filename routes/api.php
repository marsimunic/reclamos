<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\UserController@userLogin');
Route::post('register', 'Api\UserController@registerUser');


Route::group(['middleware' => 'auth:api'], function(){
	Route::post('reclamos','Api\ReclamosController@getReclamos');
});*/

Route::group([
    'prefix' => 'epre'
], function () {
	//Route::post('login', [ 'as' => 'login', 'uses' => 'Api\UserController@userLogin']);
    Route::post('token', 'Api\UserController@userLogin');
    Route::post('register', 'Api\UserController@userRegister');
    
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', 'Api\UserController@userLogout');
        Route::post('reclamos','Api\ReclamosController@getReclamos');
    });
});
