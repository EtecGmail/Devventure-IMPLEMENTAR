<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="./css/admDashboard.css">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="sidebar-title">Menu Principal</h2>
      <div class="divider"></div>
      <nav>
        <ul>
          <li><a href="#resumo"><i class="fas fa-home"></i> Resumo</a></li>
          <li><a href="#alunos"><i class="fas fa-user-graduate"></i> Alunos</a></li>
          <li><a href="#professores"><i class="fas fa-chalkboard-teacher"></i> Professores</a></li>
          <li><a href="#graficos"><i class="fas fa-chart-bar"></i> Gráficos</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Conteúdo -->
    <main class="main">
      <!-- Resumo -->
      <section id="resumo" class="card">
        <h3>Resumo</h3>
        <div class="summary">
          <div>
            <span id="studentsCount">0</span>
            <p>Alunos cadastrados</p>
          </div>
          <div>
            <span id="teachersCount">0</span>
            <p>Professores cadastrados</p>
          </div>
        </div>
      </section>

      <!-- Alunos -->
      <section id="alunos" class="card">
        <header class="card-header">
          <h3>Alunos</h3>
          <div>
            <button class="btn" id="addStudentBtn">Adicionar</button>
            <button class="btn-outline" id="exportStudentsBtn">Exportar</button>
          </div>
        </header>
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>RA</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="studentsTable"></tbody>
        </table>
        <div class="pagination">
          <button id="prevStudent">Anterior</button>
          <span id="studentPageInfo">1/1</span>
          <button id="nextStudent">Próximo</button>
        </div>
      </section>

      <!-- Professores -->
      <section id="professores" class="card">
        <header class="card-header">
          <h3>Professores</h3>
          <div>
            <button class="btn" id="addTeacherBtn">Adicionar</button>
            <button class="btn-outline" id="exportTeachersBtn">Exportar</button>
          </div>
        </header>
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>CPF</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="teachersTable"></tbody>
        </table>
        <div class="pagination">
          <button id="prevTeacher">Anterior</button>
          <span id="teacherPageInfo">1/1</span>
          <button id="nextTeacher">Próximo</button>
        </div>
      </section>

     <section class="grid">
  <div class="card">
    <h4>Controle de Conteúdo</h4>
    <p>Área para upload e organização de aulas, exercícios e vídeos (em breve).</p>
  </div>
  <div class="card">
    <h4>Relatórios e Métricas</h4>
    <p>Estatísticas de acesso às aulas e desempenho médio dos alunos serão exibidas aqui.</p>
  </div>
  <div class="card">
    <h4>Configurações de Segurança</h4>
    <p>Gestão de permissões e políticas de autenticação planejadas para próximas versões.</p>
  </div>
  <div class="card">
    <h4>Comunicação e Suporte</h4>
    <p>Sistema de mensagens e central de ajuda em desenvolvimento.</p>
  </div>
  <div class="card wide">
    <h4>Integrações e Personalização</h4>
    <p>Integração com serviços externos e opções de tema serão disponibilizadas futuramente.</p>
  </div>
  <div class="card wide">
    <h4>Sistema Responsivo</h4>
    <p>Este dashboard agora se adapta perfeitamente a dispositivos móveis, tablets e desktops.</p>
  </div>
</section>
    </main>
  </div>
  <script src="./js/admDashboard.js"></script>
</body>
</html>
