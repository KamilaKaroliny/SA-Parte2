
//validação esqueceusenha2
document.addEventListener("DOMContentLoaded", function () {
  const esqueceusenha2 = document.getElementById("esqueceusenha2");

  esqueceusenha2.addEventListener("submit", function (i) {
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