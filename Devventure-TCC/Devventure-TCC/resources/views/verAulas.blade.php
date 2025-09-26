<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <meta name="csrf-token" content="{{ csrf_token() }}">
     
    <title>{{ $aula->titulo }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/verAulaAluno.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>


<main class="page-ver-aula">
    <div class="container">
        <header class="aula-header">
            <h1>{{ $aula->titulo }}</h1>
            <p class="turma-info"><i class='bx bxs-chalkboard'></i> Turma: {{ $aula->turma->nome_turma }}</p>
        </header>

        <div id="video-wrapper" 
             data-video-id="{{ $videoId }}" 
             data-aula-id="{{ $aula->id }}" 
             data-progress-url="{{ route('aulas.progresso') }}">

            <div class="video-container">
                @if($videoId)
                    <div id="player-iframe-id"></div> {{-- O YouTube vai substituir este div --}}
                @else
                    <p class="video-invalido">Link de vídeo inválido ou não encontrado.</p>
                @endif
            </div>
        </div>
        
        <div class="status-video" id="status-video">
            <p><i class='bx bx-info-circle'></i> Assista ao vídeo até o final para liberar o questionário.</p>
        </div>

        {{-- O restante do seu HTML para o quiz continua aqui --}}
        <div id="quiz-container" class="quiz-container" style="display: none;">
            {{-- ... seu formulário do quiz ... --}}
        </div>
    </div>
</main>


{{-- 1. Carrega a API do YouTube --}}
<script src="https://www.youtube.com/iframe_api"></script>

{{-- 2. Carrega o NOSSO arquivo JS, que agora vai controlar tudo --}}
<script src="{{ asset('js/verAulas.js') }}"></script>

</body>
</html>