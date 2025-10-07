// public/js/Aluno/loginAluno.js

document.addEventListener('DOMContentLoaded', () => {
    // --- SELEÇÃO DE ELEMENTOS ---
    const form = document.getElementById('aluno-form');
    const formTitle = document.getElementById('form-title');
    const submitBtn = document.getElementById('submit-btn');
    const toggleBtn = document.getElementById('toggle-btn');
    const cadastroFields = document.getElementById('cadastro-fields');
    const confirmPasswordWrapper = document.getElementById('confirm-password-wrapper');
    const avatarWrapper = document.getElementById('avatar-wrapper');
    const loginUrl = form.dataset.loginUrl || "{{ route('aluno.login') }}";
    const cadastroUrl = form.dataset.cadastroUrl;

    let isLogin = true;

    function toggleFormView() {
        isLogin = !isLogin;
        if (isLogin) {
            formTitle.textContent = 'Entrar como Aluno';
            submitBtn.textContent = 'Entrar';
            toggleBtn.innerHTML = 'Não tem conta? <strong>Cadastre-se</strong>';
            form.action = loginUrl;
            cadastroFields.style.display = 'none';
            confirmPasswordWrapper.style.display = 'none';
            avatarWrapper.style.display = 'none';
        } else {
            formTitle.textContent = 'Cadastrar como Aluno';
            submitBtn.textContent = 'Cadastrar';
            toggleBtn.innerHTML = 'Já tem conta? <strong>Faça login</strong>';
            form.action = cadastroUrl;
            cadastroFields.style.display = 'block';
            confirmPasswordWrapper.style.display = 'block';
            avatarWrapper.style.display = 'flex';
        }
    }

    cadastroFields.style.display = 'none';
    confirmPasswordWrapper.style.display = 'none';
    avatarWrapper.style.display = 'none';
    toggleBtn.addEventListener('click', toggleFormView);

    // --- LÓGICA DO AVATAR ---
    const avatarInput = document.getElementById('avatar');
    avatarWrapper.addEventListener('click', () => {
        if (!isLogin) {
            avatarInput.click();
        }
    });
    avatarInput.addEventListener('change', () => {
        const file = avatarInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').innerHTML = `<img src="${e.target.result}" alt="Preview" style="width:100%; height:100%; object-fit:cover;">`;
            }
            reader.readAsDataURL(file);
        }
    });

    // ===============================================
    // ========= NOVO BLOCO DE MÁSCARA (INÍCIO) =========
    // ===============================================
    const telefoneInput = document.getElementById('telefone');

    if (telefoneInput) {
        telefoneInput.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
            v = v.replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = v;
        });
    }
    // ===============================================
    // ========= NOVO BLOCO DE MÁSCARA (FIM) ===========
    // ===============================================

    // --- ALERTA SWEETALERT2 DE SUCESSO ---
    if (window.flashMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Cadastro Realizado!',
            text: window.flashMessage,
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    }

    // --- VALIDAÇÃO DE SENHA EM TEMPO REAL ---
    const passwordInput = document.getElementById('password');
    const passwordFeedback = document.getElementById('password-feedback');
    
    if (passwordInput && passwordFeedback) {
        passwordInput.addEventListener('input', () => {
            if (!isLogin) { 
                const senha = passwordInput.value;
                if (senha.length === 0) {
                    passwordFeedback.textContent = '';
                    passwordFeedback.className = 'password-feedback';
                } else if (senha.length < 8) {
                    passwordFeedback.textContent = 'A senha deve ter no mínimo 8 caracteres.';
                    passwordFeedback.className = 'password-feedback invalido';
                } else {
                    passwordFeedback.textContent = '✓ Tamanho de senha válido!';
                    passwordFeedback.className = 'password-feedback valido';
                }
            } else {
                passwordFeedback.textContent = '';
            }
        });
    }
});

// --- FUNÇÃO GLOBAL PARA MOSTRAR/ESCONDER SENHA ---
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