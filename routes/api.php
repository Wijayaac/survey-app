<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::resource('/survey', SurveyController::class);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/answer', [AnswerController::class, 'index']);
    Route::get('/answer/{id}', [AnswerController::class, 'getAnswer']);
});
Route::get('/survey-by-slug/{survey:slug}', [SurveyController::class, 'surveyForGuest']);

Route::post('/survey/{survey}/answer', [SurveyController::class, 'storeAnswer']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
