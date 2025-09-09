<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/aluno.css">
  <title>Login/Cadastro Aluno</title>
</head>
<body>


  {{-- Inclui a navbar --}}
  @include('layouts.navbar')

  <div class="container">
    <div class="card">
      <div class="icon">🎓</div>
      <h2 id="form-title">Login Aluno</h2>

      <form id="aluno-form">
        <div id="cadastro-fields" style="display: none;">
          <div class="form-group">
            <label>Nome completo *</label>
            <input type="text" placeholder="Digite seu nome" maxlength="50">
          </div>

          <div class="form-group">
            <label>RA/Matrícula *</label>
            <input type="text" placeholder="Digite seu RA" maxlength="20">
          </div>

          <div class="form-group">
            <label>Semestre *</label>
            <select>
              <option value="">Selecione</option>
              <option value="1">1º Semestre</option>
              <option value="2">2º Semestre</option>
              <option value="3">3º Semestre</option>
              <option value="4">4º Semestre</option>
              <option value="5">5º Semestre</option>
              <option value="6">6º Semestre</option>
            </select>
          </div>

          <div class="form-group">
            <label>Telefone (opcional)</label>
            <input type="text" placeholder="(11) 99999-9999" maxlength="15">
          </div>
        </div>

        <div class="form-group">
          <label>Email *</label>
          <input type="email" placeholder="Digite seu email" required>
        </div>

        <div class="form-group">
          <label>Senha *</label>
          <input type="password" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" id="submit-btn">Entrar</button>
      </form>

      <div class="links">
        <button id="toggle-btn">Não tem conta? Cadastre-se</button>
        <a href="/aluno">Voltar para Área do Aluno</a>
      </div>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById("toggle-btn");
    const cadastroFields = document.getElementById("cadastro-fields");
    const formTitle = document.getElementById("form-title");
    const submitBtn = document.getElementById("submit-btn");

    let isLogin = true;

    toggleBtn.addEventListener("click", () => {
      isLogin = !isLogin;
      if (isLogin) {
        cadastroFields.style.display = "none";
        formTitle.textContent = "Login Aluno";
        submitBtn.textContent = "Entrar";
        toggleBtn.textContent = "Não tem conta? Cadastre-se";
      } else {
        cadastroFields.style.display = "block";
        formTitle.textContent = "Cadastro Aluno";
        submitBtn.textContent = "Cadastrar";
        toggleBtn.textContent = "Já tem conta? Faça login";
      }
    });
  </script>
</body>
</html>
