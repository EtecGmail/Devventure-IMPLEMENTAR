<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./css/alunoDashboard.css">
  <title>Área do Aluno</title>

</head>
<body>

  @include('layouts.navbar')
  <div class="container">
    <!-- Header -->
    <h1>Área do Aluno</h1>
    <p>Continue seus estudos em lógica de programação</p>

    <!-- Progresso -->
    <div class="card">
      <h3>Seu Progresso</h3>
      <p>Módulo: Lógica de Programação Básica</p>
      <div class="progress-bar">
        <div class="progress-fill"></div>
      </div>
      <p>67% concluído — Aula 8 de 12 (faltam 4)</p>
    </div>

    <div class="grid">
      <!-- Coluna Principal -->
      <div>
        <!-- Próxima Aula -->
        <div class="card">
          <div class="lesson">
            <div class="lesson-icon">📘</div>
            <div>
              <h3>Estruturas de Repetição - Parte 2</h3>
              <p>Aprenda sobre loops while e do-while com exemplos práticos</p>
              <a href="#" class="btn">Continuar Aula</a>
            </div>
          </div>
        </div>

        <!-- Atividades Recentes -->
        <div class="card">
          <h3>Atividades Recentes</h3>
          <div class="activity">
            <span>📄 Exercício: Calculadora Simples</span>
            <span>✅ 85%</span>
          </div>
          <div class="activity">
            <span>🎬 Vídeo: Introdução aos Arrays</span>
            <span>✅ 100%</span>
          </div>
          <div class="activity">
            <span>🏆 Desafio: Jogo da Adivinhação</span>
            <span>⏳ Pendente</span>
          </div>
        </div>

        <!-- Ofensiva -->
        <div class="card streak">
          <h3>🔥 Sua Ofensiva Atual</h3>
          <div class="streak-days">7 dias</div>
          <p>Continue assim para não perder sua ofensiva!</p>
        </div>
      </div>

      <!-- Sidebar -->
      <div>
        <!-- Ranking -->
        <div class="card">
          <h3>🏆 Ranking da Turma</h3>
          <div class="ranking-item">1. Ana Silva <strong>950</strong></div>
          <div class="ranking-item">2. João Santos <strong>920</strong></div>
          <div class="ranking-item highlight">3. Você <strong>890</strong></div>
          <div class="ranking-item">4. Maria Costa <strong>875</strong></div>
          <div class="ranking-item">5. Pedro Lima <strong>860</strong></div>
        </div>

        <!-- Fórum -->
        <div class="card">
          <h3>💬 Fórum de Dúvidas</h3>
          <div class="forum-question">Como debugar um código? <br><a href="#" class="btn-outline">Ver discussão</a></div>
          <div class="forum-question">Diferença entre função e procedimento? <br><a href="#" class="btn-outline">Ver discussão</a></div>
          <div class="forum-question">Ajuda com exercício 5 <br><a href="#" class="btn-outline">Ver discussão</a></div>
          <a href="#" class="btn-outline">Fazer uma pergunta</a>
        </div>
      </div>
    </div>
  </div>

@include('layouts.footer')


</body>
</html>
