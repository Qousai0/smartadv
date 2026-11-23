<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CourseController;
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

  Route::get('/test-iconvv', function () {
    return response()->json([
        'iconv_loaded' => extension_loaded('iconv'),
        'iconv_impl' => defined('ICONV_IMPL') ? ICONV_IMPL : null,
        'cp1252' => @iconv('CP1252', 'UTF-8//TRANSLIT//IGNORE', 'Hello'),
        'windows1252' => @iconv('Windows-1252', 'UTF-8//TRANSLIT//IGNORE', 'Hello'),
    ]);
});





/**D:\projects\laravel\firstlaravelproject\smartadv\app\Http\Controllers\user_cont_auth\login_cont_check.php
 * 
 *             USER LOGIN AND REGISTER ROUTES  
 */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/users', [AuthController::class, 'store']);





Route::post('/courses', [CourseController::class, 'store']);

Route::post('/student-courses', [CourseController::class, 'registerStudentCourse']);

Route::get('/students/{studentId}/courses', [CourseController::class, 'studentCourses']);





use App\Http\Controllers\SpecializationController;

Route::post('/specializations', [SpecializationController::class, 'store']);

Route::post('/assign-specialization', [SpecializationController::class, 'assignToStudent']);