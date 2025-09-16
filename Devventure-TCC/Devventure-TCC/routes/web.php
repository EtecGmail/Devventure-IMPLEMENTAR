<?php

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

// Aluno
Route::get('/loginAluno', function () {
    return view('loginAluno');
});

Route::get('/alunoDashboard', function () {
    return view('alunoDashboard');
})->middleware('auth:aluno');
Route::post('/logout-aluno', [App\Http\Controllers\alunoController::class, 'logoutUser'])->middleware('auth:aluno');

// Professor
Route::get('loginProfessor', function () {
    return view('loginProfessor');
});
Route::get('/professorDashboard', function () {
    return view('professorDashboard');
})->middleware('auth:professor');
Route::post('/logout-professor', [App\Http\Controllers\professorController::class, 'logoutUser'])->middleware('auth:professor');

// Admin
Route::get('/admDashboard', [App\Http\Controllers\admController::class, 'admDashboard'])->middleware('auth:admin');
Route::get('/loginAdm', function () {
    return view('loginAdmin');
});
Route::post('/logout-adm', [App\Http\Controllers\admController::class, 'logoutUser'])->middleware('auth:admin');

// Login e Cadastro das Personas
Route::post('/cadastrar-prof', [App\Http\Controllers\professorController::class, 'store']);

Route::post('/login-verify', [App\Http\Controllers\professorController::class, 'verifyUser']);

Route::post('/cadastrar-aluno', [App\Http\Controllers\alunoController::class, 'store']);

Route::post('/login-aluno', [App\Http\Controllers\alunoController::class, 'verifyUser']);

Route::post('/login-adm', [App\Http\Controllers\admController::class, 'verifyUser']);
