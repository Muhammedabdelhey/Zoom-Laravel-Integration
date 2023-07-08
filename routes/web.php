<?php

use App\Http\Controllers\ZoomController;
use App\Services\ZoomSerivce;
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

Route::get('/', function () {
    return view('welcome');
});
// Redirect to Zoom for authorization
Route::get('/zoom/authorize', [ZoomController::class, 'getToken']);

// Callback handler for Zoom authorization
Route::get('/zoom/meeting/{meetingID}', [ZoomController::class, 'getMeeting']);
Route::get('/zoom/meeting', [ZoomController::class, 'makeMeeting']);
Route::get('/zoom/meeting/delete/{meetingID}', [ZoomController::class, 'deleteMeeting']);
Route::get('/zoom/meeting/update/{meetingID}', [ZoomController::class, 'updateMeeting']);
