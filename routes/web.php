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
    Route::get('/dashboard','Admin\HomeController@index')/*->middleware('auth')*/;
    Route::get('/user/list','Admin\UserController@index')/*->middleware('auth')*/;
    Route::get('/user/create','Admin\UserController@create') /*->middleware('auth')*/;
    Route::get('/user/edit','Admin\UserController@edit')/*->middleware('auth')*/;
/*});*/
/* Login Route */
Route::get('/user/login','Auth\LoginController@showLoginForm');
Route::post('/user/login','Auth\LoginController@login')->name('user.login');
Route::post('/user/logout','Auth\LoginController@logout')->name('user.logout');
/* Registration Route */
Route::get('/user/registration','Auth\RegisterController@showRegistrationForm');
Route::post('/user/register','Auth\RegisterController@userRegister')->name('user.register');

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