<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SmsTempController;
use App\Http\Controllers\Api\CallerIDController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EmailTempController;
use App\Http\Controllers\Api\Dialer_memController;
use App\Http\Controllers\Api\LeadScriptController;
use App\Http\Controllers\Api\DialerAudioController;
use App\Http\Controllers\Api\DialerLeadsController;
use App\Http\Controllers\Api\DialerQueuesController;
use App\Http\Controllers\Api\Queues_FilterController;
use App\Http\Controllers\Api\DialerCalleridController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->get('/logout', function () {
    $user = auth()->user();
    $user->tokens()->delete(); 
    return response()->json([
        'status' => true,
        'message' => "User Successfully Logout",
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('register', [RegisterController::class, 'register']);
    
    // User Api 
    Route::get('user/details/{uid?}', [UserController::class, 'getuser']);
    Route::post('user/update/{uid}', [UserController::class, 'update']);
    Route::post('password-reset', [UserController::class, 'updatePassword']);
    Route::delete('user/delete/{uid}', [UserController::class, 'delete']);

    // Dialer SMS_template api
    Route::get('sms_temp/get/{uid?}', [SmsTempController::class, 'index']);
    Route::post('sms_temp/store', [SmsTempController::class, 'store']);
    Route::get('sms_temp/show/{id}', [SmsTempController::class, 'show']);
    Route::post('sms_temp/update/{id}', [SmsTempController::class, 'update']);
    Route::delete('sms_temp/delete/{id}', [SmsTempController::class, 'delete']);

    // Dialer Email_template api
    Route::get('email_temp/get/{uid?}', [EmailTempController::class, 'index']);
    Route::post('email_temp/store', [EmailTempController::class, 'store']);
    Route::get('email_temp/show/{id}', [EmailTempController::class, 'show']);
    Route::post('email_temp/update/{id}', [EmailTempController::class, 'update']);
    Route::delete('email_temp/delete/{id}', [EmailTempController::class, 'delete']);

     // Dialer Lead api
     Route::get('leads/get/{uid?}', [DialerLeadsController::class, 'index']);
     Route::post('leads/store', [DialerLeadsController::class, 'store']);
     Route::post('leads/upload', [DialerLeadsController::class, 'excelimport']);
     Route::get('leads/show/{id}', [DialerLeadsController::class, 'show']);
     Route::post('leads/update/{id}', [DialerLeadsController::class, 'update']);
     Route::delete('leads/delete/{id}', [DialerLeadsController::class, 'delete']);
     Route::post('leads/multi_delete', [DialerLeadsController::class, 'delete_leades']);

     // Dialer Leas script api
    Route::get('lead_script/get/{uid?}', [LeadScriptController::class, 'index']);
    Route::post('lead_script/store', [LeadScriptController::class, 'store']);
    Route::get('lead_script/show/{id}', [LeadScriptController::class, 'show']);
    Route::post('lead_script/update/{id}', [LeadScriptController::class, 'update']);
    Route::delete('lead_script/delete/{id}', [LeadScriptController::class, 'delete']);

     // Caller_id api
     Route::get('caller_id/get/{uid?}', [CallerIDController::class, 'index']);
     Route::post('caller_id/store', [CallerIDController::class, 'store']);
     Route::get('caller_id/show/{id}', [CallerIDController::class, 'show']);
     Route::post('caller_id/update/{id}', [CallerIDController::class, 'update']);
     Route::delete('caller_id/delete/{id}', [CallerIDController::class, 'delete']);
});
