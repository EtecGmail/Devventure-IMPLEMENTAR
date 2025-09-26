<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/alunoTurmaEspecifica.css') }}"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>{{ $turma->nome_turma }}</title>
</head>
<body>


    <main class="page-turma-especifica">
    <div class="container">
        <div class="turma-header">
            <h1>{{ $turma->nome_turma }}</h1>
            <p><strong>Professor:</strong> {{ $turma->professor->nome }}</p>
            <a href="{{ route('aluno.turma') }}" class="back-link"><i class='bx bx-arrow-back'></i> Voltar para Minhas Turmas</a>
        </div>

        <div class="content-grid">
            <div class="alunos-section">
                <h2><i class='bx bxs-group'></i> Alunos na Turma</h2>
                <ul class="lista-alunos">
                    @forelse($alunos as $aluno)
                        <li>
                            <i class='bx bxs-user-circle'></i> {{ $aluno->nome }}
                        </li>
                    @empty
                        <li class="empty-message">Não há outros alunos para mostrar.</li>
                    @endforelse
                </ul>
            </div>

            <div class="exercicios-section">
                <h2><i class='bx bxs-book-content'></i> Exercícios para Fazer</h2>
                <div class="exercicios-grid">
                    @forelse($exercicios as $exercicio)
                        <div class="card-exercicio">
                            <h3>{{ $exercicio->titulo }}</h3>
                            <p>{{ $exercicio->descricao }}</p>
                            @if($exercicio->data_entrega)
                                <div class="data-entrega">
                                    <i class='bx bxs-calendar'></i>
                                    <span>Entregar até: {{ \Carbon\Carbon::parse($exercicio->data_entrega)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                            {{-- <a href="#" class="btn-ver-exercicio">Ver Exercício</a> --}}
                        </div>
                    @empty
                        <p class="empty-message">Nenhum exercício foi postado para esta turma ainda.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


        {{-- ======================================================= --}}
        {{-- =========== NOVA SEÇÃO PARA LISTAR AS AULAS =========== --}}
        {{-- ======================================================= --}}
        <div class="aulas-section">
            <h2><i class='bx bxs-videos'></i> Aulas Disponíveis</h2>
            <div class="aulas-grid">
                @forelse($aulas as $aula)
                    <a href="{{ route('aulas.view', $aula) }}" class="card-aula-link">
                        <div class="card-aula">
                            <i class='bx bx-play-circle'></i>
                            <div class="aula-info">
                                <h4>{{ $aula->titulo }}</h4>
                                <small>Clique para assistir</small>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="empty-message">Nenhuma aula foi adicionada a esta turma ainda.</p>
                @endforelse
            </div>
        </div>


    </main>


</body>
</html>