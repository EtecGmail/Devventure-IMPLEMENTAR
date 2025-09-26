<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Turma: {{ $turma->nome_turma }}</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/detalheTurma.css') }}">
</head>
<body>

<main class="page-detalhe-turma">
    <div class="container">

        
        <header class="page-header">
            <div class="header-content">
                <a href="{{ url()->previous() }}" class="btn-voltar-mobile"><i class='bx bx-arrow-back'></i></a>
                <div>
                    <h1>{{ $turma->nome_turma }}</h1>
                    <p>Disciplina: {{ $turma->disciplina ?? 'Não especificada' }} | Turno: {{ ucfirst($turma->turno) }}</p>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn-acao" id="btnAbrirModalAula"><i class='bx bx-video-plus'></i> Adicionar Aula</button>
                <button class="btn-acao" id="btnAbrirModalAluno"><i class='bx bx-user-plus'></i> Convidar Aluno</button>
                <a href="{{ url('/professorGerenciarEspecifica') }}" class="btn-voltar-desktop"><i class='bx bx-arrow-back'></i> Voltar</a>
            </div>
        </header>

        
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        
        <div class="content-grid">
            
            
            <section class="card lista-alunos">
                <h2><i class='bx bxs-group'></i> Alunos Matriculados ({{ $alunos->count() }})</h2>
                <ul>
                    @forelse ($alunos as $aluno)
                        <li>{{ $aluno->nome }}<span>{{ $aluno->email }}</span></li>
                    @empty
                        <li class="empty-item">Nenhum aluno matriculado nesta turma ainda.</li>
                    @endforelse
                </ul>
            </section>

            
            <section class="card lista-exercicios">
                <h2><i class='bx bxs-spreadsheet'></i> Exercícios da Turma ({{ $exercicios->count() }})</h2>
                <ul>
                    @forelse ($exercicios as $exercicio)
                        <li>{{ $exercicio->nome }}<span>Entrega até: {{ \Carbon\Carbon::parse($exercicio->data_fechamento)->format('d/m/Y') }}</span></li>
                    @empty
                        <li class="empty-item">Nenhum exercício cadastrado para esta turma.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </div>
</main>


<div class="modal-overlay" id="modalConvidarAluno">
    <div class="modal-content">
        <form action="{{ route('turmas.convidar', $turma) }}" method="POST">
            @csrf
            <button type="button" class="modal-close"><i class='bx bx-x'></i></button>
            <h2><i class='bx bx-user-plus'></i> Convidar Aluno para a Turma</h2>
            <p>Digite o Registro do Aluno (RA/RM) para enviar um convite de participação para <strong>{{ $turma->nome_turma }}</strong>.</p>
            <input type="text" name="ra" placeholder="Digite o RA do aluno" required autocomplete="off">
            <div class="modal-buttons">
                <button type="button" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-confirmar">Enviar Convite</button>
            </div>
        </form>
    </div>
</div>


<div class="modal-overlay" id="modalAdicionarAula">
    <div class="modal-content">
        <form action="{{ route('turmas.aulas.formsAula', $turma) }}" method="POST">
            @csrf
            <button type="button" class="modal-close"><i class='bx bx-x'></i></button>
            <h2><i class='bx bx-video-plus'></i> Adicionar Nova Aula</h2>
            <p>Preencha os dados abaixo para cadastrar uma nova aula em vídeo para a turma.</p>
            <div class="form-group">
                <label for="titulo">Título da Aula</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="video_url">Link do Vídeo (YouTube)</label>
                <input type="url" id="video_url" name="video_url" required>
            </div>
            <div class="form-group">
                <label for="duracao_segundos">Duração (em segundos)</label>
                <input type="number" id="duracao_segundos" name="duracao_segundos" required>
            </div>
            <div class="modal-buttons">
                <button type="button" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-confirmar">Adicionar Aula</button>
            </div>
        </form>
    </div>
</div>


<script src="{{ asset('js/detalheTurmaProfessor.js') }}"></script>
</body>
</html>