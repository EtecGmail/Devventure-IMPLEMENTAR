document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const sections = document.querySelectorAll('.dashboard-section');
    const navLinks = document.querySelectorAll('.sidebar-nav ul li a');
    const menuToggle = document.getElementById('menuToggle');
    let activeCharts = [];

    //-----------------------------------------
    //  FUNÇÃO PRINCIPAL PARA TROCAR DE ABA
    //-----------------------------------------
    function showSection(targetId) {
        // 1. Atualiza os links da barra lateral
        navLinks.forEach(item => {
            if (item.getAttribute('href') === '#' + targetId) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // 2. Mostra a seção correta e esconde as outras
        sections.forEach(section => {
            if (section.id === targetId) {
                section.classList.add('active');
                // Inicializa os gráficos para a seção que acabou de ficar ativa
                initSectionCharts(targetId);
            } else {
                section.classList.remove('active');
            }
        });
    }
    
    //-----------------------------------------
    //  LÓGICA QUE RODA AO CARREGAR A PÁGINA
    //-----------------------------------------
    function handlePageLoad() {
        // Pega a âncora da URL (ex: "alunos" de "...#alunos")
        const hash = window.location.hash.substring(1);
        
        // Se existir uma âncora na URL (vindo da paginação), usa ela.
        // Se não, usa 'overview' como padrão.
        const initialSectionId = hash || 'overview';
        
        showSection(initialSectionId);
    }

    // Executa a função assim que a página carrega
    handlePageLoad();

    //-----------------------------------------------------
    //  EVENTOS DE CLIQUE E REDIMENSIONAMENTO (Seu código)
    //-----------------------------------------------------
    
    // Toggle Sidebar
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
    }
    
    // Navegação pelas abas ao clicar
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            // Atualiza a URL sem recarregar a página
            history.pushState(null, '', '#' + targetId);
            showSection(targetId);
        });
    });

    // Redimensionamento dos gráficos
    window.addEventListener('resize', function() {
        activeCharts.forEach(chart => {
            if (chart && chart.resize) {
                chart.resize();
            }
        });
    });

    //---------------------------------------------------
    //  INICIALIZAÇÃO DE GRÁFICOS (Seu código, sem alteração)
    //---------------------------------------------------
    function initSectionCharts(sectionId) {
        activeCharts.forEach(chart => {
            if (chart && chart.dispose) {
                chart.dispose();
            }
        });
        activeCharts = [];

        const dashboardData = window.dashboardData;
        const alunosCount = dashboardData.alunosCount;
        const professoresCount = dashboardData.professoresCount;
        const alunosProfessoresChartData = [
            { value: alunosCount, name: 'Alunos' },
            { value: professoresCount, name: 'Professores' }
        ];

        if (sectionId === 'overview') {
            if (document.getElementById('alunosProfessoresChart')) {
                const alunosProfessoresChart = echarts.init(document.getElementById('alunosProfessoresChart'));
                alunosProfessoresChart.setOption({
                    tooltip: { trigger: 'item', formatter: '{a} <br/>{b} : {c} ({d}%)' },
                    legend: { orient: 'vertical', left: 'left', data: ['Alunos', 'Professores'] },
                    series: [{ name: 'Contagem', type: 'pie', radius: '50%', data: alunosProfessoresChartData, emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)' } } }],
                    color: ['#4299e1', '#a0aec0']
                });
                activeCharts.push(alunosProfessoresChart);
            }
            if (document.getElementById('overviewBarChart')) {
                const overviewBarChart = echarts.init(document.getElementById('overviewBarChart'));
                overviewBarChart.setOption({
                    title: { text: 'Alunos vs Professores', subtext: 'Contagem Absoluta', left: 'center', textStyle: { fontSize: 14 }, subtextStyle: { fontSize: 10 } },
                    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
                    xAxis: { type: 'category', data: ['Alunos', 'Professores'], axisLabel: { fontSize: 10, fontWeight: 'bold' } },
                    yAxis: { type: 'value', name: 'Número de Usuários', nameLocation: 'middle', nameGap: 25, axisLabel: { formatter: '{value}' } },
                    series: [{ name: 'Quantidade', type: 'bar', data: [{ value: alunosCount, name: 'Alunos', itemStyle: { color: '#4299e1' } }, { value: professoresCount, name: 'Professores', itemStyle: { color: '#a0aec0' } }], barWidth: '50%', emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)' } }, label: { show: true, position: 'top', formatter: '{c}', fontSize: 10 } }]
                });
                activeCharts.push(overviewBarChart);
            }
        }
        if (sectionId === 'charts-section') {
            if (document.getElementById('userDistributionPieChart')) {
                const userDistributionPieChart = echarts.init(document.getElementById('userDistributionPieChart'));
                userDistributionPieChart.setOption({
                    title: { text: 'Alunos vs Professores', subtext: 'Proporção Geral', left: 'center' },
                    tooltip: { trigger: 'item', formatter: '{a} <br/>{b} : {c} ({d}%)' },
                    legend: { orient: 'vertical', left: 'left', top: 'bottom', data: ['Alunos', 'Professores'] },
                    series: [{ name: 'Distribuição', type: 'pie', radius: '55%', center: ['50%', '60%'], data: alunosProfessoresChartData, emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)' } }, label: { formatter: '{b}: {c} ({d}%)' } }],
                    color: ['#4299e1', '#a0aec0']
                });
                activeCharts.push(userDistributionPieChart);
            }
            if (document.getElementById('userDistributionBarChart')) {
                const userDistributionBarChart = echarts.init(document.getElementById('userDistributionBarChart'));
                userDistributionBarChart.setOption({
                    title: { text: 'Alunos vs Professores', subtext: 'Contagem Absoluta', left: 'center' },
                    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
                    xAxis: { type: 'category', data: ['Alunos', 'Professores'], axisLabel: { fontSize: 12, fontWeight: 'bold' } },
                    yAxis: { type: 'value', name: 'Número de Usuários', axisLabel: { formatter: '{value}' } },
                    series: [{ name: 'Quantidade', type: 'bar', data: [{ value: alunosCount, name: 'Alunos', itemStyle: { color: '#4299e1' } }, { value: professoresCount, name: 'Professores', itemStyle: { color: '#a0aec0' } }], barWidth: '40%', emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)' } }, label: { show: true, position: 'top', formatter: '{c}' } }]
                });
                activeCharts.push(userDistributionBarChart);
            }
        }
    }

const searchAlunosForm = document.getElementById('searchAlunosForm');
const searchAlunosInput = document.getElementById('searchAlunosInput');
const alunosTableBody = document.getElementById('alunosTableBody');
const alunosPagination = document.getElementById('alunosPagination');

searchAlunosForm.addEventListener('submit', function(event) {
    // A linha MAIS IMPORTANTE: Impede que o formulário recarregue a página.
    event.preventDefault();

    const query = searchAlunosInput.value;

    
    if (query.length === 0) {
        window.location.href = '/admDashboard#alunos'; 
        return;
    }
    
    
    fetch(`/admin/alunos/search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            alunosPagination.style.display = 'none';
            alunosTableBody.innerHTML = ''; 

            if (data.length > 0) {
                data.forEach(aluno => {
                    const row = `
                        <tr>
                            <td>${aluno.nome}</td>
                            <td>${aluno.email}</td>
                            <td>${aluno.ra}</td>
                            <td>
                                <button class="btn-icon edit-btn" data-id="${aluno.id}"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon delete-btn" data-id="${aluno.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    alunosTableBody.innerHTML += row;
                });
            } else {
                alunosTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum resultado encontrado.</td></tr>';
            }
        });
});



const searchProfessoresForm = document.getElementById('searchProfessoresForm');
const searchProfessoresInput = document.getElementById('searchProfessoresInput');
const professoresTableBody = document.getElementById('professoresTableBody');
const professoresPagination = document.getElementById('professoresPagination');

searchProfessoresForm.addEventListener('submit', function(event) {
    event.preventDefault(); 

    const query = searchProfessoresInput.value;
    
    if (query.length === 0) {
        window.location.href = '/admDashboard#professores'; 
        return;
    }

    fetch(`/admin/professores/search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            professoresPagination.style.display = 'none';
            professoresTableBody.innerHTML = '';

            if (data.length > 0) {
                data.forEach(professor => {
                    const row = `
                        <tr>
                            <td>${professor.nome}</td>
                            <td>${professor.email}</td>
                            <td>${professor.cpf}</td>
                            <td>
                                <button class="btn-icon edit-btn" data-id="${professor.id}"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon delete-btn" data-id="${professor.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    professoresTableBody.innerHTML += row;
                });
            } else {
                professoresTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum resultado encontrado.</td></tr>';
            }
        });
});


searchAlunosInput.addEventListener('input', function() {
    if (this.value.length === 0) {
        window.location.href = '/admDashboard#alunos';
    }
});


searchProfessoresInput.addEventListener('input', function() {
    if (this.value.length === 0) {
        window.location.href = '/admin/dashboard#professores';
    }
});


const confirmationForms = document.querySelectorAll('.form-confirm');


confirmationForms.forEach(form => {
    form.addEventListener('submit', function(event) {
        // Prevenimos o envio imediato do formulário! Esta é a parte mais importante.
        event.preventDefault();

        // Pegamos os dados que definimos no HTML
        const actionText = this.dataset.actionText; // 'bloquear' ou 'desbloquear'
        const userName = this.dataset.userName;

        
        Swal.fire({
            title: 'Tem certeza?',
            // Usamos HTML para poder colocar o nome do usuário em negrito
            html: `Você realmente deseja <b>${actionText}</b> o usuário <strong>${userName}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: `Sim, ${actionText}!`,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
           
            if (result.isConfirmed) {
                
                this.submit();
            }
        });
    });
});


});