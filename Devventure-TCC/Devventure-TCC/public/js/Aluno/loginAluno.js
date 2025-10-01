document.addEventListener('DOMContentLoaded', () => {
    // --- SELEÇÃO DE ELEMENTOS ---
    const form = document.getElementById('aluno-form');
    const formTitle = document.getElementById('form-title');
    const submitBtn = document.getElementById('submit-btn');
    const toggleBtn = document.getElementById('toggle-btn');
    const cadastroFields = document.getElementById('cadastro-fields');
    const confirmPasswordWrapper = document.getElementById('confirm-password-wrapper');
    const avatarWrapper = document.getElementById('avatar-wrapper');

    // ----> CORREÇÃO PRINCIPAL AQUI <----
    // Capturamos a URL de cadastro que veio do Blade pelo atributo data-*
    const cadastroUrl = form.dataset.cadastroUrl; 
    // Capturamos a action original do form, que é a de login
    const loginUrl = form.action; 

    let isLogin = true;

    function toggleFormView() {
        isLogin = !isLogin;

        if (isLogin) {
            // TELA DE LOGIN
            formTitle.textContent = 'Login Aluno';
            submitBtn.textContent = 'Entrar';
            toggleBtn.innerHTML = 'Não tem conta? <strong>Cadastre-se</strong>';
            
            // Usa a URL de login que guardamos
            form.action = loginUrl; 

            // Esconde os campos extras
            cadastroFields.style.display = 'none';
            confirmPasswordWrapper.style.display = 'none';
            avatarWrapper.style.display = 'none';

        } else {
            // TELA DE CADASTRO
            formTitle.textContent = 'Cadastro de Aluno';
            submitBtn.textContent = 'Cadastrar';
            toggleBtn.innerHTML = 'Já tem conta? <strong>Faça login</strong>';

            // Usa a URL de cadastro que guardamos
            form.action = cadastroUrl;

            // Mostra os campos extras
            cadastroFields.style.display = 'block';
            confirmPasswordWrapper.style.display = 'block';
            avatarWrapper.style.display = 'flex';
        }
    }

    // Por padrão, a tela é de login, então escondemos os campos de cadastro
    cadastroFields.style.display = 'none';
    confirmPasswordWrapper.style.display = 'none';
    avatarWrapper.style.display = 'none';
    
    // Adiciona o Event Listener ao botão de alternância
    toggleBtn.addEventListener('click', toggleFormView);

    // O resto do seu JS (preview de avatar, toggle de senha, etc.) continua igual...
    // ...
    const avatarInput = document.getElementById('avatar');
    avatarInput.addEventListener('change', handleAvatarChange);
    avatarWrapper.addEventListener('click', () => {
        if (!isLogin) {
            avatarInput.click();
        }
    });

    function handleAvatarChange() {
        const file = avatarInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" style="width:100%; height:100%; object-fit:cover;">`;
            }
            reader.readAsDataURL(file);
        }
    }
});

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

const telefoneInput = document.getElementById('telefone');
    
    telefoneInput.addEventListener('input', (e) => {
        let v = e.target.value.replace(/\D/g, '');
        v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
        v = v.replace(/(\d)(\d{4})$/, '$1-$2');
        e.target.value = v;
    });