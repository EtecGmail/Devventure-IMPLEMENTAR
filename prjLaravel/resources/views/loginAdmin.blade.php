<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin</title>
  <link rel="stylesheet" href="./css/loginAdm.css" />
  <script defer src="script.js"></script>
</head>
<body>
  @include('layouts.navbar')

  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="icon-circle">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4V5.5L12 3 8 5.5V8c0 2.21 1.79 4 4 4zm0 0v9" />
          </svg>
        </div>
        <h2>Login Admin</h2>
      </div>
      <div class="card-content">
        <form id="login-form">
          <input type="email" id="email" placeholder="Email" required />
          <input type="password" id="password" placeholder="Senha" required />
          <button type="submit" id="submit-btn">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
