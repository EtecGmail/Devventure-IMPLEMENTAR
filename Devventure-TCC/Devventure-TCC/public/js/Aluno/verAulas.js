// Pega o container do vídeo que tem nossos dados
const videoWrapper = document.getElementById('video-wrapper');
// Pega os dados dos atributos data-*
const videoId = videoWrapper ? videoWrapper.dataset.videoId : null;
const aulaId = videoWrapper ? videoWrapper.dataset.aulaId : null;
const progressUrl = videoWrapper ? videoWrapper.dataset.progressUrl : null;

// Variável global para o player do YouTube
let player;

// A API do YouTube chama esta função GLOBAL quando está pronta.
// É crucial que ela esteja no escopo global (fora de outros listeners).
function onYouTubeIframeAPIReady() {
    console.log("API do YouTube está pronta.");

    // Verifica se existe um ID de vídeo antes de criar o player
    if (videoId) {
        console.log("Criando player para o vídeo com ID:", videoId);
        player = new YT.Player('player-iframe-id', {
            height: '360',
            width: '640',
            videoId: videoId,
            playerVars: {
                'playsinline': 1,
                'autoplay': 1, // Tenta iniciar o vídeo automaticamente (pode ser bloqueado pelo navegador)
                'rel': 0 // Não mostrar vídeos relacionados no final
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    } else {
        console.error("ID do vídeo não encontrado. Não é possível criar o player.");
    }
}

// Função executada quando o player está pronto
function onPlayerReady(event) {
    console.log("Player está pronto.");
    // A cada 10 segundos, tentamos salvar o progresso
    setInterval(salvarProgresso, 10000);
}

// Função executada quando o estado do player muda (play, pause, fim)
function onPlayerStateChange(event) {
    const quizContainer = document.getElementById('quiz-container');
    const statusVideo = document.getElementById('status-video');
    
    // Se o vídeo terminou (estado 0)
    if (event.data == YT.PlayerState.ENDED) {
        console.log("O vídeo terminou. Mostrando o quiz.");
        if (quizContainer) quizContainer.style.display = 'block';
        if (statusVideo) statusVideo.style.display = 'none';

        // Garante que o progresso final seja salvo como 100%
        salvarProgresso(true);
    }
}

// Função que envia o progresso para o backend
function salvarProgresso(final = false) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (player && (player.getPlayerState() === YT.PlayerState.PLAYING || final)) {
        
        let tempoAtual = player.getCurrentTime();
        let duracaoTotal = player.getDuration();
        
        if (final && duracaoTotal > 0) {
            tempoAtual = duracaoTotal;
        }

        console.log(`Salvando progresso: ${Math.round(tempoAtual)} segundos.`);

        fetch(progressUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                aula_id: aulaId,
                segundos_assistidos: Math.round(tempoAtual)
            })
        })
        .then(response => response.json())
        .then(data => console.log('Progresso salvo:', data))
        .catch(error => console.error('Erro ao salvar progresso:', error));
    }
}