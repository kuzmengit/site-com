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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/',['as' => 'home', 'uses' => 'PostsController@index']);
Route::get('/home',['as' => 'home', 'uses' => 'PostsController@index']);
//authentication
// Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Route::get('/auth/logout', 'WelcomeController@index');
Route::controllers(['auth' => 'Auth\AuthController','password' => 'Auth\PasswordController',]);
// check for logged in user
Route::group(['middleware' => ['auth']], function()
	{
		// show new post form
		Route::get('new-post','PostsController@create');
		// save new post
		Route::post('new-post','PostsController@store');
		// edit post form
		Route::get('edit/{slug}','PostsController@edit');
		// update post
		Route::post('update','PostsController@update');
		// delete post
		Route::get('delete/{id}','PostsController@destroy');
		// display user's all posts
		Route::get('my-all-posts','UsersController@user_posts_all');
		// display user's drafts
		Route::get('my-drafts','UsersController@user_posts_draft');
		// add comment
		Route::post('comment/add','CommentsController@store');
		// delete comment
		Route::post('comment/delete/{id}','CommentsController@distroy');
	});
//users profile
Route::get('user/{id}','UsersController@profile')->where('id', '[0-9]+');
// display list of posts
Route::get('user/{id}/posts','UsersController@user_posts')->where('id', '[0-9]+');
// display single post
Route::get('/{slug}',['as' => 'post', 'uses' => 'PostsController@show'])->where('slug', '[A-Za-z0-9-_]+');
