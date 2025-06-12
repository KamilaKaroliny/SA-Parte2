//adição de gráfico relatório maquinistas

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var dataTable = new google.visualization.DataTable();
  dataTable.addColumn('string', 'Categoria');
  dataTable.addColumn('number', 'Valor');
  dataTable.addRows([
      ['Curta', 70],
      ['Média', 32],
      ['Longa', 48]
      
  ]);

  var options = {
    backgroundColor: 'white',
    titleTextStyle: {color: 'blue'},
    pieSliceText: 'value',
    fontsize: '10',
    slices: {
        0: { color: '#6ce5e8' },
        1: { color: '#41b8d5' },
        2: { color: '#2d8bba' }
    }
  };

  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  chart.draw(dataTable, options);
}
