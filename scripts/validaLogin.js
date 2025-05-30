function paginaInicial() {
    window.location.href="paginaInicial.html";
}

function login() {
    window.location.href="login.html";
}

function esqueceusenha2() {
    window.location.href="esqueceusenha2.html";
}


// Código para fazer com que apareça a tela flutuante

document.getElementById("openMarcacao").onclick = function() {
  document.getElementById("marcacaoModal").style.display = "block";
}

document.querySelector(".closeBtn").onclick = function() {
  document.getElementById("marcacaoModal").style.display = "none";
}

window.onclick = function(event) {
  const modal = document.getElementById("marcacaoModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
}
