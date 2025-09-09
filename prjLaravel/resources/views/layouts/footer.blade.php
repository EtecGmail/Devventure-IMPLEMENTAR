<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer DevVenture</title>
  <link rel="stylesheet" href="./css/footer.css">
</head>
<body>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-grid">
      
      <!-- Logo e descrição -->
      <div class="footer-section">
        <div class="footer-logo">
          <img src="./images/LOGO-removebg.png" alt="DevVenture logo">
          <span>DevVenture</span>
        </div>
        <p class="footer-description">
          Plataforma educacional da equipe Harpion para conectar professores e alunos da ETEC Guaianazes.
        </p>
      </div>

      <!-- Links rápidos -->
      <div class="footer-section">
        <h3>Links Rápidos</h3>
        <ul>
          <li><a href="/">Início</a></li>
          <li><a href="/professor">Área do Professor</a></li>
          <li><a href="/aluno">Área do Aluno</a></li>
          <li><a href="/professor/login">Login Professor</a></li>
          <li><a href="/aluno/login">Login Aluno</a></li>
        </ul>
      </div>

      <!-- Contato -->
      <div class="footer-section">
        <h3>Contato</h3>
        <div class="footer-contact">
          <div class="footer-contact-item">📧 harpion@etecguaianazes.sp.gov.br</div>
          <div class="footer-contact-item">📞 (11) 2551-3547</div>
          <div class="footer-contact-item">
            📍 Rua Feliciano de Mendonça, 290, Guaianazes – SP, CEP: 08460-365
          </div>
        </div>
      </div>

      <!-- Equipe e tecnologias -->
      <div class="footer-section">
        <h3>Equipe Harpion</h3>
        <p class="footer-description">
          Projeto de conclusão de curso de estudantes de Desenvolvimento de Sistemas da ETEC Guaianazes.
        </p>
        <h4>Tecnologias:</h4>
        <div class="footer-techs">
          <span>PHP</span>
          <span>Laravel</span>
          <span>HTML</span>
          <span>CSS</span>
          <span>JS</span>
        </div>
      </div>

    </div>

    <!-- Rodapé inferior -->
    <div class="footer-bottom">
      <div class="footer-copy">
        © <span id="year"></span> Equipe Harpion - ETEC Guaianazes. Todos os direitos reservados.
      </div>
      <div class="footer-links">
        <a href="#">Política de Privacidade</a>
        <a href="#">Termos de Uso</a>
        <a href="#">Suporte</a>
      </div>
    </div>
  </div>
</footer>

<script>
  document.getElementById('year').textContent = new Date().getFullYear();
</script>

</body>
</html>
