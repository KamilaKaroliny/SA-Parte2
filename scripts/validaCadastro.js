
//validação cadastro
document.addEventListener("DOMContentLoaded", function () {
  const maquinistaForm = document.getElementById("maquinistaForm");

  maquinistaForm.addEventListener("submit", function (k) {
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
      maquinistaForm.reset();
      window.location.href = "login.html";
    }

  });

});