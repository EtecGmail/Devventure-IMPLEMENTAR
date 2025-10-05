<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $turma->nome_turma }}</title>
    <link href="{{ asset('css/Aluno/alunoTurmaEspecifica.css') }}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <main class="page-container">
        <header class="turma-header">
            <div class="header-content">
                <a href="{{ route('aluno.turma') }}" class="back-link"><i class='bx bx-arrow-back'></i></a>
                <div class="header-info">
                    <h1>{{ $turma->nome_turma }}</h1>
                    <p>Professor(a): {{ $turma->professor->nome }}</p>
                </div>
            </div>
            <div class="header-stats">
                <div class="stat-item"><i class='bx bxs-group'></i><span>{{ $alunos->count() }} Alunos</span></div>
                <div class="stat-item"><i class='bx bxs-book-content'></i><span>{{ $exercicios->count() }} Exercícios</span></div>
                <div class="stat-item"><i class='bx bxs-videos'></i><span>{{ $aulas->count() }} Aulas</span></div>
            </div>
        </header>

        <div class="page-body">
            <div class="main-content">
                <div class="tabs-navigation">
                    <button class="tab-link active" data-tab="exercicios"><i class='bx bxs-pencil'></i> Exercícios</button>
                    <button class="tab-link" data-tab="aulas"><i class='bx bx-movie-play'></i> Aulas</button>
                </div>

                <div class="tabs-content">
                    <div class="tab-pane active" id="exercicios">
                        <div class="exercicios-grid">
                            @forelse($exercicios as $exercicio)
                                @php
                                    $entrega = null; // Substitua pela sua lógica de entrega
                                    $statusClass = 'status-pendente';
                                    $statusText = 'Pendente';
                                    $buttonText = 'Responder';

                                    if ($entrega) {
                                        $statusClass = 'status-concluido';
                                        $statusText = 'Concluído';
                                        $buttonText = 'Ver Nota';
                                    } elseif (\Carbon\Carbon::parse($exercicio->data_entrega)->isPast()) {
                                        $statusClass = 'status-atrasado';
                                        $statusText = 'Atrasado';
                                    }
                                @endphp

                                <div class="card-exercicio {{ $statusClass }}">
                                    <div class="card-exercicio-header">
                                        <h3>{{ $exercicio->nome }}</h3>
                                        <span class="status-badge">{{ $statusText }}</span>
                                    </div>
                                    <p class="descricao">{{ Str::limit($exercicio->descricao, 120) }}</p>
                                    <div class="card-exercicio-footer">
                                        <div class="data-entrega">
                                            <i class='bx bxs-calendar-exclamation'></i>
                                            <span>Entregar até: {{ \Carbon\Carbon::parse($exercicio->data_entrega)->format('d/m/Y') }}</span>
                                        </div>
                                        <a href="#" class="btn-ver-exercicio">{{ $buttonText }}</a>
                                    </div>
                                </div>
                            @empty
                                <p class="empty-message">Nenhum exercício postado nesta turma ainda.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="tab-pane" id="aulas">
                        <div class="aulas-grid">
                            @forelse($aulas as $aula)
                                <a href="{{ route('aulas.view', $aula) }}" class="card-aula">
                                    <div class="card-aula-thumbnail">
                                        <i class='bx bx-play'></i>
                                    </div>
                                    <div class="card-aula-info">
                                        <h4>{{ $aula->titulo }}</h4>
                                        <p>Clique para assistir a aula</p>
                                    </div>
                                </a>
                            @empty
                                <p class="empty-message">Nenhuma aula disponível.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <div class="sidebar-widget">
                    <h2><i class='bx bxs-group'></i> Colegas de Turma</h2>
                    <ul class="lista-alunos">
                        @forelse($alunos as $aluno)
                            <li>
                                @if ($aluno->avatar)
                                    <img src="{{ asset('storage/' . $aluno->avatar) }}" alt="Foto de {{ $aluno->nome }}" class="avatar">
                                @else
                                    <img src="https://i.pravatar.cc/40?u={{ $aluno->id }}" alt="Avatar Padrão" class="avatar">
                                @endif
                                <span>{{ $aluno->nome }}</span>
                            </li>
                        @empty
                            <li class="empty-message">Nenhum outro aluno na turma.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>
        </div>
    </main>
    
    <script src="{{ asset('js/Aluno/alunoTurma.js') }}"></script>
</body>
</html>