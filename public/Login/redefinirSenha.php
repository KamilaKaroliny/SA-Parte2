<?php 
include("../../db/conexao.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dados = $stmt->get_result()->fetch_assoc();
$stmt->close();

$msg = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $senhaAtual = $_POST['senhaAtual'];
    $novaSenha = $_POST['novaSenha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    if (!password_verify($senhaAtual, $dados['senha'])) {
        $msg = "A senha atual está incorreta!";
    }
    else if ($novaSenha !== $confirmaSenha) {
        $msg = "A nova senha e a confirmação não coincidem!";
    } 
    else {
        $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $novaSenhaHash, $id);

        if ($stmt->execute()) {
            $msg = "Senha alterada com sucesso!";
        } else {
            $msg = "Falha ao alterar senha!";
        }

        $stmt->close();
        $mysqli->close();
    }
}

if (!empty($msg)) {
    echo "<p style='color:white; text-align:center; font-size:12px; margin-top:10px;'>$msg</p>";
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

            <div class="meio7">
                <a href="telaEditar.php">
                    <img id="setaEditar" src="../../assets/icons/seta.png" alt="seta">
                </a>
            </div>

        <div id="formulario">

            <img id = "logo" src="../../assets/icons/logoTremalize.png" alt="Logo Tremalize">
            <h1 id="padding">Alterar senha</h1>

            <form action="" id="alterarForm" method="POST">
    
                <input 
                    class="esticadinho" type="password" name="senhaAtual" id="senhaA" placeholder="Senha antiga"
                    required>
                <div class="erro" id="erroSenha"></div>

                <br>

                <input 
                    class="esticadinho" type="password" name="novaSenha" id="nSenha" placeholder="Nova senha"
                    required>
                <div class="erro" id="erroSenha"></div>

                <br>

                <input 
                    class="esticadinho" type="password" name="confirmaSenha" id="rSenha" placeholder="Repita a senha"
                    required>
                <div class="erro" id="erroSenha"></div>

                <br><br>

                <button id='button1' type="submit">Redefinir</button>
            </form>

        </div>

    </div>

</body>

</html>