<?php

use Illuminate\Support\Facades\Route;
// ADICIONE ESTAS DUAS LINHAS NO TOPO:
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// --- Importe seus Controllers ---
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\AlunoLoginController;
use App\Http\Controllers\Auth\ProfessorLoginController;
use App\Http\Controllers\Auth\AdmLoginController;
use App\Http\Controllers\Aluno\PerfilController as AlunoPerfilController;
use App\Http\Controllers\Professor\PerfilController as ProfessorPerfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PÁGINAS PÚBLICAS E FORMULÁRIOS DE LOGIN ---

Route::get('/', function () {
    return view('welcome');
});

// Telas de Login
Route::get('loginAluno', function () { return view('Aluno.login'); })->name('login.aluno');
Route::get('loginProfessor', function () { return view('Professor.login'); })->name('login.professor');
Route::get('/loginAdm', function () { return view('Adm.login'); })->name('login.admin');


// --- FLUXO DE AUTENTICAÇÃO, CADASTRO E 2FA ---

// 1. Ação de Cadastro
Route::post('/cadastro-aluno', [AlunoPerfilController::class, 'store'])->name('aluno.cadastrar');
Route::post('/cadastrar-prof', [ProfessorPerfilController::class, 'store'])->name('professor.cadastro.action');

// 2. Ação de Login (que agora leva para a tela de 2FA)
Route::post('/login-aluno', [AlunoLoginController::class, 'verifyUser'])->name('aluno.login');
Route::post('/login-professor', [ProfessorLoginController::class, 'verifyUser'])->name('professor.login.action');
Route::post('/login-adm', [AdmLoginController::class, 'verifyUser']); 

// 3. Verificação de Duas Etapas (2FA) - Onde o usuário digita o código
Route::get('/verificar-codigo', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify.form');
Route::post('/verificar-codigo', [TwoFactorController::class, 'verifyCode'])->name('2fa.verify.code');

// ==========================================================
// ====== BLOCO ADICIONADO PARA VERIFICAÇÃO DE E-MAIL ======
// ==========================================================
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    // Redireciona para o dashboard correto após a verificação
    if (Auth::user() instanceof \App\Models\Professor) {
        return redirect()->route('professorDashboard');
    }
    return redirect()->route('aluno.dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Um novo link de verificação foi enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// ==========================================================


// --- ROTAS PROTEGIDAS ---

// ROTAS DO ALUNO (agora exigem login E e-mail verificado)
Route::middleware(['auth:aluno'])->group(function () {
    Route::get('/alunoDashboard', \App\Http\Controllers\Aluno\DashboardController::class)->name('aluno.dashboard');
    Route::post('/logout-aluno', [AlunoLoginController::class, 'logoutUser'])->name('aluno.logout');
    // ... (suas outras rotas de aluno)
    Route::get('/minhas-turmas', [App\Http\Controllers\Aluno\TurmaController::class, 'minhasTurmas'])->name('aluno.turma');
    Route::get('/turmaAluno/{turma}', [App\Http\Controllers\Aluno\TurmaController::class, 'mostrarTurmaEspecifica'])->name('turmas.especifica');
    Route::get('/aula/{aula}', [App\Http\Controllers\Aluno\AulaController::class, 'aula'])->name('aulas.view');
    Route::post('/aula/progresso', [App\Http\Controllers\Aluno\AulaController::class, 'salvarProgresso'])->name('aulas.progresso');
    Route::post('/convite/{convite}/aceitar', [App\Http\Controllers\Aluno\ConviteController::class, 'aceitar'])->name('convites.aceitar');
    Route::post('/convite/{convite}/recusar', [App\Http\Controllers\Aluno\ConviteController::class, 'recusar'])->name('convites.recusar');
    Route::get('/aluno/perfil', [AlunoPerfilController::class, 'edit'])->name('aluno.perfil.edit');
    Route::patch('/aluno/perfil', [AlunoPerfilController::class, 'update'])->name('aluno.perfil.update');
});


// ROTAS DO PROFESSOR (agora exigem login E e--mail verificado)
Route::middleware(['auth:professor'])->group(function () {
    Route::get('/professorDashboard', [App\Http\Controllers\Professor\DashboardController::class, 'dashboard'])->name('professorDashboard');
    Route::post('/logout-professor', [ProfessorLoginController::class, 'logoutUser'])->name('professor.logout');
    // ... (suas outras rotas de professor)
    Route::get('/perfilProfessor', [ProfessorPerfilController::class, 'edit'])->name('professor.perfil.edit');
    Route::patch('/perfilProfessorUpdate', [ProfessorPerfilController::class, 'update'])->name('professor.perfil.update');
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


// ROTAS DO ADMIN (mantidas como estavam)
Route::middleware('auth:admin')->group(function () {
    Route::get('/admDashboard', [App\Http\Controllers\Adm\DashboardController::class, 'admDashboard'])->name('admin.dashboard');
    Route::post('/logout-adm', [AdmLoginController::class, 'logoutUser'])->name('admin.logout');
    // ... Suas outras rotas de admin ...
});