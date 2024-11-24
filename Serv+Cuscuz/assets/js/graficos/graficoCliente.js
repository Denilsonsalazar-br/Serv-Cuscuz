document.addEventListener('DOMContentLoaded', function () {
    function createChart(ctx, data, label) {
        return new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [label],
                datasets: [{
                    data: [data],
                    backgroundColor: ['#4CAF50'],
                    borderColor: ['#388E3C'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    if (typeof dadosClientes !== 'undefined' && dadosClientes !== null) {
        for (const periodo in dadosClientes) {
            const total = dadosClientes[periodo]['atual'];
            if (total) {
                const ctx = document.getElementById(`grafico_${periodo}`).getContext('2d');
                createChart(ctx, total, `Total de Clientes (${periodo})`);
            }
        }
    } else {
        console.error('dadosClientes não está definido ou é nulo');
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // Função para abrir uma aba
    function openTab(evt, tabName) {
        const tabcontent = document.getElementsByClassName("tabcontent");
        const tablinks = document.getElementsByClassName("tablink");

        // Esconde todas as abas
        for (let content of tabcontent) {
            content.style.display = "none";
        }

        // Remove a classe "active" de todas as abas
        for (let link of tablinks) {
            link.className = link.className.replace(" active", "");
        }

        // Mostra a aba ativa
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Abre a primeira aba por padrão
    const firstTab = document.getElementsByClassName("tablink")[0];
    if (firstTab) {
        firstTab.click();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    function createBarChart(ctx, labels, datasets) {
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Rótulos (meses ou períodos)
                datasets: datasets // Dados correspondentes a cada período
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Período'
                        },
                        barThickness: 30, // Controle de largura das barras
                        maxBarThickness: 40, // Largura máxima das barras
                        groupPercentage: 0.8 // Espaçamento entre os grupos de barras
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total de Clientes'
                        },
                        ticks: {
                            stepSize: 1 // Garante números inteiros
                        }
                    }
                }
            }
        });
    }

    if (typeof dadosClientes !== 'undefined' && dadosClientes !== null) {
        const labels = []; // Rótulos do gráfico
        const datasets = []; // Conjunto de dados

        let totalUltimos12Meses = 0;

        // Processar os períodos disponíveis
        for (const periodo in dadosClientes) {
            if (dadosClientes[periodo] && typeof dadosClientes[periodo] === 'object') {
                switch (periodo) {
                    case 'mes':
                        const currentDate = new Date();
                        const currentMonth = new Intl.DateTimeFormat('pt-BR', { month: 'long', year: 'numeric' }).format(currentDate);
                        const previousDate = new Date(currentDate);
                        previousDate.setMonth(previousDate.getMonth() - 1);
                        const previousMonth = new Intl.DateTimeFormat('pt-BR', { month: 'long', year: 'numeric' }).format(previousDate);

                        // Adicionar rótulos para o mês anterior e atual
                        labels.push(previousMonth, currentMonth);

                        // Adicionar datasets separados
                        datasets.push({
                            label: 'Clientes no Mês Anterior',
                            data: [Math.floor(dadosClientes[periodo]?.['anterior'] || 0), null], // Apenas para o mês anterior
                            backgroundColor: '#FF9800',
                            borderColor: '#F57C00',
                            borderWidth: 1
                        });

                        datasets.push({
                            label: 'Clientes no Mês Atual',
                            data: [null, Math.floor(dadosClientes[periodo]?.['atual'] || 0)], // Apenas para o mês atual
                            backgroundColor: '#4CAF50',
                            borderColor: '#388E3C',
                            borderWidth: 1
                        });
                        break;

                    case 'trimestre':
                        labels.push('Últimos 3 meses');
                        datasets.push({
                            label: 'Últimos 3 Meses',
                            data: [null, null, Math.floor(dadosClientes[periodo] || 0)],
                            backgroundColor: '#FFC107',
                            borderColor: '#FFB300',
                            borderWidth: 1
                        });
                        break;

                    case 'semestre':
                        labels.push('Semestre atual');
                        datasets.push({
                            label: 'Semestre Atual',
                            data: [null, null, null, Math.floor(dadosClientes[periodo] || 0)],
                            backgroundColor: '#FF5722',
                            borderColor: '#D32F2F',
                            borderWidth: 1
                        });
                        break;

                    case 'ano':
                        const currentYear = new Date();
                        totalUltimos12Meses = 0;

                        // Loop para calcular os dados dos últimos 12 meses
                        for (let i = 0; i < 12; i++) {
                            const targetDate = new Date(currentYear);
                            targetDate.setMonth(targetDate.getMonth() - i);
                            const formattedMonthYear = new Intl.DateTimeFormat('pt-BR', { month: 'long', year: 'numeric' }).format(targetDate);

                            totalUltimos12Meses += Math.floor(dadosClientes['mes']?.[formattedMonthYear]?.atual || 0);
                        }

                        labels.push('Últimos 12 Meses');
                        datasets.push({
                            label: 'Últimos 12 Meses',
                            data: [null, null, null, null, totalUltimos12Meses],
                            backgroundColor: '#3F51B5',
                            borderColor: '#303F9F',
                            borderWidth: 1
                        });
                        break;
                }
            }
        }

        if (labels.length > 0 && datasets.length > 0) {
            const ctx = document.getElementById('grafico_geral').getContext('2d');
            createBarChart(ctx, labels, datasets);
        } else {
            console.error('Dados insuficientes para gerar o gráfico');
        }
    } else {
        console.error('dadosClientes não está definido ou é nulo');
    }
});

//pare aqui