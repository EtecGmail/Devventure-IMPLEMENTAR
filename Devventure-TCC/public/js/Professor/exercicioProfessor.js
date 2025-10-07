document.addEventListener('DOMContentLoaded', function() {
    
    const abrirBtn = document.querySelector('.add-exercicio button');
    const modal = document.getElementById('modal');
    const cancelarBtn = document.getElementById('cancelar');

    if (abrirBtn && modal && cancelarBtn) {
        abrirBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        cancelarBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    // Lógica para o campo de arquivo principal
    const inputArquivo = document.getElementById('arquivo');
    const spanNomeArquivo = document.getElementById('nomeArquivo');

    if (inputArquivo && spanNomeArquivo) {
        inputArquivo.addEventListener('change', function() {
            if (this.files.length > 0) {
                spanNomeArquivo.textContent = this.files[0].name;
            } else {
                spanNomeArquivo.textContent = 'Nenhum arquivo selecionado';
            }
        });
    }

    // Lógica para o campo de imagem de apoio
    const inputImagemApoio = document.getElementById('imagem_apoio');
    const spanNomeImagemApoio = document.getElementById('nomeImagemApoio');

    if (inputImagemApoio && spanNomeImagemApoio) {
        inputImagemApoio.addEventListener('change', function() {
            if (this.files.length > 0) {
                spanNomeImagemApoio.textContent = this.files[0].name;
            } else {
                spanNomeImagemApoio.textContent = 'Nenhuma imagem selecionada';
            }
        });
    }

    // Lógica para o botão "Ver Tudo"
    const btnVerTudo = document.getElementById('btnVerTudo');
    const exerciciosScroll = document.querySelector('.exercicios-scroll');

    if (btnVerTudo && exerciciosScroll) {
        btnVerTudo.addEventListener('click', () => {
            exerciciosScroll.classList.toggle('expandido');
            
            if (exerciciosScroll.classList.contains('expandido')) {
                btnVerTudo.textContent = 'Mostrar em linha';
            } else {
                btnVerTudo.textContent = 'Ver tudo';
            }
        });
    }
});