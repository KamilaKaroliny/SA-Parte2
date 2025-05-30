
//validação
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
      Document.getElementById("erroEmail").textContent = "E-mail está inválido"
      valido = false;
    }

    if (senha.length < 6) {
      document.getElementById("erroSenha").textContent = "O senha deve ter pelo menos 6 caracteres"
      valido = false;
    }

    if (valido) {
      alert("Formulário enviado com sucesso!")
      formulario.reset();
      window.location.href = "paginaInicial.html"
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

// Código para fazer com que apareça a tela flutuante

document.getElementById("openMarcacao").onclick = function () {
  document.getElementById("marcacaoModal").style.display = "block";
}

document.querySelector(".closeBtn").onclick = function () {
  document.getElementById("marcacaoModal").style.display = "none";
}

window.onclick = function (event) {
  const modal = document.getElementById("marcacaoModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
}
