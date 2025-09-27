<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/admDashboard.css') }}">
</head>
<body>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logoDevventure.png') }}" alt="Admin Logo" class="admin-logo">
                <span class="logo-text">Admin Panel</span>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#overview" class="active"><i class="fas fa-chart-line"></i><span>Visão Geral</span></a></li>
                    <li><a href="#users"><i class="fas fa-users"></i><span>Gerenciar Usuários</span></a></li>
                    <li><a href="#alunos"><i class="fas fa-user-graduate"></i><span>Alunos</span></a></li>
                    <li><a href="#professores"><i class="fas fa-chalkboard-teacher"></i><span>Professores</span></a></li>
                    <li><a href="#charts-section"><i class="fas fa-chart-pie"></i><span>Análises</span></a></li>
                    <li><a href="#settings"><i class="fas fa-cog"></i><span>Configurações</span></a></li>
                    <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Sair</span>
                    </a></li>
                </ul>
            </nav>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </aside>

        <div class="main-content">
            <header class="navbar">
                <div class="nav-left">
                    <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                    <span class="navbar-title">Dashboard Administrativo</span>
                </div>
                <div class="nav-right">
                    <span class="admin-name">Olá, Admin!</span>
                    <div class="admin-avatar">
                        <img src="{{ asset('images/adm.png') }}" alt="Admin Avatar">
                    </div>
                </div>
            </header>

            <div class="dashboard-body">
                <section id="overview" class="dashboard-section active">
                    <h2>Visão Geral</h2>
                    <div class="info-cards-grid">
                        <div class="info-card primary">
                            <i class="fas fa-user-graduate icon"></i>
                            <div class="card-content">
                                <span class="card-number" id="studentsCount">{{ $alunosCount ?? '0' }}</span>
                                <p class="card-text">Alunos Cadastrados</p>
                            </div>
                        </div>
                        <div class="info-card secondary">
                            <i class="fas fa-chalkboard-teacher icon"></i>
                            <div class="card-content">
                                <span class="card-number" id="teachersCount">{{ $professoresCount ?? '0' }}</span>
                                <p class="card-text">Professores Cadastrados</p>
                            </div>
                        </div>
                    </div>

                    <div class="charts-grid">
                        <div class="chart-card">
                            <h3>Alunos vs Professores (Proporção)</h3>
                            <div id="alunosProfessoresChart" style="height: 300px;"></div>
                        </div>
                        <div class="chart-card">
                            <h3>Alunos vs Professores (Contagem)</h3>
                            <div id="overviewBarChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </section>

                <section id="users" class="dashboard-section">
                    <h2>Gerenciar Usuários</h2>
                    <div class="card">
                        <p>Conteúdo para gerenciamento de todos os usuários (alunos e professores) em um só lugar.</p>
                    </div>
                </section>

                <section id="alunos" class="dashboard-section">
                    <h2>Alunos</h2>
                    <div class="card data-table-card">
                        <header class="card-header">
                            <h4>Lista de Alunos</h4>
                            <div class="card-actions">
                                <button class="btn btn-primary" id="addStudentBtn"><i class="fas fa-plus"></i> Adicionar</button>
                                <button class="btn btn-outline" id="exportStudentsBtn"><i class="fas fa-download"></i> Exportar</button>
                            </div>
                        </header>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>RA</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($alunosData as $aluno)
                                    <tr>
                                        <td>{{ $aluno->nome }}</td>
                                        <td>{{ $aluno->email }}</td>
                                        <td>{{ $aluno->ra }}</td>
                                        <td>
                                            <button class="btn-icon edit-btn" data-id="{{ $aluno->id }}"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete-btn" data-id="{{ $aluno->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">Nenhum aluno cadastrado.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            <button class="btn btn-sm btn-outline"><i class="fas fa-chevron-left"></i> Anterior</button>
                            <span>Página 1 de 1</span>
                            <button class="btn btn-sm btn-outline">Próximo <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </section>

                <section id="professores" class="dashboard-section">
                    <h2>Professores</h2>
                    <div class="card data-table-card">
                        <header class="card-header">
                            <h4>Lista de Professores</h4>
                            <div class="card-actions">
                                <button class="btn btn-primary" id="addTeacherBtn"><i class="fas fa-plus"></i> Adicionar</button>
                                <button class="btn btn-outline" id="exportTeachersBtn"><i class="fas fa-download"></i> Exportar</button>
                            </div>
                        </header>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>CPF</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($professoresData as $professor)
                                    <tr>
                                        <td>{{ $professor->nome }}</td>
                                        <td>{{ $professor->email }}</td>
                                        <td>{{ $professor->cpf }}</td>
                                        <td>
                                            <button class="btn-icon edit-btn" data-id="{{ $professor->id }}"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete-btn" data-id="{{ $professor->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">Nenhum professor cadastrado.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            <button class="btn btn-sm btn-outline"><i class="fas fa-chevron-left"></i> Anterior</button>
                            <span>Página 1 de 1</span>
                            <button class="btn btn-sm btn-outline">Próximo <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </section>

                <section id="charts-section" class="dashboard-section">
                    <h2>Análises e Gráficos</h2>
                    <div class="charts-grid-full">
                        <div class="chart-card">
                            <h3>Distribuição de Usuários (Pizza)</h3>
                            <div id="userDistributionPieChart" style="height: 350px;"></div>
                        </div>
                        <div class="chart-card">
                            <h3>Distribuição de Usuários (Barras)</h3>
                            <div id="userDistributionBarChart" style="height: 350px;"></div>
                        </div>
                    </div>
                </section>

                <section id="settings" class="dashboard-section">
                    <h2>Configurações</h2>
                    <div class="card">
                        <p>Área para configurações gerais do sistema, gestão de permissões de admin, etc.</p>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script>
        window.dashboardData = {
            alunosCount: {{ $alunosCount ?? 0 }},
            professoresCount: {{ $professoresCount ?? 0 }},
        };
    </script>
    <script src="{{ asset('js/admDashboard.js') }}"></script>
</body>
</html>