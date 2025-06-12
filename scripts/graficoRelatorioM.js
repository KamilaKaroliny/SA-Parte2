//adição de gráfico relatório maquinistas

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var dataTable = new google.visualization.DataTable();
  dataTable.addColumn('string', 'Categoria');
  dataTable.addColumn('number', 'Valor');
  dataTable.addRows([
      ['OI', 40],
      ['Item B', 15],
      ['Item C', 5]
      
  ]);

  var options = {
    backgroundColor: 'white',
    titleTextStyle: {color: 'blue'},
    pieSliceText: 'value',
    slices: {
        0: { color: 'red' },
        1: { color: 'blue' },
        2: { color: 'green' }
    }
  };

  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  chart.draw(dataTable, options);
}
