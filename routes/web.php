<?php
use Illuminate\Filesystem\Filesystem;
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

/**
 * Development Routes
 */

/**
 * Migrate
 */
Route::get('/migrate', function () {
    Artisan::call('migrate');
});

/**
 * Migrate refresh
 */
Route::get('/migrate/fresh', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
});

/**
 * Clean all
 */
Route::get('/clear/all', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
});

/**
 * Clean cache
 */
Route::get('/clear/cache', function () {
    Artisan::call('cache:clear');
});

/**
 * Clean storage
 */
Route::get('/reset/storage', function() {
    $directories = Storage::directories('/public');
    foreach($directories as $directory) {
        Storage::deleteDirectory($directory);
        Storage::makeDirectory($directory);
    }

    return 'Storage cleaned!';

});

// Create route file
/**
 * Generate a CSV of all the routes
 */
Route::get('r', function()
{
    header('Content-Type: application/excel');
    header('Content-Disposition: attachment; filename="routes.csv"');
 
    $routes = Route::getRoutes();
    $fp = fopen('php://output', 'w');
    fputcsv($fp, ['METHOD', 'URI', 'NAME', 'ACTION']);
    foreach ($routes as $route) {
        fputcsv($fp, [head($route->methods()) , $route->uri(), $route->getName(), $route->getActionName()]);
    }
    fclose($fp);
});


// Loging out 
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


Route::group(['middleware' => 'auth'], function() {

    /**
     * Messages route
     */
    Route::resource('messages', 'MessageController');
    Route::get('/author/{author}/messages', 'MessageController@authorMessages'); // Author messages
    Route::get('/speaker/{speaker}/messages', 'MessageController@speakerMessages'); // Speaker messages
    // Series messages 
    Route::get('/series/{series}/messages', 'MessageController@serieMessages');
    Route::get('/messages/series/{series}', 'MessageController@serieMessages');
        

    /**
     * Articles route
     */
    Route::get('/articles/published', 'ArticleController@listPublished'); // Get published articles
    Route::get('/articles/drafts', 'ArticleController@listDrafts'); // Get draft articles
    Route::resource('articles', 'ArticleController');
    Route::get('/author/{author}/articles', 'ArticleController@authorArticles'); // Author articles
    // Series articles 
    Route::get('/series/{series}/articles', 'ArticleController@serieArticles');
    Route::get('/articles/series/{series}', 'ArticleController@serieArticles');
    

    /**
     * Songs route
     */
    Route::resource('songs', 'SongController');

    // Series articles 
    Route::get('/series/{series}/articles', 'ArticleController@serieArticles');
    Route::get('/articles/series/{series}', 'ArticleController@serieArticles');

    // Pages routes
    Route::resource('pages', 'PageController');

    /**
     * Users routes
     * 
     */
    Route::resource('users', 'UserController');
    Route::post('/user/{user}/change-password', 'UserController@changePassword')->name('change_password');
    
    /**
     * Series route 
     */
    Route::resource('series', 'SeriesController');

});

