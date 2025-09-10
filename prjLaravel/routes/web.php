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

//Aluno
Route::get('/loginAluno', function () {
    return view('loginAluno');
});
Route::get('/alunoDashboard', function () {
    return view('alunoDashboard');
});


//Professor
Route::get('loginProfessor', function () {
    return view('loginProfessor');
});
Route::get('/professorDashboard', function () {
    return view('professorDashboard');
})->middleware('auth:professor');
Route::post('/logout-professor', [App\Http\Controllers\professorController::class, 'logoutUser'])->middleware('auth:professor');    





//Admin
Route::get('/admDashboard', function () {
    return view('admDashboard');
});
Route::get('/loginAdm', function () {
    return view('loginAdmin');
});

//Login e Cadastro das Personas
Route::post('/cadastrar-prof', [App\Http\Controllers\professorController::class, 'store']);   

Route::post('/login-verify', [App\Http\Controllers\professorController::class, 'verifyUser']);