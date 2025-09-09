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
