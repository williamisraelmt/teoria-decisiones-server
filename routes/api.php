<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'report'], function() {
   Route::get('', 'ReportController@getAll');
    Route::post('/data', 'ReportController@getData');
    Route::post('/chart-data', 'ReportController@getChartData');
    Route::post('/widgets-data', 'ReportController@getWidgetsData');
    Route::post('/events', 'ReportController@getEvents');
    Route::get('{code}', 'ReportController@get');
});

Route::group(['prefix' => 'event'], function() {
    Route::get('', 'EventController@getAll');
    Route::post('', 'EventController@create');
    Route::get('event-types', 'EventController@getEventTypes');
});





