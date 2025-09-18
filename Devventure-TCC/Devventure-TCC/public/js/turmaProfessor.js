 const abrirBtn = document.querySelector('.add-turma button');
    const modal = document.getElementById('modal');
    const cancelarBtn = document.getElementById('cancelar');

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


    const btnVerTudo = document.getElementById('btnVerTudo');
const exerciciosScroll = document.querySelector('.turmas-scroll');


btnVerTudo.addEventListener('click', () => {
  exerciciosScroll.classList.toggle('expandido');

  // Troca o texto do botão
  if (exerciciosScroll.classList.contains('expandido')) {
    btnVerTudo.textContent = 'Mostrar em grade';
  } else {
    btnVerTudo.textContent = 'Ver tudo';
  }
});
