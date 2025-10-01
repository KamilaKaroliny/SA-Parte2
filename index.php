<?php 
include("./db/conexao.php");
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = $_POST["email"] ?? "";
    $pass = $_POST["senha"] ?? "";

    $stmt = $mysqli->prepare("SELECT id, nome, email, senha, tipo FROM usuarios WHERE email=? AND senha=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if($dados){
        $_SESSION["user_id"] = $dados["id"];
        $_SESSION["nome"] = $dados["nome"];
        $_SESSION["email"] = $dados["email"];
        $_SESSION["tipo"] = $dados["tipo"];

        if ($dados["tipo"] === "ADM") {
            header("Location: ./public/admin/paginaInicial.php"); // <-- Aqui vai a página de ADM
        } else {
            header("Location: ./public/maquinista/paginaInicial.php"); // <-- Aqui vai a página de usuário (maquinista)
        }
        exit;
    } else {
        $msg = "Usuário ou senha incorretos!";
    }
}
?>

<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>

<body>

    <!-- Nessa div está o formulario e a logo com o nome login 
     icaro@administrador.com
     1icaro
    -->
    <div class="flex">

        <div id="formulario">
            <img id = "logo" src="./assets/icons/logoTremalize.png" alt="Logo Tremalize">
            <h1 id="padding">LOGIN</h1>

            <form action="" id="gestorForm" method="POST">
        
                <label for="email"></label><br>
                <input class="esticadinho" type="email" name="email" id="email" value="" placeholder="E-mail">
                <div class="erro" id="erroEmail">
    
                <label for="senha"></label><br>
                <input class="esticadinho" name="senha" id="senha" value="" placeholder="Senha">
                <div class="erro" id="erroSenha">

                <div id="esqueceuSenhaa">
                    <a href="./public/login/esqueceusenha.php">Esqueceu a senha?</a>
                </div>
                <br>
                <br>
                
                <button id='button1' type="submit">Enviar</button>
                
            </form>

        </div>

    </div>

</body>

</html>