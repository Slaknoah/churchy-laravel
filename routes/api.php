<?php

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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::post('details', 'API\UserController@details');

/**
 * Messages routes
 */
Route::get('/author/{author}/messages', 'MessageController@authorMessages'); // Author messages
Route::get('/speaker/{speaker}/messages', 'MessageController@speakerMessages'); // Speaker messages
Route::apiResource('messages', 'MessageController');
Route::get('messages', 'MessageController@filter');

// Series messages
Route::get('/series/{series}/messages', 'MessageController@serieMessages');
Route::get('/messages/series/{series}', 'MessageController@serieMessages');

/**
 * Songs controller
 */
Route::apiResource('songs', 'SongController');

/**
 * Articles controller
 */
Route::get('/author/{author}/articles', 'ArticleController@authorArticles'); // Author articles
Route::get('/articles/published', 'ArticleController@listPublished'); // Get published articles
Route::get('/articles/drafts', 'ArticleController@listDrafts'); // Get draft articles
Route::apiResource('articles', 'ArticleController');
// Series articles
Route::get('/series/{series}/articles', 'ArticleController@serieArticles');
Route::get('/articles/series/{series}', 'ArticleController@serieArticles');
Route::get('articles', 'ArticleController@filter');

/**
 * Pages Controller
 */
Route::apiResource('pages', 'PageController');

/**
 * Users routes
 *
 */
Route::post('/users/{user}/change-password', 'UserController@changePassword')->name('change_password');
Route::get('/roles/{role}/users', 'UserController@roleUsers')->name('get_role_users');
Route::apiResource('users', 'UserController');
Route::get('message-authors', 'UserController@messageAuthors');
Route::get('article-authors', 'UserController@articleAuthors');

/**
 * Series route
 */
Route::apiResource('series', 'SeriesController');