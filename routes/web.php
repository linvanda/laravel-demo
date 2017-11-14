<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 静态资源
Route::view('/', 'static_pages.home')->name('home');
Route::view('about', 'static_pages.about')->name('about');
Route::view('help', 'static_pages.help')->name('help');

// 用户
Route::resource('users', 'UsersController');

// 关注的人和粉丝
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');

// 关注和取消关注
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// 会话
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

// 密码重设
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 微博
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

// 测试专用
Route::resource('tests', 'TestUsersController');
// api授权 oauth2.0
Route::view('passport', 'passport.clients');
Route::get('redirect/{appid}', function ($appid) {
    // 获取auth code
    $query = http_build_query([
        'client_id' => $appid,
        'redirect_uri' => 'http://www.linvanda.com/passport/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('oauth/authorize?' . $query);
});
Route::get('passport/callback', function (\Illuminate\Http\Request $request) {
    // 通过auth code获取access_token
    $http = new GuzzleHttp\Client();
    $response = $http->post('http://www.linvanda.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '4',
            'client_secret' => 'voHzaXd4Y3UsU1nvmegqFe4b9G5zRc5VjZjWI0AM',
            'redirect_uri' => 'http://www.linvanda.com/passport/callback',
            'code' => $request->code,
        ]
    ]);

    return json_decode((string) $response->getBody(), true);
});

// 密码授权
Route::get('passport/password', function () {
    $http = new GuzzleHttp\Client();

    $response = $http->post('http://www.linvanda.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '5',
            'client_secret' => 'jwoPAdzEEH7eE2xueIKtm9jvrVBCRYD5uMfCj1Zq',
            'username' => 'test@test.com',
            'password' => '123',
            'scope' => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('test', function () {
     $users = \App\Models\User::first();

     $res = new \App\Http\Resources\User($users);

     return gettype($res);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
