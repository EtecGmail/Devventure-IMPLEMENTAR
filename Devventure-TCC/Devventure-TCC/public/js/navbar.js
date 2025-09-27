document.addEventListener('DOMContentLoaded', () => {

    // --- LÓGICA PARA CONTROLAR OS DROPDOWNS DE PERFIL ---
    const dropdownButtons = document.querySelectorAll('.profile-button');
    dropdownButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            // Encontra o dropdown específico relacionado a este botão
            const dropdown = button.nextElementSibling;
            // Fecha outros dropdowns abertos antes de abrir o novo
            document.querySelectorAll('.profile-dropdown-content.active').forEach(d => {
                if (d !== dropdown) d.classList.remove('active');
            });
            dropdown.classList.toggle('active');
        });
    });

    // Fecha os dropdowns se clicar fora
    window.addEventListener('click', () => {
        document.querySelectorAll('.profile-dropdown-content.active').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    });


    // --- LÓGICA INTELIGENTE PARA ABRIR QUALQUER MODAL ---
    const modalTriggers = document.querySelectorAll('.modal-trigger');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modalId = trigger.dataset.modalTarget; // Lê o atributo ex: '#edit-aluno-modal'
            const modal = document.querySelector(modalId);
            if (modal) {
                modal.style.display = 'flex';
            }
        });
    });

    // --- LÓGICA INTELIGENTE PARA FECHAR QUALQUER MODAL ---
    const modalCloseButtons = document.querySelectorAll('.modal-close');
    modalCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.dataset.modalClose; // Lê o atributo ex: '#edit-aluno-modal'
            const modal = document.querySelector(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Fecha o modal se clicar no fundo escuro
    const modalOverlays = document.querySelectorAll('.modal-overlay');
    modalOverlays.forEach(modal => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

});