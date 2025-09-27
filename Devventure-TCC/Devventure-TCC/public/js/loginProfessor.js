document.addEventListener('DOMContentLoaded', () => {
    // --- SELEÇÃO DE ELEMENTOS ---
    const form = document.getElementById('professor-form');
    const formTitle = document.getElementById('form-title');
    const submitBtn = document.getElementById('submit-btn');
    const toggleBtn = document.getElementById('toggle-btn');
    const cadastroFields = document.getElementById('cadastro-fields');
    const confirmPasswordWrapper = document.getElementById('confirm-password-wrapper');
    const avatarWrapper = document.getElementById('avatar-wrapper');

    // Captura as URLs diretamente do HTML
    const loginUrl = form.dataset.loginUrl;
    const cadastroUrl = form.dataset.cadastroUrl;

    let isLogin = true;

    function toggleFormView() {
        isLogin = !isLogin;

        if (isLogin) {
            // TELA DE LOGIN
            formTitle.textContent = 'Login Professor';
            submitBtn.textContent = 'Entrar';
            toggleBtn.innerHTML = 'Não tem conta? <strong>Cadastre-se</strong>';
            form.action = loginUrl;

            // Esconde os campos extras
            cadastroFields.style.display = 'none';
            confirmPasswordWrapper.style.display = 'none';
            avatarWrapper.style.display = 'none';

        } else {
            // TELA DE CADASTRO
            formTitle.textContent = 'Cadastro Professor';
            submitBtn.textContent = 'Cadastrar';
            toggleBtn.innerHTML = 'Já tem conta? <strong>Faça login</strong>';
            form.action = cadastroUrl;

            // Mostra os campos extras
            cadastroFields.style.display = 'block';
            confirmPasswordWrapper.style.display = 'block';
            avatarWrapper.style.display = 'flex';
        }
    }

    // Estado inicial da página (Login)
    cadastroFields.style.display = 'none';
    confirmPasswordWrapper.style.display = 'none';
    avatarWrapper.style.display = 'none';
    
    // Adiciona o Event Listener principal
    toggleBtn.addEventListener('click', toggleFormView);

    // --- LÓGICA DO AVATAR ---
    const avatarInput = document.getElementById('avatar');
    avatarWrapper.addEventListener('click', () => {
        if (!isLogin) { // Só funciona na tela de cadastro
            avatarInput.click();
        }
    });
    avatarInput.addEventListener('change', () => {
        const file = avatarInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              document.getElementById('avatar-preview').innerHTML = `
    <img src="${e.target.result}" alt="Preview">
`;
            }
            reader.readAsDataURL(file);
        }
    });

    // --- LÓGICA DAS MÁSCARAS ---
    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    cpfInput.addEventListener('input', (e) => {
        let v = e.target.value.replace(/\D/g, '');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = v;
    });
    telefoneInput.addEventListener('input', (e) => {
        let v = e.target.value.replace(/\D/g, '');
        v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
        v = v.replace(/(\d)(\d{4})$/, '$1-$2');
        e.target.value = v;
    });
});

// --- FUNÇÃO GLOBAL DE SENHA ---
function togglePassword(fieldId, iconContainer) {
    const passwordField = document.getElementById(fieldId);
    const iconEye = iconContainer.querySelector('.icon-eye');
    const iconEyeOff = iconContainer.querySelector('.icon-eye-off');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        iconEye.classList.add('d-none');
        iconEyeOff.classList.remove('d-none');
    } else {
        passwordField.type = 'password';
        iconEye.classList.remove('d-none');
        iconEyeOff.classList.add('d-none');
    }
}