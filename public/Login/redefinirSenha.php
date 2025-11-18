<?php 
include("../../db/conexao.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

// ID do usuário logado
$id = $_SESSION['user_id'];

// busca os dados do usuário correspondente
$stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dados = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nSenha = $_POST['senha'];

        $sql = "UPDATE usuarios SET nome = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $nSenha, $id);

        if ($stmt->execute()) {
            header("Location: telaEditar.php?id=$id");
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
        $mysqli->close();
        exit(); 
}
?>

<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Redefinir senha</title>

<body>
    <div class="flex">

        <div id="formulario">
            <img id = "logo" src="../../assets/icons/logoTremalize.png" alt="Logo Tremalize">
            <h1 id="padding">Alterar senhas</h1>

            <form action="" id="alterarForm" method="POST">
    
                <label for="senha"></label><br>
                <input class="esticadinho" name="senha" id="senhaA" value="" placeholder="Senha antiga">
                <div class="erro" id="erroSenha">

                <label for="nSenha"></label><br>
                <input class="esticadinho" name="senha" id="nSenha" value="" placeholder="Nova senha">
                <div class="erro" id="erroSenha">

                <label for="novaSenha2"></label><br>
                <input class="esticadinho" name="senha" id="rSenha" value="" placeholder="Repita a senha">
                <div class="erro" id="erroSenha"> <br> <br>
                
                <button id='button1' type="submit">Redefinir</button>
                
            </form>

        </div>

    </div>

</body>

</html>