document.addEventListener('DOMContentLoaded', function() {
    // --- Lógica existente para modais ---
    const btnAbrirModalAluno = document.getElementById('btnAbrirModalAluno');
    const modalConvidarAluno = document.getElementById('modalConvidarAluno');
    const btnAbrirModalAula = document.getElementById('btnAbrirModalAula');
    const modalAdicionarAula = document.getElementById('modalAdicionarAula');

    // Funções para abrir/fechar modais
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    // Event Listeners para abrir modais
    if (btnAbrirModalAluno) {
        btnAbrirModalAluno.addEventListener('click', () => openModal('modalConvidarAluno'));
    }
    if (btnAbrirModalAula) {
        btnAbrirModalAula.addEventListener('click', () => openModal('modalAdicionarAula'));
    }

    // Event Listeners para fechar modais
    document.querySelectorAll('.modal-close, .btn-cancelar').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal-overlay');
            if (modal) {
                closeModal(modal.id);
            }
        });
    });

    // Fechar modal ao clicar fora (no overlay)
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // --- NOVO CÓDIGO PARA SWEETALERT2 ---
    if (window.flashMessages) { // Garante que window.flashMessages existe
        const sweetSuccessConvite = window.flashMessages.sweetSuccessConvite;
        const sweetErrorConvite = window.flashMessages.sweetErrorConvite;
        const sweetSuccessAula = window.flashMessages.sweetSuccessAula;
        // const sweetErrorAula = window.flashMessages.sweetErrorAula; // Se você definir

        // Convite de Aluno - Sucesso
        if (sweetSuccessConvite && sweetSuccessConvite !== "") { // Verifica se a string não está vazia
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Seu convite foi enviado!", // Usar o texto fixo que você pediu
                showConfirmButton: false,
                timer: 1500
            });
        }

        // Convite de Aluno - Erro
        if (sweetErrorConvite && sweetErrorConvite !== "") { // Verifica se a string não está vazia
            Swal.fire({
                icon: "error",
                title: "Convite não enviado", // Título fixo que você pediu
                text: "O Aluno já está em uma Turma!", // Texto fixo que você pediu
                draggable: true
            });
        }

        // Adicionar Aula - Sucesso
        if (sweetSuccessAula && sweetSuccessAula !== "") { // Verifica se a string não está vazia
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: 'Aula Criada!',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
}); // Fim do DOMContentLoaded