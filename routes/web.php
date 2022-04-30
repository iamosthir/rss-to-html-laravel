<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get("/",function(){
    return redirect()->to("/admin/home");
});

Route::get("/admin", function () {
    return redirect()->to("/admin/home");
});

Auth::routes(["register"=>false]);

Route::group(["prefix"=>"admin", "middleware" => "auth"],function(){

    Route::get("/home","AdminPagesController@home")->name("admin.home");

    Route::group(["prefix"=>"rss-url"], function(){

        Route::get("/add","AdminPagesController@addRss")->name("rss.add");
        
        Route::get("/list","AdminPagesController@rssList")->name("rss.list");

    });

    Route::get("/my-profile","AdminPagesController@myProfile")->name("profile");

    // Super admin
    Route::group(["prefix" => "super-admin"],function(){

        Route::get("/all-user-list","AdminPagesController@userList")->name("super.user-list");

        Route::get("/add-user","AdminPagesController@addUser")->name("super.add-user");

        Route::get("/edit-user/{userid}","AdminPagesController@editUser")->name("super.edit-user");
    });
    // 


    // Carousel item preview
    Route::get("/carousel-preview","AdminPagesController@carouselPreview");

    // Api calls
    Route::group(["prefix"=>"api"],function(){

        Route::post("/rss-feed-to-json", "AdminPagesController@rssToHtml");

        Route::post('/add-rss-url',"RssUrlController@add");

        Route::get("/get-rss-url-list","RssUrlController@getList");

        Route::post("/delete-rss-url","RssUrlController@delete");

        Route::post("/update-my-profile","UserController@update")->name("api.update-profile");

        Route::post("/delete-profile-photo","UserController@deletePhoto");

        Route::post("/delete-user","UserController@deleteUser");

        Route::post("/add-user","UserController@addUser")->name("api.add-user");

        Route::post("/update-user-profile", "UserController@updateUser")->name("api.update-user-profile");

    });


});
