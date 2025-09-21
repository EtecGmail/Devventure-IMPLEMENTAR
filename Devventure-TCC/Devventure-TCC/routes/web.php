<?php

use App\Http\Controllers\alunoController;
use App\Http\Controllers\professorController;
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





Route::get('/alunoDashboard', [alunoController::class, 'alunoConvite'])->middleware('auth:aluno')->name('aluno.dashboard');

Route::post('/convites/{convite}/aceitar', [alunoController::class, 'aceitar'])->middleware('auth:aluno')->name('convites.aceitar');
Route::post('/convites/{convite}/recusar', [alunoController::class, 'recusar'])->middleware('auth:aluno')->name('convites.recusar');

Route::get('/minhas-turmas', [alunoController::class, 'minhasTurmas'])->middleware('auth:aluno')->name('aluno.turma');
Route::get('/turmaAluno/{turma}', [alunoController::class, 'mostrarTurmaEspecifica'])->middleware('auth:aluno')->name('turmas.especifica');


Route::post('/logout-aluno', [App\Http\Controllers\alunoController::class, 'logoutUser'])->middleware('auth:aluno');




// Professor
Route::get('loginProfessor', function () {
    return view('loginProfessor');
});
Route::get('/professorDashboard', function () {
    return view('professorDashboard');
})->middleware('auth:professor');
Route::get('/professorGerenciar', [App\Http\Controllers\professorController::class, 'GerenciarTurma'])->middleware('auth:professor');
Route::get('/professorGerenciarEspecifica', [App\Http\Controllers\professorController::class, 'turmaEspecifica'])->middleware('auth:professor');
Route::post('/professorCriarExercicios', [App\Http\Controllers\professorController::class, 'CriarExercicios'])->middleware('auth:professor');
Route::get('/professorExercicios',[App\Http\Controllers\professorController::class, 'exercicios'])->middleware('auth:professor');
Route::post('/logout-professor', [App\Http\Controllers\professorController::class, 'logoutUser'])->middleware('auth:professor');
Route::post('/cadastrar-turma', [App\Http\Controllers\professorController::class, 'turma'])->middleware('auth:professor');
Route::get('/turmas/{turma}',[App\Http\Controllers\professorController::class, 'turmaEspecificaID'])->middleware('auth:professor')->name('turmas.especificaID');

Route::post('/turmas/{turma}/convidar', [professorController::class, 'convidarAluno'])->middleware('auth:professor')->name('turmas.convidar');


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
