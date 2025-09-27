document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.querySelector('.sidebar');
    const sections = document.querySelectorAll('.dashboard-section');
    const navLinks = document.querySelectorAll('.sidebar-nav ul li a');

    // Toggle Sidebar
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
    }

    // Array para armazenar instâncias de gráficos ativos para redimensionamento
    let activeCharts = [];

    // Função para inicializar os gráficos de uma seção específica
    function initSectionCharts(sectionId) {
        // Limpa gráficos antigos antes de adicionar novos
        activeCharts.forEach(chart => {
            if (chart && chart.dispose) {
                chart.dispose(); // Libera recursos do gráfico
            }
        });
        activeCharts = []; // Reseta a lista de gráficos ativos

        const dashboardData = window.dashboardData;
        const alunosCount = dashboardData.alunosCount;
        const professoresCount = dashboardData.professoresCount;

        // Dados base para Alunos vs Professores
        const alunosProfessoresChartData = [
            { value: alunosCount, name: 'Alunos' },
            { value: professoresCount, name: 'Professores' }
        ];

        // --- Gráficos da Seção "Visão Geral" ---
        if (sectionId === 'overview') {
            // Gráfico Alunos vs Professores (Pizza) na Visão Geral
            if (document.getElementById('alunosProfessoresChart')) {
                const alunosProfessoresChart = echarts.init(document.getElementById('alunosProfessoresChart'));
                alunosProfessoresChart.setOption({
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b} : {c} ({d}%)'
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: ['Alunos', 'Professores']
                    },
                    series: [
                        {
                            name: 'Contagem',
                            type: 'pie',
                            radius: '50%',
                            data: alunosProfessoresChartData,
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ],
                    color: ['#4299e1', '#a0aec0'] // Cores personalizadas
                });
                activeCharts.push(alunosProfessoresChart);
            }

            // NOVO Gráfico de Barras na Visão Geral
            if (document.getElementById('overviewBarChart')) {
                const overviewBarChart = echarts.init(document.getElementById('overviewBarChart'));
                overviewBarChart.setOption({
                    title: {
                        text: 'Alunos vs Professores',
                        subtext: 'Contagem Absoluta',
                        left: 'center',
                        textStyle: {
                            fontSize: 14 // Um pouco menor para caber melhor na Visão Geral
                        },
                        subtextStyle: {
                            fontSize: 10
                        }
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: ['Alunos', 'Professores'],
                        axisLabel: {
                            fontSize: 10, // Menor
                            fontWeight: 'bold'
                        }
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Número de Usuários',
                        nameLocation: 'middle', // Posição do nome do eixo
                        nameGap: 25, // Espaçamento do nome do eixo
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    series: [
                        {
                            name: 'Quantidade',
                            type: 'bar',
                            data: [
                                { value: alunosCount, name: 'Alunos', itemStyle: { color: '#4299e1' } },
                                { value: professoresCount, name: 'Professores', itemStyle: { color: '#a0aec0' } }
                            ],
                            barWidth: '50%', // Ajusta a largura da barra
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            },
                            label: {
                                show: true,
                                position: 'top',
                                formatter: '{c}',
                                fontSize: 10 // Tamanho da fonte do label
                            }
                        }
                    ]
                });
                activeCharts.push(overviewBarChart);
            }
        }

        // --- Gráficos da Seção "Análises e Gráficos" ---
        if (sectionId === 'charts-section') {
            // Gráfico de Pizza: Distribuição de Usuários (Alunos vs Professores)
            if (document.getElementById('userDistributionPieChart')) {
                const userDistributionPieChart = echarts.init(document.getElementById('userDistributionPieChart'));
                userDistributionPieChart.setOption({
                    title: {
                        text: 'Alunos vs Professores',
                        subtext: 'Proporção Geral',
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b} : {c} ({d}%)'
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        top: 'bottom',
                        data: ['Alunos', 'Professores']
                    },
                    series: [
                        {
                            name: 'Distribuição',
                            type: 'pie',
                            radius: '55%',
                            center: ['50%', '60%'],
                            data: alunosProfessoresChartData,
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            },
                            label: {
                                formatter: '{b}: {c} ({d}%)'
                            }
                        }
                    ],
                    color: ['#4299e1', '#a0aec0']
                });
                activeCharts.push(userDistributionPieChart);
            }

            // Gráfico de Barras: Distribuição de Usuários (Alunos vs Professores)
            if (document.getElementById('userDistributionBarChart')) {
                const userDistributionBarChart = echarts.init(document.getElementById('userDistributionBarChart'));
                userDistributionBarChart.setOption({
                    title: {
                        text: 'Alunos vs Professores',
                        subtext: 'Contagem Absoluta',
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: ['Alunos', 'Professores'],
                        axisLabel: {
                            fontSize: 12,
                            fontWeight: 'bold'
                        }
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Número de Usuários',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    series: [
                        {
                            name: 'Quantidade',
                            type: 'bar',
                            data: [
                                { value: alunosCount, name: 'Alunos', itemStyle: { color: '#4299e1' } },
                                { value: professoresCount, name: 'Professores', itemStyle: { color: '#a0aec0' } }
                            ],
                            barWidth: '40%',
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            },
                            label: {
                                show: true,
                                position: 'top',
                                formatter: '{c}'
                            }
                        }
                    ]
                });
                activeCharts.push(userDistributionBarChart);
            }
        }
    }

    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            navLinks.forEach(item => item.classList.remove('active'));
            this.classList.add('active');

            const targetId = this.getAttribute('href').substring(1);
            sections.forEach(section => {
                if (section.id === targetId) {
                    section.classList.add('active');
                    setTimeout(() => {
                        initSectionCharts(targetId);
                    }, 100);
                } else {
                    section.classList.remove('active');
                }
            });
        });
    });

    
    window.addEventListener('resize', function() {
        activeCharts.forEach(chart => {
            if (chart && chart.resize) {
                chart.resize();
            }
        });
    });

    
    const initialActiveSection = document.querySelector('.dashboard-section.active');
    if (initialActiveSection) {
        setTimeout(() => {
            initSectionCharts(initialActiveSection.id);
        }, 100);
    }
});