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




Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', function () {
        return view('admin/login');
    });
    // Route::post('login','HomeController@postLogin');
    Route::post('loginuser', [ 'as' => '/login', 'uses' => 'SignInController@login']);
});


  

//Route::post('loginuser', 'SignInController@login');

    Route::get('/',function(){
        return redirect('/home');
    });

   Route::get('home','UserController@home');

    Route::get('signup','ClientsideController@signup');
    Route::get('login','ClientsideController@login');
    Route::post('login','ClientsideController@postLogin');
    Route::post('register','ClientsideController@postregister');
    Route::get('home','ClientsideController@home');



Route::group(['middleware' => 'auth' ,'prefix' => 'admin'], function() {

//Route::group(['middleware' => 'auth.admin'], function () {

    /*Route::get('/home', function () {
         return view('admin/home');
    });*/



    Route::get('/logoutuser' , 'HomeController@getSignOut');

    Route::get('/home', 'HomeController@index')->name('home');

   
   
    Route::get('/product/{id?}', 'HomeController@product');
    Route::post('/add-product', 'HomeController@addProduct');
    Route::get('/manage-product', 'HomeController@manageProduct');
    Route::get('/product_list_ajax', 'HomeController@product_list_ajax');
    Route::get('/product/delete/{id}', 'HomeController@deleteProduct');

  
    Route::get('/user/{id?}', 'HomeController@userform');
    Route::post('/add-user', 'HomeController@addUser');

    Route::get('/delete_user/{id}', 'HomeController@deleteUser');

    Route::get('/manage-user', 'HomeController@manageUser');

    
});


Route::group(['middleware' => ['web']], function() {
    Route::get('/logout' , 'ClientsideController@logout');
    Route::get('/product', 'ClientsideController@product');
});
