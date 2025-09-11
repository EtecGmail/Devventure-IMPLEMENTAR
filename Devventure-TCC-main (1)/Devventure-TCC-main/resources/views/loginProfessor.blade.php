<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="./css/loginProfessor.css">
  <title>Login Professor</title>
</head>
<body>
  @include('layouts.navbar')

  <div class="container">
    <div class="card">
      <div class="icon">
        <!-- Ícone de perfil (SVG) -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
        </svg>
      </div>

      <h2 id="form-title">Login Professor</h2>

      <!-- FORMULÁRIO -->
      <form method="POST" action="{{ url('/login-verify') }}">
        @csrf

        <!-- Campos de Cadastro (aparecem só no modo cadastro) -->
        <div id="cadastro-fields" style="display: none;">
          <div class="form-group">
            <label for="nome">Nome completo *</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" maxlength="50">
          </div>

          <div class="form-group">
            <label for="cpf">CPF *</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" maxlength="14">
          </div>

          <div class="form-group">
            <label for="area">Área de Ensino *</label>
            <input type="text" id="area" name="area" placeholder="Digite sua área de ensino">
          </div>

          <div class="form-group">
            <label for="formacao">Formação acadêmica e experiência *</label>
            <textarea id="formacao" name="formacao" placeholder="Descreva sua formação e experiência"></textarea>
          </div>

          <div class="form-group">
            <label for="telefone">Telefone (opcional)</label>
            <input type="text" id="telefone" name="telefone" placeholder="(11) 99999-9999" maxlength="15">
          </div>
        </div>

        <!-- Campos comuns (login e cadastro) -->
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" placeholder="Digite seu email" required>
        </div>

        <!-- Campo de senha -->
        <div class="form-group senha-wrapper">
          <label for="password">Senha *</label>
          <div class="input-icon">
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
          </div>
        </div>

        <!-- Confirmar senha (só aparece no modo cadastro) -->
        <div class="form-group senha-wrapper" id="confirm-password-wrapper" style="display: none;">
          <label for="confirm_password">Confirmar senha *</label>
          <div class="input-icon">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirme sua senha">
            <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
          </div>
        </div>

        <button type="submit" id="submit-btn">Entrar</button>
      </form>

      <div class="links">
        <button type="button" id="toggle-btn">Não tem conta? Cadastre-se</button>
        <a href="/professor">Voltar para Área do Professor</a>
      </div>
    </div>
  </div>

  <script src="./js/loginProfessor.js"></script>
</body>
</html>
