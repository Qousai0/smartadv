<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AiChatController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//the route here is start with api then /hello *******
Route::get('/hello', function (Request $request) {  
    return response()->json([
        'message' => 'Hello, World!',
       'requestt'=>$request,]);
  });
  Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'Smart Advisor API is working!'
    ]);
});

  Route::post('/ai/ask', [AiChatController::class, 'ask']);