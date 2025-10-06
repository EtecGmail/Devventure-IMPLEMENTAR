 // Espera o HTML ser totalmente carregado para executar o script
    document.addEventListener('DOMContentLoaded', function() {
        
        // Encontra o botão e a lista de colegas pelos seus seletores
        const btnToggleColegas = document.querySelector('.btn-toggle-colegas');
        const listaColegas = document.getElementById('lista-colegas');

        // Garante que os dois elementos existem na página antes de continuar
        if (btnToggleColegas && listaColegas) {
            
            // Adiciona o "ouvinte" de clique ao botão
            btnToggleColegas.addEventListener('click', () => {

                // Verifica se a lista está escondida
                if (listaColegas.style.display === 'none') {
                    // Se estiver, mostra a lista e muda o texto do botão
                    listaColegas.style.display = 'flex'; // Usamos 'flex' porque a <ul> é um container flex
                    btnToggleColegas.textContent = 'Ocultar colegas';
                } else {
                    // Se estiver visível, esconde a lista e volta o texto original
                    listaColegas.style.display = 'none';
                    btnToggleColegas.textContent = 'Ver colegas de turma ({{ $colegas->count() }})';
                }
            });
        }
    });