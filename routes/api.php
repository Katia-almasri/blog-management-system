<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TextBlogController;
use App\Http\Controllers\VideoBlogController;
use App\Http\Controllers\UserController;



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

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);
 
Route::group(['middleware'=>'check-authentication:api'], function(){
    //all the features allowed when user is authenticated only
    Route::get('logout', [LoginController::class, 'logout']);

    Route::post('addComment/{textBlogId}', [UserController::class, 'addComment']);
    Route::get('displayTextBlogs', [TextBlogController::class, 'getTextBlogs']);
    Route::post('addTextBlog', [TextBlogController::class, 'addTextBlog']);
    Route::post('addVideoBlog', [VideoBlogController::class, 'addVideoBlog']);
    Route::get('displayVideoBlogs', [VideoBlogController::class, 'getVideoBlogs']);
    
    Route::group(['middleware'=>'check-text-blog-exist:api'], function(){ 
        //to check if the id passed as parameter in the route is already exist
        Route::get('readTextBlog/{textBlogId}', [TextBlogController::class, 'readTextBlog']);

        Route::group(['middleware'=>'check-is-author:api'], function(){
            //to check if the operation that are made to the blogs done by the authorized user(creater)
            Route::post('editTextBlog/{textBlogId}', [TextBlogController::class, 'editTextBlog']);
            Route::get('deleteTextBlog/{textBlogId}', [TextBlogController::class, 'deleteTextBlog']);
            
        });
        
        
    });

    //video blog middleware
    Route::group(['middleware'=>'check-video-blog-exist:api'], function(){ 
        //to check if the id passed as parameter in the route is already exist
        Route::get('displayVideoBlog/{videoBlogId}', [VideoBlogController::class, 'displayVideoBlog']);

        Route::group(['middleware'=>'check-is-creator:api'], function(){
            //to check if the operation that are made to the blogs done by the authorized user(creater)
            Route::post('editVideoBlog/{videoBlogId}', [VideoBlogController::class, 'editVideoBlog']);
            Route::get('deleteVideoBlog/{videoBlogId}', [VideoBlogController::class, 'deleteVideoBlog']);
            
        });
        
        
    });
});
