
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
