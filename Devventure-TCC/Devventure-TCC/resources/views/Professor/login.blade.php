<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 
  <link href="{{ asset('css/Professor/loginProfessor.css') }}" rel="stylesheet">
  
  <title>Área do Professor</title>
</head>
<body>
  @include('layouts.navbar')

  <main class="container">
    <div class="card">
      <h2 id="form-title">Entrar como Professor</h2>
      
      <form 
        method="POST" 
        id="professor-form" 
        enctype="multipart/form-data"
        action="{{ route('professor.login.action') }}" 
        data-login-url="{{ route('professor.login.action') }}"
        data-cadastro-url="{{ route('professor.cadastro.action') }}"
      >
        @csrf

        <div class="icon" id="avatar-wrapper" title="Clique para adicionar uma foto de perfil">
            <span id="avatar-preview">
            <img src="https://cdn-icons-png.flaticon.com/512/3342/3342176.png" alt="Ícone de perfil" width="48" height="48">
            </span>
            <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
        </div>

        <div id="cadastro-fields" style="display: none;">
          <div class="form-group">
            <label for="nome">Nome completo *</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" maxlength="50">
          </div>

          <div class="form-group">
            <label for="cpf">CPF *</label>
            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14">
          </div>

          <div class="form-group">
            <label for="area">Área de Ensino *</label>
            <input type="text" id="area" name="area" placeholder="Ex: Matemática, Programação, etc.">
          </div>

          <div class="form-group">
            <label for="formacao">Formação acadêmica e experiência *</label>
            <textarea id="formacao" name="formacao" placeholder="Descreva sua formação e experiência" rows="4"></textarea>
          </div>

          <div class="form-group">
            <label for="telefone">Telefone (opcional)</label>
            <input type="text" id="telefone" name="telefone" placeholder="(11) 99999-9999" maxlength="15">
          </div>
        </div>
        
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" placeholder="Digite seu email" required>
        </div>
        
        <div class="form-group">
          <label for="password">Senha *</label>
          <div class="senha-wrapper">
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">
              <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              <svg class="icon-eye-off d-none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            </span>
          </div>
        </div>

        <div class="form-group" id="confirm-password-wrapper" style="display: none;">
          <label for="confirm_password">Confirmar senha *</label>
          <div class="senha-wrapper">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirme sua senha">
            <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <svg class="icon-eye-off d-none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            </span>
          </div>
        </div>

        <button type="submit" id="submit-btn">Entrar</button>
      </form>

      <div class="links">
        <button type="button" id="toggle-btn">Não tem conta? <strong>Cadastre-se</strong></button>
        <a href="/professor">Esqueceu a senha?</a>
      </div>
    </div>
  </main>

  <script src="{{ asset('js/Professor/loginProfessor.js') }}"></script>
</body>
</html>