<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Token;

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

use App\User;
use \Firebase\JWT\JWT;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return Token::generateTokenFor(Auth::user());
    }
});

Route::post('/attend', function (Request $request) {
    $user = User::where('email', $request->user)->firstOrFail();

    $decoded = JWT::decode($request->token, $user->token->token, array('HS256'));

    dd($decoded);
});