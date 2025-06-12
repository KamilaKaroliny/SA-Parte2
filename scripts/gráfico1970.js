google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    // Defina os dados
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Elemento');
    data.addColumn('number', 'Quantidade');
    data.addRows([
        ['07:00', 90],
        ['14:00', 200],
        ['18:00', 100],
        ['21:00', 290]
    ]);

    // Defina as opções do gráfico
    var options = {
        chartArea: { width: '70%' },
        backgroundColor: 'transparent',
        legend: { position: 'none' },
    };

    // Crie o gráfico
    var chart = new google.visualization.BarChart(document.getElementById('my_chart_div'));

    // Desenhe o gráfico
    chart.draw(data, options);
}