const toggleBtn = document.getElementById("toggle-btn");
const cadastroFields = document.getElementById("cadastro-fields");
const formTitle = document.getElementById("form-title");
const submitBtn = document.getElementById("submit-btn");
const form = document.querySelector("form"); // pega o form principal

let isLogin = true; // começa no modo login

toggleBtn.addEventListener("click", () => {
  isLogin = !isLogin;

  if (isLogin) {
    // -------- MODO LOGIN --------
    cadastroFields.style.display = "none";
    document.getElementById("confirm-password-wrapper").style.display = "none";
    formTitle.textContent = "Login Professor";
    submitBtn.textContent = "Entrar";
    toggleBtn.textContent = "Não tem conta? Cadastre-se";
    form.action = '/login-verify'; // rota do login
  } else {
    // -------- MODO CADASTRO --------
    cadastroFields.style.display = "block";
    document.getElementById("confirm-password-wrapper").style.display = "block";
    formTitle.textContent = "Cadastro Professor";
    submitBtn.textContent = "Cadastrar";
    toggleBtn.textContent = "Já tem conta? Faça login";
    form.action = '/cadastrar-prof'; // rota do cadastro
  }
});

// Função para mostrar/ocultar senha
function togglePassword(inputId, icon) {
  const input = document.getElementById(inputId);
  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🫣"; // Ícone quando a senha está visível
  } else {
    input.type = "password";
    icon.textContent = "👁️"; // Ícone quando está escondida
  }
}
