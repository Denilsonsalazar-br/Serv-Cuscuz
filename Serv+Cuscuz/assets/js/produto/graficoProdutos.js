document.addEventListener('DOMContentLoaded', function () {
    function createChart(ctx, data) {
        return new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pequeno (P)', 'Médio (M)', 'Grande (G)'],
                datasets: [{
                    data: data,
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF'],
                    borderColor: ['#C70039', '#28A745', '#003366'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    }

    // Loop through each category and create a chart
    for (const categoriaNome in dadosCategorias) {
        const tamanhos = dadosCategorias[categoriaNome];
        const data = [tamanhos['P'], tamanhos['M'], tamanhos['G']];
        const ctx = document.getElementById(`grafico_${categoriaNome}`).getContext('2d');
        createChart(ctx, data);
    }
});

function openTab(evt, tabName) {
    const tabcontent = document.getElementsByClassName("tabcontent");
    const tablinks = document.getElementsByClassName("tablink");

    for (let content of tabcontent) content.style.display = "none";
    for (let link of tablinks) link.className = link.className.replace(" active", "");

    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Open the first tab by default
document.addEventListener('DOMContentLoaded', () => {
    document.getElementsByClassName("tablink")[0].click();
});
