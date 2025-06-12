
//validação login
document.addEventListener("DOMContentLoaded", function () {
  const formulario = document.getElementById("gestorForm");

  formulario.addEventListener("submit", function (e) {
    e.preventDefault();

    let valido = true;

    // para limpar os erros
    document.getElementById("erroEmail").textContent = "";
    document.getElementById("erroSenha").textContent = "";

    const email = document.getElementById("email").value.trim();
    const senha = document.getElementById("senha").value.trim();

    console.log(email);
    console.log(senha);

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
      document.getElementById("erroEmail").textContent = "E-mail está inválido";
      valido = false;
    }

    if (senha.length < 6) {
      document.getElementById("erroSenha").textContent = "O senha deve ter pelo menos 6 caracteres";
      valido = false;
    }

    if (valido) {
      alert("Formulário enviado com sucesso!");
      formulario.reset();
      window.location.href = "paginaInicial.html";
    }

  });

});

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

