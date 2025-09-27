// Função para mostrar/ocultar a senha
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