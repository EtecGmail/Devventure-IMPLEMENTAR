document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const navbarLinks = document.getElementById('navbar-links');

    menuToggle.addEventListener('click', () => {
        // Alterna a classe 'active' nos links e no botão
        navbarLinks.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const profileBtn = document.getElementById('profile-dropdown-btn');
    const profileDropdown = document.getElementById('profile-dropdown');

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', (event) => {
            // Impede que o clique no botão feche o menu imediatamente
            event.stopPropagation(); 
            profileDropdown.classList.toggle('active');
        });

        // Fecha o dropdown se clicar em qualquer outro lugar da página
        window.addEventListener('click', () => {
            if (profileDropdown.classList.contains('active')) {
                profileDropdown.classList.remove('active');
            }
        });
    }

    // A lógica do modal de edição continua aqui...
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const modal = document.getElementById('edit-profile-modal');
    if(editProfileBtn && modal) {
      editProfileBtn.addEventListener('click', () => modal.style.display = 'flex');
    }
    // ...
});