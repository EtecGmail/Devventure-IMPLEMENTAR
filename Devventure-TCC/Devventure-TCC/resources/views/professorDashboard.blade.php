<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Área do Professor</title>
  <link rel="stylesheet" href="./css/professorDashboard.css" />
</head>
<body>

  @include('layouts.navbar')

  

<div class="dashboard-wrapper">
  
  <div class="container">
<header class="header">
  <div class="header-left">
    <h1>Área do Professor</h1>
    <p>Gerencie suas aulas, materiais e acompanhe o progresso dos alunos</p>
  </div>


  <div class="header-right">
    <div class="user-menu">
      <button class="user-button" id="userButton">
        <img src="{{ Auth::guard('professor')->user()->avatar ?? '/images/default-avatar.png' }}" alt="Avatar" class="user-avatar">
        <span class="user-name">{{ Auth::guard('professor')->user()->nome }}</span>
        <span class="caret">▾</span>
      </button>

      <div class="user-dropdown" id="userDropdown">
        <a href="{{ url('/professor/perfil') }}">
          <span class="dropdown-icon">✏️</span> Editar Perfil
        </a>
        <form method="POST" action="{{ url('/logout-professor') }}">
          @csrf
          <button type="submit">
            <span class="dropdown-icon">🚪</span> Sair
          </button>
        </form>
      </div>
    </div>
  </div>
</header>



    <!-- Quick Actions -->
    <section class="quick-actions">
      <div class="card action-card green">
        <div class="icon">+</div>
        <h3>Nova Aula</h3>
        <p>Criar nova aula</p>
      </div>
      <div class="card action-card blue">
        <div class="icon">📄</div>
        <h3>Exercícios</h3>
        <p>Adicionar exercícios</p>
      </div>
      <div class="card action-card purple">
        <div class="icon">🎥</div>
        <h3>Vídeos</h3>
        <p>Upload de vídeos</p>
      </div>
      <div id="blocoTurmas" class="card action-card orange">
        <div class="icon">👥</div>
        <h3>Turmas</h3>
        <p>Adicionar Turma</p>
      </div>
    </section>

    <!-- Main content grid -->
    <main class="main-content">
      <section class="recent-classes">
        <div class="card">
          <header>
            <h2><span class="calendar-icon">📅</span> Aulas Recentes</h2>
          </header>
          <div class="class-list">
            <article class="class-item ongoing">
              <div>
                <h4>Introdução à Lógica de Programação</h4>
                <p>Hoje, 14:00 • 25 alunos</p>
              </div>
              <span class="status green">Em andamento</span>
            </article>
            <article class="class-item completed">
              <div>
                <h4>Estruturas Condicionais</h4>
                <p>Ontem, 16:00 • 23 alunos</p>
              </div>
              <span class="status blue">Concluída</span>
            </article>
            <article class="class-item scheduled">
              <div>
                <h4>Laços de Repetição</h4>
                <p>15/01, 14:00 • 24 alunos</p>
              </div>
              <span class="status yellow">Agendada</span>
            </article>
          </div>
        </div>

        <div class="card mt-2">
          <header>
            <h2><span class="users-icon">👥</span> Gerenciamento de Turmas</h2>
          </header>
          <p>
            Aqui você pode editar ou excluir turmas existentes, visualizar detalhes e gerenciar os alunos de cada turma.
          </p>

          <div class="turmas-list">
            <div class="turma-item">
              <span>Turma A - Manhã</span>
              <div class="actions">
                <button class="btn btn-edit">✏️ Editar</button>
                <button class="btn btn-delete">🗑️ Excluir</button>
              </div>
            </div>
            <div class="turma-item">
              <span>Turma B - Tarde</span>
              <div class="actions">
                <button class="btn btn-edit">✏️ Editar</button>
                <button class="btn btn-delete">🗑️ Excluir</button>
              </div>
            </div>
          </div>

          <button class="btn btn-primary full-width mt-3">Ver Todas as Turmas</button>
        </div>
      </section>

      <aside class="stats-section">
        <div class="card">
          <header><h2>Estatísticas</h2></header>
          <div class="stats">
            <div class="stat-item">
              <div class="number blue">127</div>
              <div class="label">Total de Alunos</div>
            </div>
            <div class="stat-item">
              <div class="number green">23</div>
              <div class="label">Aulas Criadas</div>
            </div>
            <div class="stat-item">
              <div class="number purple">89%</div>
              <div class="label">Taxa de Conclusão</div>
            </div>
          </div>
        </div>

        <div class="card mt-2">
          <header><h2>Dúvidas Recentes</h2></header>
          <div class="duvidas-list">
            <div class="duvida-item">
              <p>Como usar loops while?</p>
              <button class="btn btn-ghost">Responder</button>
            </div>
            <div class="duvida-item">
              <p>Diferença entre if e switch?</p>
              <button class="btn btn-ghost">Responder</button>
            </div>
            <div class="duvida-item">
              <p>Exercício 3 - Dúvida</p>
              <button class="btn btn-ghost">Responder</button>
            </div>
          </div>
        </div>
      </aside>
    </main>
  </div>
 <footer>
      @include('layouts.footer')
    </footer>

</div>



  <script src="./js/professorDashboard.js"></script>
</body>
</html>
