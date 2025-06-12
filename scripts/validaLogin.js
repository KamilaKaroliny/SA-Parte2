
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

//validação esqueceusenha
document.addEventListener("DOMContentLoaded", function () {
  const formulario = document.getElementById("esqueceusenha");

  formulario.addEventListener("submit", function (s) {
    s.preventDefault();

    let valido = true;

    // para limpar os erros
    document.getElementById("erroNome").textContent = "";
    document.getElementById("erroEmail").textContent = "";
    document.getElementById("erroId").textContent = "";

    const nome = document.getElementById("nome").value.trim();
    const email = document.getElementById("email").value.trim();
    const id = document.getElementById("id").value.trim();

    console.log(nome);
    console.log(email);
    console.log(id);

    if (nome.length < 3) {
      document.getElementById("erroNome").textContent = "O nome deve ter pelo menos 3 caracteres";
      valido = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
      document.getElementById("erroEmail").textContent = "E-mail está inválido";
      valido = false;
    }

    if (id.length < 6) {
      document.getElementById("erroId").textContent = "O ID deve ter pelo menos 6 caracteres";
      valido = false;
    }

    if (valido) {
      alert("Senha redefinida com sucesso!");
      formulario.reset();
      window.location.href = "esqueceusenha2.html";
    }

  });

});

//validação esqueceusenha2
document.addEventListener("DOMContentLoaded", function () {
  const formulario = document.getElementById("esqueceusenha2");

  formulario.addEventListener("submit", function (i) {
    i.preventDefault();

    let valido = true;

    // para limpar os erros
    document.getElementById("erroCodigo").textContent = "";
    document.getElementById("erroNovaSenha").textContent = "";

    const codigo = document.getElementById("codigo").value.trim();
    const novaSenha = document.getElementById("novaSenha").value.trim();

    console.log(codigo);
    console.log(novaSenha);

    if (codigo.length < 6) {
      document.getElementById("erroCodigo").textContent = "O Codigo deve ter pelo menos 6 caracteres";
      valido = false;
    }

    if (novaSenha.length < 6) {
      document.getElementById("erroNovaSenha").textContent = "A Senha deve ter pelo menos 6 caracteres";
      valido = false;
    }

    if (valido) {
      alert("Senha redefinida com sucesso!");
      formulario.reset();
      window.location.href = "login.html";
    }

  });

});

//validação cadastro
document.addEventListener("DOMContentLoaded", function () {
  const formulario = document.getElementById("maquinistaForm");

  formulario.addEventListener("submit", function (k) {
    k.preventDefault();

    let valido = true;

    // para limpar os erros
    document.getElementById("erroNome").textContent = "";
    document.getElementById("erroDataNascimento").textContent = "";
    document.getElementById("erroId").textContent = "";
    document.getElementById("erroEmail").textContent = "";
    document.getElementById("erroSenha").textContent = "";
    document.getElementById("erroConfirmarSenha").textContent = "";

    const nome = document.getElementById("nome").value.trim();
    const dataNascimento = document.getElementById("dataNascimento").value.trim();
    const id = document.getElementById("id").value.trim();
    const email = document.getElementById("email").value.trim();
    const senha = document.getElementById("senha").value.trim();
    const confirmarSenha = document.getElementById("confirmarSenha").value.trim();

    console.log(nome);
    console.log(dataNascimento);
    console.log(id);
    console.log(email);
    console.log(senha);
    console.log(confirmarSenha);

    if (nome.length < 3) {
      document.getElementById("erroNome").textContent = "O Nome deve ter pelo menos 3 caracteres";
      valido = false;
    }

    if (dataNascimento.length < 10) {
      document.getElementById("erroDataNascimento").textContent = "A Data de nascimento deve ter pelo menos 10 caracteres";
      valido = false;
    }

    if (id.length < 6) {
      document.getElementById("erroId").textContent = "O ID deve ter pelo menos 6 caracteres";
      valido = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
      document.getElementById("erroEmail").textContent = "E-mail está inválido";
      valido = false;
    }

    if (senha.length < 6) {
      document.getElementById("erroSenha").textContent = "A Senha deve ter pelo menos 6 caracteres";
      valido = false;
    }

    if (confirmarSenha.length < 6 || confirmarSenha !== senha) {
      document.getElementById("erroConfirmarSenha").textContent = "A confirmação de senha deve ter pelo menos 6 caracteres e ser igual a senha";
      valido = false;
    }

    if (valido) {
      alert("Senha redefinida com sucesso!");
      formulario.reset();
      window.location.href = "login.html";
    }

  });

});

//mudança de pagina
function paginaInicial() {
  window.location.href = "paginaInicial.html";
}

function login() {
  window.location.href = "login.html";
}

function esqueceusenha2() {
  window.location.href = "esqueceusenha2.html";
}


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

