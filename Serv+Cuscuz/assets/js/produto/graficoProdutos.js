document.addEventListener('DOMContentLoaded', function () {
    var totalP = document.getElementById('totalP').value;
    var totalM = document.getElementById('totalM').value;
    var totalG = document.getElementById('totalG').value;

    var ctx = document.getElementById('graficoProdutos').getContext('2d');
    var graficoProdutos = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pequeno (P)', 'Médio (M)', 'Grande (G)'],
            datasets: [{
                label: 'Quantidade de Produtos',
                data: [totalP, totalM, totalG],
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF'],
                borderColor: ['#C70039', '#28A745', '#003366'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,  // Ajuste a proporção do gráfico
            plugins: {
                legend: {
                    position: 'top'  // Coloca a legenda no topo
                }
            },
            scales: {
                y: {
                    display: false  // Remove as grades
                }
            }
        }
    });
});
