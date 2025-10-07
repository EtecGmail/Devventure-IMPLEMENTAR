// Em public/js/Professor/formValidacaoAula.js

document.addEventListener('DOMContentLoaded', function () {
    const addPerguntaBtn = document.getElementById('add-pergunta-btn');
    const perguntasContainer = document.getElementById('perguntas-container');
    
    // Inicia a contagem baseada em quantos itens já existem na tela
    let perguntaCount = perguntasContainer.getElementsByClassName('pergunta-item').length;

    addPerguntaBtn.addEventListener('click', function () {
        perguntaCount++;

        const newPerguntaItem = document.createElement('div');
        newPerguntaItem.classList.add('pergunta-item', 'mb-3');

        // USA ESTE INNERHTML, COM O LABEL VAZIO:
        newPerguntaItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <label></label>
                <button type="button" class="remove-pergunta-btn" title="Remover Pergunta">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
            <div class="input-group">
                <input type="text" name="perguntas[]" class="form-control" placeholder="Digite o texto da pergunta aqui" required>
            </div>
        `;
        
        perguntasContainer.appendChild(newPerguntaItem);
    });

    // Lógica para o botão "Remover"
    perguntasContainer.addEventListener('click', function (e) {
        const removeButton = e.target.closest('.remove-pergunta-btn');
        
        if (removeButton) {
            removeButton.closest('.pergunta-item').remove();
            
            // Re-numera as perguntas para manter a consistência visual
            const todosOsLabels = perguntasContainer.querySelectorAll('.pergunta-item label');
            perguntaCount = todosOsLabels.length; // Atualiza a contagem total
            todosOsLabels.forEach((label, index) => {
                // O CSS vai cuidar do texto, não precisamos fazer nada aqui
            });
        }
    });
});