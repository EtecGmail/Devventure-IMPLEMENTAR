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


    {{-- O botão voltar pode ficar aqui, se preferir --}}
    <a href="/professorDashboard" class="btn-voltar">
        <i class='bx bx-chevron-left'></i>
        Voltar
    </a>

    <main>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    {{-- Seção de Cabeçalho --}}
    <section class="intro-turma">
        <h1>Turma: {{ $turma->nome_turma }}</h1>
        <p>Disciplina: {{ $turma->disciplina }} | Turno: {{ ucfirst($turma->turno) }}</p>
    </section>

        {{-- Seção de Alunos --}}
        <section class="lista-alunos">
            <h2>Alunos Matriculados ({{ $alunos->count() }})</h2>
            <div class="container-botao">
                 <button class="btn-adicionar">Adicionar Aluno</button>
            </div>
            <ul>
                @forelse ($alunos as $aluno)
                    <li>{{ $aluno->nome }} - {{ $aluno->email }}</li>
                @empty
                    <li>Nenhum aluno matriculado nesta turma ainda.</li>
                @endforelse
            </ul>
        </section>

        {{-- Seção de Exercícios --}}
        <section class="lista-exercicios">
            <h2>Exercícios da Turma ({{ $exercicios->count() }})</h2>
            <ul>
                @forelse ($exercicios as $exercicio)
                    <li>{{ $exercicio->nome }} - Entrega até: {{ \Carbon\Carbon::parse($exercicio->data_fechamento)->format('d/m/Y') }}</li>
                @empty
                    <li>Nenhum exercício cadastrado para esta turma.</li>
                @endforelse
            </ul>
        </section>
    </main>

  <div class="modal-overlay" id="modalAdicionarAluno" style="display: none;">
    <div class="modal-content">
        <form action="{{ route('turmas.convidar', $turma) }}" method="POST">
            @csrf
            <h2>Convidar Aluno para a Turma</h2>

            <p>Digite o Registro do Aluno (RA/RM) para enviar um convite de participação para <strong>{{ $turma->nome_turma }}</strong>.</p>
            
            <input type="text" name="ra" placeholder="Digite o RA do aluno" required autocomplete="off">

            <div class="modal-buttons">
                <button type="button" class="btn-cancelar">Cancelar</button>
                
                <button type="submit" class="btn-confirmar">Enviar Convite</button>
            </div>
        </form>
    </div>
</div>

{{-- Script para mostrar mensagens de sucesso ou erro --}}
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

    {{-- 4. CAMINHO DO JS CORRIGIDO --}}
    <script src="{{ asset('js/detalheTurmaProfessor.js') }}"></script>
</body>
</html>