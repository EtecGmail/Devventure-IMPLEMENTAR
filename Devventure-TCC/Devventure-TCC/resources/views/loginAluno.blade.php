<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/aluno.css">
  <title>Login Aluno</title>
</head>
<body>
  @include('layouts.navbar')

  <div class="container">
    <div class="card">
      <!-- ICONE: Login fixo, Cadastro clicável -->
      <div class="icon" id="avatar-wrapper">
        <span id="avatar-preview" style="font-size: 60px;">🎓</span>
        <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
      </div>

      <h2 id="form-title">Login Aluno</h2>

      <form method="POST" action="{{ url('/login-aluno') }}" id="aluno-form" enctype="multipart/form-data">
        @csrf

        <!-- CAMPOS DE CADASTRO -->
        <div id="cadastro-fields" style="display: none;">
          <div class="form-group">
            <label for="nome">Nome completo *</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" maxlength="50">
          </div>

          <div class="form-group">
            <label for="ra">RA/Matrícula *</label>
            <input type="text" id="ra" name="ra" placeholder="Digite seu RA" maxlength="20">
          </div>

          <div class="form-group">
            <label for="semestre">Semestre *</label>
            <select id="semestre" name="semestre">
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
            <label for="telefone">Telefone (opcional)</label>
            <input type="text" id="telefone" name="telefone" placeholder="(11) 99999-9999" maxlength="15">
          </div>
        </div>

        <!-- CAMPOS COMUNS -->
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" placeholder="Digite seu email" required>
        </div>

        <!-- SENHA COM OLHO -->
        <div class="form-group senha-wrapper">
          <label for="password">Senha *</label>
          <div class="input-icon">
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
          </div>
        </div>

        <!-- CONFIRMAR SENHA (só no cadastro) -->
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
        <a href="/aluno">Voltar para Área do Aluno</a>
      </div>
    </div>
  </div>

  <script src="./js/loginAluno.js"></script>
</body>
</html>
