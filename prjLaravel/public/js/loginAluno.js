const toggleBtn = document.getElementById("toggle-btn");
const cadastroFields = document.getElementById("cadastro-fields");
const formTitle = document.getElementById("form-title");
const submitBtn = document.getElementById("submit-btn");
const form = document.getElementById("aluno-form");

const avatarPreview = document.getElementById("avatar-preview");
const avatarInput = document.getElementById("avatar");

let isLogin = true;

// Alternar entre Login e Cadastro
toggleBtn.addEventListener("click", () => {
  isLogin = !isLogin;

  if (isLogin) {
    // LOGIN
    cadastroFields.style.display = "none";
    document.getElementById("confirm-password-wrapper").style.display = "none";
    formTitle.textContent = "Login Aluno";
    submitBtn.textContent = "Entrar";
    toggleBtn.textContent = "Não tem conta? Cadastre-se";
    form.action = "/login-aluno";

    // Ícone fixo 🎓
    avatarPreview.textContent = "🎓";
    avatarPreview.style.cursor = "default";
    avatarPreview.style.backgroundImage = "none"; // remove caso tenha imagem
    avatarInput.value = ""; // limpa seleção de arquivo
  } else {
    // CADASTRO
    cadastroFields.style.display = "block";
    document.getElementById("confirm-password-wrapper").style.display = "block";
    formTitle.textContent = "Cadastro Aluno";
    submitBtn.textContent = "Cadastrar";
    toggleBtn.textContent = "Já tem conta? Faça login";
    form.action = "/cadastrar-aluno";

    // Ícone clicável 🎓 (upload)
    avatarPreview.textContent = "🎓";
    avatarPreview.style.cursor = "pointer";
    avatarPreview.style.backgroundImage = "none";
  }
});

// Mostrar/Ocultar senha
function togglePassword(inputId, icon) {
  const input = document.getElementById(inputId);
  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🫣";
  } else {
    input.type = "password";
    icon.textContent = "👁️";
  }
}

// Upload de avatar (só funciona no cadastro)
avatarPreview.addEventListener("click", () => {
  if (!isLogin) {
    avatarInput.click();
  }
});

avatarInput.addEventListener("change", () => {
  const file = avatarInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      avatarPreview.textContent = ""; // remove o emoji
      avatarPreview.style.backgroundImage = `url(${e.target.result})`;
      avatarPreview.style.backgroundSize = "cover";
      avatarPreview.style.backgroundPosition = "center";
      avatarPreview.style.borderRadius = "50%";
    };
    reader.readAsDataURL(file);
  }
});
