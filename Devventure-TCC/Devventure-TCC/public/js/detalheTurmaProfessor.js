document.addEventListener('DOMContentLoaded', function () {
    // Modal de Convidar Aluno
    const btnAbrirModalAluno = document.getElementById('btnAbrirModalAluno');
    const modalConvidarAluno = document.getElementById('modalConvidarAluno');

    if (btnAbrirModalAluno && modalConvidarAluno) {
        const btnCancelarAluno = modalConvidarAluno.querySelector('.btn-cancelar');
        const btnCloseAluno = modalConvidarAluno.querySelector('.modal-close');

        btnAbrirModalAluno.addEventListener('click', () => {
            modalConvidarAluno.classList.add('active');
        });

        const fecharModalAluno = () => {
            modalConvidarAluno.classList.remove('active');
        };

        btnCancelarAluno.addEventListener('click', fecharModalAluno);
        btnCloseAluno.addEventListener('click', fecharModalAluno);
    }

    // NOVO: Modal de Adicionar Aula
    const btnAbrirModalAula = document.getElementById('btnAbrirModalAula');
    const modalAdicionarAula = document.getElementById('modalAdicionarAula');

    if (btnAbrirModalAula && modalAdicionarAula) {
        const btnCancelarAula = modalAdicionarAula.querySelector('.btn-cancelar');
        const btnCloseAula = modalAdicionarAula.querySelector('.modal-close');

        btnAbrirModalAula.addEventListener('click', () => {
            modalAdicionarAula.classList.add('active');
        });

        const fecharModalAula = () => {
            modalAdicionarAula.classList.remove('active');
        };

        btnCancelarAula.addEventListener('click', fecharModalAula);
        btnCloseAula.addEventListener('click', fecharModalAula);
    }
});