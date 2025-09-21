document.addEventListener('DOMContentLoaded', function() {
        // Encontra o botão e o modal no HTML
        const btnAdicionar = document.querySelector('.btn-adicionar');
        // Supondo que o seu modal tenha o ID 'modalAdicionarAluno'
        const modal = document.getElementById('modalAdicionarAluno'); 
        const btnCancelar = modal.querySelector('.btn-cancelar'); // Botão de cancelar DENTRO do modal

        // Lógica para abrir e fechar
        if (btnAdicionar && modal && btnCancelar) {
            btnAdicionar.addEventListener('click', () => {
                modal.style.display = 'flex';
            });

            btnCancelar.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }
    });