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
Route::get("/show/my/page",function (){
   return view("my_page");
});
/*group middleware*/
/*Route::group(['middleware'=>'auth'],function (){*/
    Route::get('/dashboard','User\HomeController@index')/*->middleware('auth')*/;
/*});*/
/* Login Route */
Route::get('/user/login','Auth\LoginController@showLoginForm');
Route::post('/user/login','Auth\LoginController@login')->name('user.login');
Route::post('/user/logout','Auth\LoginController@logout')->name('user.logout');
/* Registration Route */
Route::get('/user/registration','Auth\RegisterController@showRegistrationForm');
Route::post('/user/register','Auth\RegisterController@userRegister')->name('user.register');
Route::get('/user/profile','Auth\LoginController@profile');
Route::post('/update/user/profile','Auth\LoginController@updateProfile')
    ->name('update.profile');
Route::post('/update/user/password','Auth\LoginController@updatePassword')
    ->name('update.password');
/* Forgot Password Routes */
Route::get('/forgot/password','Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('/send/rest/link','Auth\ForgotPasswordController@sendResetLinkEmail')
->name('send.reset.link');
Route::get('/password/reset/{token}','Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');
Route::post('/password/reset','Auth\ResetPasswordController@reset')
->name('password.request');

/*Question Routes*/
Route::get('/new/question','User\QuestionController@create');
Route::post('/store/question','User\QuestionController@store')
    ->name('store.question');
Route::get('/question/list/datatable','User\QuestionController@index');
Route::get('/question/datatable','User\QuestionController@questionData');
Route::get('/question/list','User\QuestionController@rawTable');
Route::get('/top/question','User\QuestionController@topQuestion');
Route::get('/show/question/{id}','User\QuestionController@show');
Route::get('/view/question/{id}','User\QuestionController@view');
Route::get('delete/question/{id}','User\QuestionController@deleteQuestion');
Route::get('edit/question/{id}','User\QuestionController@edit');
Route::post('update/question/{id}','User\QuestionController@update');
Route::any('/search/question','User\QuestionController@search')
    ->name('search.question');


/*ANSWER Route*/
Route::post('/store/answer/{id}','User\AnswerController@store')
    ->name('store.answer');
Route::post('/update/answer/{id}','User\AnswerController@update')
    ->name('update.answer');
Route::get('/answered/list','User\AnswerController@answeredList');
Route::get('/answered/datatable','User\AnswerController@answeredDataTable');
/*Comment Route*/
Route::post('/store/comment/{id}','User\AnswerController@storeComment')
    ->name('store.comment');
Route::get('/delete/comment/{id}','User\AnswerController@deleteComment');


// Admin Side

Route::get('/admin/dashboard','Admin\HomeController@index');
Route::get('/admin/login','Auth\AdminLoginController@showLoginForm');
Route::post('/admin/login','Auth\AdminLoginController@login')
	->name('admin.login');
Route::post('/admin/logout','Auth\AdminLoginController@logout')
	->name('admin.logout');

Route::group(['middleware'=>['role:editor|master-admin']],function (){

    Route::get('/new/system/user','Admin\SystemUserController@create')
        ->middleware('permission:add');
    Route::post('/store/new/system/user','Admin\SystemUserController@store')
        ->name('store.system.user')
        ->middleware('permission:add');

    Route::get('/system/user/list','Admin\SystemUserController@index');

    Route::get('/edit/system/user/{id}','Admin\SystemUserController@edit')
    ->name('edit.system.user')
    ->middleware('permission:view');

    Route::post('/update/system/user/{id}','Admin\SystemUserController@update')
        ->name('update.system.user')
        ->middleware('permission:update');

    Route::get('/delete/system/user/{id}','Admin\SystemUserController@destroy')
        ->middleware('permission:delete');

});
Route::group(['middleware'=>['role:sub-admin']],function () {

    Route::get('/assign/permission', 'Admin\PermissionController@assign');
    Route::post('/assign/permission', 'Admin\PermissionController@assignPermission')
        ->name('assign.permission');
    Route::post('/update/permission', 'Admin\PermissionController@updatePermission')
        ->name('update.permission');
    Route::get('/delete/permission/{admin_id}', 'Admin\PermissionController@deletePermission');

});

