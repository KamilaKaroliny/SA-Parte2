<?php
session_start();
include("../../db/conexao.php");

// Verifica login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_SESSION["user_id"];

// ---> BUSCA FOTO ATUAL DO USUÁRIO
$sql = "SELECT foto_perfil FROM usuarios WHERE id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();
$foto_antiga = $dados["foto_perfil"] ?? null;
$stmt->close();

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["foto"])) {

    // Coloca na pasta imagens
    $pasta = "../../assets/images/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $foto = $_FILES["foto"];
    $nomeTemp = $foto["tmp_name"];
    $nomeOriginal = $foto["name"];

    // Gera nome único
    $ext = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
    $novoNome = uniqid("foto_", true) . "." . $ext;

    $caminhoFinal = $pasta . $novoNome;

    // Move o arquivo
    if (move_uploaded_file($nomeTemp, $caminhoFinal)) {

        // SE TIVER FOTO ANTIGA, APAGA
        if ($foto_antiga && file_exists($pasta . $foto_antiga)) {
            unlink($pasta . $foto_antiga);
        }

        // Atualiza no banco
        $sql = "UPDATE usuarios SET foto_perfil=? WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $novoNome, $id);
        $stmt->execute();

        header("Location: perfil.php?msg=foto_atualizada");
        exit;
    } else {
        echo "Erro ao enviar a imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Foto</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>

    <div class="meio7">
        <a href="perfil.php">
            <img id="setaEditar" src="../../assets/icons/seta.png" alt="seta">
        </a>
    </div>

<div class="container">
    <img id = "logo" src="../../assets/icons/logoTremalize.png" alt="Logo Tremalize">
    <h1 id="padding">Alterar Foto de Perfil</h1>

    <form method="POST" enctype="multipart/form-data">
        <label>Selecione uma imagem:</label>
        <br> <br>
        <div class="inputForms">
            <input id="inputF" type="file" name="foto" accept="image/*" required>
        </div>

        <br>
        <button type="submit" id="button6">Salvar Foto</button>
    </form>

</div>

</body>
</html>