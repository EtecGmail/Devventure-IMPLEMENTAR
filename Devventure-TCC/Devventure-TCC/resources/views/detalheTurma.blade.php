<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/detalheTurma.css" />
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Detalhes da Turma: {{ $turma->nome_turma }}</title>
    
   
</head>
<body>

 <a href="/professorDashboard" class="btn-voltar">
            <i class='bx bx-chevron-left'></i>
            Voltar
</a>

    <main>
        {{-- Seção de Cabeçalho --}}
        <section class="intro-turma">
            <h1>Turma: {{ $turma->nome_turma }}</h1>
            <p>Disciplina: {{ $turma->disciplina }} | Turno: {{ ucfirst($turma->turno) }}</p>
        </section>

        {{-- Seção de Alunos --}}
        <section class="lista-alunos">
            <h2>Alunos Matriculados ({{ $alunos->count() }})</h2>
            <button class="btn-adicionar">Adicionar Aluno</button>
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


</body>
</html>