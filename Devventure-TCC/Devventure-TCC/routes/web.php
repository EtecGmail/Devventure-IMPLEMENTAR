<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\alunoController;
use App\Http\Controllers\professorController;
use App\Http\Controllers\admController;
use App\Http\Controllers\AulaController; // Incluído para referência futura

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| As rotas foram agrupadas por middleware para maior clareza, mantendo
| as URLs e os nomes de rotas originais. Rotas que não tinham nome
| receberam um para facilitar a referência.
|
*/

// ===================================================================
// ROTAS PÚBLICAS E DE AUTENTICAÇÃO (Acessíveis por todos)
// ===================================================================

Route::get('/', function () {
    return view('welcome');
});

// Telas de Login
Route::get('/loginAluno', function () {
    return view('loginAluno', [
        'theme' => 'aluno',
        'userType' => 'aluno',
        'welcomeTitle' => 'Bem-vindo, Aluno!',
        'welcomeText' => 'Acesse suas turmas, aulas e exercícios em um só lugar.'
    ]);
})->name('login.aluno');
Route::get('loginProfessor', function () { return view('loginProfessor'); })->name('login.professor'); 
Route::get('/loginAdm', function () { return view('loginAdmin'); })->name('login.admin'); 


Route::post('/login-aluno', [alunoController::class, 'verifyUser'])->name('aluno.login');
Route::post('/login-verify', [professorController::class, 'verifyUser'])->name('professor.login.action');  
Route::post('/login-adm', [admController::class, 'verifyUser']);

Route::post('/cadastrar-aluno', [alunoController::class, 'store'])->name('aluno.cadastrar');
Route::post('/cadastrar-prof', [professorController::class, 'store'])->name('professor.cadastro.action');


//Rotas do ALUNO
Route::middleware('auth:aluno')->group(function () {
    Route::get('/alunoDashboard', [alunoController::class, 'alunoConvite'])->name('aluno.dashboard');
    Route::get('/minhas-turmas', [alunoController::class, 'minhasTurmas'])->name('aluno.turma');
    Route::get('/turmaAluno/{turma}', [alunoController::class, 'mostrarTurmaEspecifica'])->name('turmas.especifica');
    
    Route::get('/aulas/{aula}', [alunoController::class, 'aula'])->name('aulas.view');
    Route::post('/aulas/progresso', [alunoController::class, 'salvarProgresso'])->name('aulas.progresso');

    Route::post('/convites/{convite}/aceitar', [alunoController::class, 'aceitar'])->name('convites.aceitar');
    Route::post('/convites/{convite}/recusar', [alunoController::class, 'recusar'])->name('convites.recusar');

    Route::post('/logout-aluno', [alunoController::class, 'logoutUser'])->name('aluno.logout'); 
});


//Rotas do PROFESSOR
Route::middleware('auth:professor')->group(function () {
    Route::get('/professorDashboard', [ProfessorController::class, 'dashboard'])->name('professorDashboard');
    Route::get('/professorGerenciar', [professorController::class, 'GerenciarTurma'])->name('professor.turmas');
    Route::get('/professorGerenciarEspecifica', [professorController::class, 'turmaEspecifica'])->name('professor.turma.especifica');
    Route::get('/professorExercicios', [professorController::class, 'exercicios'])->name('professor.exercicios.index'); 
    
    Route::post('/cadastrar-turma', [professorController::class, 'turma'])->name('professor.turmas.store'); 
    Route::post('/professorCriarExercicios', [professorController::class, 'CriarExercicios'])->name('professor.exercicios.store'); 

    Route::get('/turmas/{turma}', [professorController::class, 'turmaEspecificaID'])->name('turmas.especificaID');
    Route::post('/turmas/{turma}/convidar', [professorController::class, 'convidarAluno'])->name('turmas.convidar');
    Route::post('/turmas/{turma}/aulas', [professorController::class, 'formsAula'])->name('turmas.aulas.formsAula');

    Route::post('/logout-professor', [professorController::class, 'logoutUser'])->name('professor.logout'); 
});


//Rotas ADMIN
Route::middleware('auth:admin')->group(function () {
    Route::get('/admDashboard', [admController::class, 'admDashboard'])->name('admin.dashboard'); 
    Route::post('/logout-adm', [admController::class, 'logoutUser'])->name('admin.logout'); 
});