<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Turmas</title>

    
    <link rel="stylesheet" href="{{ asset('css/alunoTurma.css') }}"> 
    
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    @include('layouts.navbar') 

    <main class="page-minhas-turmas">
        <div class="container">
            <div class="page-header"> 
                <h1>Minhas Turmas</h1>
                <p>Selecione uma turma para ver os detalhes e atividades.</p>
                <a href="{{ route('aluno.dashboard') }}" class="back-dashboard-link">
                    <i class='bx bx-arrow-back'></i> Voltar para o Painel
                </a>
            </div>

            <div class="turmas-grid">
                @forelse($turmas as $turma)
                    <a href="{{ route('turmas.especifica', $turma) }}" class="card-link">
                        <div class="card">
                            <h3>{{ $turma->nome_turma }}</h3>
                            <p class="professor-nome">Prof. {{ $turma->professor->nome }}</p>
                            <div class="tags">
                                <span class="tag">{{ ucfirst($turma->turno) }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="empty-message">Você ainda não está matriculado em nenhuma turma.</p>
                @endforelse
            </div>
        </div>
    </main>

    @include('layouts.footer') 
    
    
    <script src="{{ asset('js/turmaAluno.js') }}"></script>

</body>
</html>