<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno</title>
    
    {{-- CSS da Dashboard --}}
    <link rel="stylesheet" href="{{ asset('css/alunoDashboard.css') }}">
    
    {{-- BOXICONS para ícones --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('layouts.navbar')

<main class="page-aluno-dashboard">
    <div class="container">

        <div class="page-header">
            <div class="header-text">
                <h1>Painel do Aluno</h1>
                <p>Olá, {{ Auth::guard('aluno')->user()->nome }}! Continue seus estudos.</p>
            </div>
            <a href="{{ route('aluno.turma') }}" class="btn-primary">
                <i class='bx bxs-group'></i> Acessar Minhas Turmas
            </a>
        </div>

        @if($convites->isNotEmpty())
    <div class="card card-convites-destaque">
        <h3>🔔 Você tem novos convites!</h3>
        <div class="convites-container">
            @foreach ($convites as $convite)
                <div class="convite-item">
                    <div class="convite-info">
                        <p>O professor(a) <strong>{{ $convite->turma->professor->nome }}</strong> convidou você para a turma:</p>
                        <span><i class='bx bxs-chalkboard'></i> {{ $convite->turma->nome_turma }}</span>
                    </div>
                    <div class="convite-actions">
                        <form action="{{ route('convites.aceitar', $convite) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-aceitar"><i class='bx bx-check'></i> Aceitar</button>
                        </form>
                        <form action="{{ route('convites.recusar', $convite) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-recusar"><i class='bx bx-x'></i> Recusar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

        <div class="dashboard-grid">
            
            <div class="coluna-principal">
                
                {{-- ============================================= --}}
                {{-- ========= BARRA DE PROGRESSO DINÂMICA ========= --}}
                {{-- ============================================= --}}
                <div class="card">
                    <h3><i class='bx bx-bar-chart-alt-2'></i> Seu Progresso nas Aulas</h3>
                    <p class="modulo-title">Progresso total de vídeos assistidos</p>
                    <div class="progress-bar-container">
                        <div class="progress-fill" style="width: {{ $progressoPercentual }}%;">{{ $progressoPercentual }}%</div>
                    </div>
                    <p class="progresso-detalhes">Continue assistindo às aulas para avançar.</p>
                </div>

                {{-- ============================================= --}}
                {{-- ========= EXERCÍCIOS PENDENTES DINÂMICOS ======== --}}
                {{-- ============================================= --}}
                <div class="card">
                    <h3><i class='bx bx-alarm-exclamation'></i> Próximas Entregas</h3>
                    <div class="exercicios-pendentes-list">
                        @forelse($exerciciosPendentes as $exercicio)
                            <div class="exercicio-item">
                                <div class="exercicio-info">
                                    <a href="{{ route('aluno.turmas.especifica', $exercicio->turma) }}" class="exercicio-titulo">{{ $exercicio->nome }}</a>
                                    <span class="exercicio-turma">Turma: {{ $exercicio->turma->nome_turma }}</span>
                                </div>
                                
                                @if($exercicio->data_fechamento)
                                    <div class="exercicio-prazo {{ $exercicio->data_fechamento->isToday() || $exercicio->data_fechamento->isTomorrow() ? 'prazo-urgente' : '' }}">
                                        <i class='bx bxs-calendar'></i>
                                        <span>Entrega: {{ $exercicio->data_fechamento->format('d/m/Y') }}</span>
                                    </div>
                                @else
                                    <div class="exercicio-prazo">
                                        <span>Sem data de entrega</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="empty-exercicios">
                                <i class='bx bx-check-double'></i>
                                <p>Nenhum exercício pendente. Bom trabalho!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="coluna-lateral">
<div class="card card-ranking">
    <h3>🏆 Ranking da Turma</h3>
    <ul class="ranking-list">
        <li><span>1.</span> João Silva <small>1250 pts</small></li>
        <li><span>2.</span> Maria Oliveira <small>1100 pts</small></li>
        <li class="ranking-voce"><span>3.</span> Você <small>890 pts</small></li>
        <li><span>4.</span> Carlos Souza <small>850 pts</small></li>
    </ul>
</div>

                {{-- Você pode adicionar outro card aqui se quiser, como "Últimas Aulas Adicionadas" --}}

            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
</body>
</html>