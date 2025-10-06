document.addEventListener('DOMContentLoaded', function() {
    // --- Lógica existente para modais (continua igual) ---
    const btnAbrirModalAluno = document.getElementById('btnAbrirModalAluno');
    const modalConvidarAluno = document.getElementById('modalConvidarAluno');
    const btnAbrirModalAula = document.getElementById('btnAbrirModalAula');
    const modalAdicionarAula = document.getElementById('modalAdicionarAula');

    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    if (btnAbrirModalAluno) {
        btnAbrirModalAluno.addEventListener('click', () => openModal('modalConvidarAluno'));
    }
    if (btnAbrirModalAula) {
        btnAbrirModalAula.addEventListener('click', () => openModal('modalAdicionarAula'));
    }

    document.querySelectorAll('.modal-close, .btn-cancelar').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal-overlay');
            if (modal) {
                closeModal(modal.id);
            }
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // --- LÓGICA PARA SWEETALERT2 ---
    if (window.flashMessages) {
        const sweetSuccessConvite = window.flashMessages.sweetSuccessConvite;
        const sweetErrorConvite = window.flashMessages.sweetErrorConvite;
        
        // Convite de Aluno - Sucesso
        if (sweetSuccessConvite && sweetSuccessConvite !== "") {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Seu convite foi enviado!",
                showConfirmButton: false,
                timer: 1500
            });
        }

        // Convite de Aluno - Erro
        if (sweetErrorConvite && sweetErrorConvite !== "") {
            Swal.fire({
                icon: "error",
                title: "Convite não enviado",
                text: "O Aluno já está em uma Turma!",
                draggable: true
            });
        }


    }

    
    // Verifica se a variável 'aulaCriadaFeedback' (que criamos no Blade) existe
    if (typeof aulaCriadaFeedback !== 'undefined') {
            
        Swal.fire({
            icon: 'success',
            title: aulaCriadaFeedback.message, 
            html: 'Deseja criar um formulário de validação para esta aula agora?',
            
            showCancelButton: true,
            confirmButtonColor: '#00796B', // Sua cor primária
            cancelButtonColor: '#6c757d',
            confirmButtonText: aulaCriadaFeedback.next_action_text, // "Criar Formulário de Validação"
            cancelButtonText: 'Fazer isso depois',

        }).then((result) => {
            // Se o professor clicou no botão de confirmação ("Criar Formulário...")
            if (result.isConfirmed) {
                // Redireciona para a URL que o controller nos enviou
                window.location.href = aulaCriadaFeedback.next_action_url;
            }
        });
    }

     if (typeof formularioCriadoSuccess !== 'undefined') {
        
        Swal.fire({
            position: "top-end", 
            icon: "success",
            title: formularioCriadoSuccess,
            showConfirmButton: false,
            timer: 2000
        });
    }

   

});