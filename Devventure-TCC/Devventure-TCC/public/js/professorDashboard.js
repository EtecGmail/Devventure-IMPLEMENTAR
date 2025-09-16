document.querySelectorAll('.btn-edit').forEach(btn => {
  btn.addEventListener('click', () => alert('Editar turma clicada!'));
});

document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', () => alert('Excluir turma clicada!'));
});

document.querySelectorAll('.btn-ghost').forEach(btn => {
  btn.addEventListener('click', () => alert('Responder dúvida clicada!'));
});

document.querySelector('.btn-primary').addEventListener('click', () => {
  alert('Ver todas as turmas clicado!');
});


const userButton = document.getElementById('userButton');
const userDropdown = document.getElementById('userDropdown');

userButton.addEventListener('click', () => {
    userDropdown.classList.toggle('show');
});

// Fecha ao clicar fora
window.addEventListener('click', function(e) {
    if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.remove('show');
    }
});
