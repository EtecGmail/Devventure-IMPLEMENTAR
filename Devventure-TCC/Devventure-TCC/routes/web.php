<?php

use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});

//Telas de Login
Route::get('loginAluno', function () { return view('Aluno.login'); })->name('login.aluno');
Route::get('loginProfessor', function () { return view('Professor.login'); })->name('login.professor');
Route::get('/loginAdm', function () { return view('Adm.login'); })->name('login.admin');

//ações de Login
Route::post('/login-aluno', [App\Http\Controllers\Auth\AlunoLoginController::class, 'verifyUser'])->name('aluno.login');
Route::post('/login-verify', [App\Http\Controllers\Auth\ProfessorLoginController::class, 'verifyUser'])->name('professor.login.action');
Route::post('/login-adm', [App\Http\Controllers\Auth\AdmLoginController::class, 'verifyUser']); 

//Ações de Cadastro
Route::post('/cadastro-aluno', [App\Http\Controllers\Aluno\PerfilController::class, 'store'])->name('aluno.cadastrar');
Route::post('/cadastrar-prof', [App\Http\Controllers\Professor\PerfilController::class, 'store'])->name('professor.cadastro.action');



// ROTAS DO ALUNO 
Route::middleware('auth:aluno')->group(function () {
    Route::get('/alunoDashboard', \App\Http\Controllers\Aluno\DashboardController::class)->name('aluno.dashboard');
    Route::post('/logout-aluno', [App\Http\Controllers\Auth\AlunoLoginController::class, 'logoutUser'])->name('aluno.logout');

    Route::get('/minhas-turmas', [App\Http\Controllers\Aluno\TurmaController::class, 'minhasTurmas'])->name('aluno.turma');
    Route::get('/turmaAluno/{turma}', [App\Http\Controllers\Aluno\TurmaController::class, 'mostrarTurmaEspecifica'])->name('turmas.especifica');

    Route::get('/aula/{aula}', [App\Http\Controllers\Aluno\AulaController::class, 'aula'])->name('aulas.view');
    Route::post('/aula/progresso', [App\Http\Controllers\Aluno\AulaController::class, 'salvarProgresso'])->name('aulas.progresso');

    Route::post('/convite/{convite}/aceitar', [App\Http\Controllers\Aluno\ConviteController::class, 'aceitar'])->name('convites.aceitar');
    Route::post('/convite/{convite}/recusar', [App\Http\Controllers\Aluno\ConviteController::class, 'recusar'])->name('convites.recusar');

    Route::get('/aluno/perfil', [App\Http\Controllers\Aluno\PerfilController::class, 'edit'])->name('aluno.perfil.edit');
    Route::patch('/aluno/perfil', [App\Http\Controllers\Aluno\PerfilController::class, 'update'])->name('aluno.perfil.update');
});



// ROTAS DO PROFESSOR
Route::middleware('auth:professor')->group(function () {
    Route::get('/professorDashboard', [App\Http\Controllers\Professor\DashboardController::class, 'dashboard'])->name('professorDashboard');
    Route::post('/logout-professor', [App\Http\Controllers\Auth\ProfessorLoginController::class, 'logoutUser'])->name('professor.logout');

    
    Route::get('/perfilProfessor', [App\Http\Controllers\Professor\PerfilController::class, 'edit'])->name('professor.perfil.edit');
    Route::patch('/perfilProfessorUpdate', [App\Http\Controllers\Professor\PerfilController::class, 'update'])->name('professor.perfil.update');

    
    Route::get('/professorGerenciar', [App\Http\Controllers\Professor\TurmaController::class, 'GerenciarTurma'])->name('professor.turmas');
    Route::get('/professorGerenciarEspecifica', [App\Http\Controllers\Professor\TurmaController::class, 'turmaEspecifica'])->name('professor.turma.especifica');
    Route::post('/cadastrar-turma', [App\Http\Controllers\Professor\TurmaController::class, 'turma'])->name('professor.turmas.store');
    Route::get('/turmas/{turma}', [App\Http\Controllers\Professor\TurmaController::class, 'turmaEspecificaID'])->name('turmas.especificaID');
    Route::post('/turmas/{turma}/convidar', [App\Http\Controllers\Professor\TurmaController::class, 'convidarAluno'])->name('turmas.convidar');
    Route::post('/turmas/{turma}/aulas', [App\Http\Controllers\Professor\TurmaController::class, 'formsAula'])->name('turmas.aulas.formsAula');

    
    Route::get('/professorExercicios', [App\Http\Controllers\Professor\ExercicioController::class, 'exercicios'])->name('professor.exercicios.index');
    Route::post('/professorCriarExercicios', [App\Http\Controllers\Professor\ExercicioController::class, 'CriarExercicios'])->name('professor.exercicios.store');

    Route::get('/professor/aulas/{aula}/formulario/create', [App\Http\Controllers\Professor\FormularioController::class, 'create'])->name('formularios.create');
    Route::post('/professor/aulas/{aula}/formulario', [App\Http\Controllers\Professor\FormularioController::class, 'store'])->name('formularios.store');
});



// ROTAS DO ADMIN 
Route::middleware('auth:admin')->group(function () {
    Route::get('/admDashboard', [App\Http\Controllers\Adm\DashboardController::class, 'admDashboard'])->name('admin.dashboard');
    Route::post('/logout-adm', [App\Http\Controllers\Auth\AdmLoginController::class, 'logoutUser'])->name('admin.logout');

    Route::get('/admin/dashboard/search/alunos', [App\Http\Controllers\Adm\DashboardController::class, 'searchAlunos'])->name('admin.search.alunos');
    Route::get('/admin/dashboard/search/professores', [App\Http\Controllers\Adm\DashboardController::class, 'searchProfessores'])->name('admin.search.professores');

    Route::get('/admin/alunos/search', [App\Http\Controllers\Adm\DashboardController::class, 'searchAlunos'])->name('admin.alunos.search');

    Route::get('/admin/professores/search', [App\Http\Controllers\Adm\DashboardController::class, 'searchProfessores'])->name('admin.professores.search');

    Route::post('/admin/alunos/{aluno}/block', [App\Http\Controllers\Adm\DashboardController::class, 'blockAluno'])->name('admin.alunos.block');
    Route::post('/admin/alunos/{aluno}/unblock', [App\Http\Controllers\Adm\DashboardController::class, 'unblockAluno'])->name('admin.alunos.unblock');


    Route::post('/admin/professores/{professor}/block', [App\Http\Controllers\Adm\DashboardController::class, 'blockProfessor'])->name('admin.professores.block');
    Route::post('/admin/professores/{professor}/unblock', [App\Http\Controllers\Adm\DashboardController::class, 'unblockProfessor'])->name('admin.professores.unblock');
});