// Exemplo simples para abrir/fechar sidebar em mobile
const toggleBtn = document.getElementById('toggleSidebarBtn');
const sidebar = document.getElementById('sidebar');

toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('collapsed');
});

// dados  são carregados diretamente pelo controller do Laravel (admController) 
// e renderizados na view Blade.


  