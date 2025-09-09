<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

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

//Dashbaords das Personas
Route::get('/admDashboard', function () {
    return view('admDashboard');
});

Route::get('/alunoDashboard', function () {
    return view('alunoDashboard');
});

Route::get('/loginProfessor', [professorController::class, 'showLoginForm'])
    ->name('loginProfessor');



Route::get('/professorDashboard','App\Http\Controllers\professorController@professorDashboard')->middleware(Authenticate::class);


//Login e Cadastro das Personas
Route::get('/loginAluno', function () {
    return view('loginAluno');
});

Route::get('/loginProfessor', function () {
    return view('loginProfessor');
});

Route::get('/loginAdm', function () {
    return view('loginAdmin');
});

Route::post('/cadastrar-prof', [App\Http\Controllers\professorController::class, 'store']);   

Route::post('/login-verify', [App\Http\Controllers\professorController::class, 'verifyUser']);