<?php
use App\Http\Middleware\IsAuthMiddlwaree;
use App\Http\Controllers\FirstController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Userscontroller;
use App\Http\Controllers\AiChatController;
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

Route::get('/hello', function () {
    $name = 'John Doe';
    $students = ['Alice', 'Bob', 'Charlie', 'David'];
    //return view('hello')-> this mean that we are returning the view hello.blade.php and passing the variable name and students to the view
    return view('hello')->with('name', $name)->with('stud', $students);
    });
    
    
    //controllerfunc
Route::get('/gg', [FirstController::class, 'firstfunc']);


//id is path parameter it will be passed to the  function as first parameter
//id will not go to request it will go to other parameter variabel not request variable
Route::get('/req/{id}', [FirstController::class, 'requestfunction']);




Route::get('/middleware/{id}', [FirstController::class, 'requestfunction'])->middleware(IsAuthMiddlwaree::class);
//create USER in DB
Route::get('/createuser', [Userscontroller::class, 'createuser']);

Route::post('/ai/ask', [AiChatController::class, 'ask']);