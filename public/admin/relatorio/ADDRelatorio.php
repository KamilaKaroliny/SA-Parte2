<?php
include("../../../db/conexao.php");

if (isset($_POST['submit'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO relatorios (titulo, descricao) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute([$titulo, $descricao]);

    header("Location: READRelatorio.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Relatório</title>
    <link rel="stylesheet" href="assets/css/relatorios.css">
</head>
<body>

<h2>Adicionar Relatório</h2>

<form action="" method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" required>

    <label>Descrição:</label>
    <textarea name="descricao" required></textarea>

    <button type="submit" name="submit">Salvar</button>
</form>

</body>
</html>