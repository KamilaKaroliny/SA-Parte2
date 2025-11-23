<?php
session_start();
include("../../db/conexao.php");

// Verifica login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_SESSION["user_id"];

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["foto"])) {

    // Criar pasta uploads caso não exista
    $pasta = "../../uploads/";
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

<div class="container">
    <h2>Alterar Foto de Perfil</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Selecione uma imagem:</label>
        <input type="file" name="foto" accept="image/*" required>

        <button type="submit" id="button7">Salvar Foto</button>
    </form>

</div>

</body>
</html>