<?php
include("../../../db/conexao.php");

if (!isset($_GET['id'])) {
    header("Location: READRelatorio.php");
    exit;
}

$id = $_GET['id'];

// Buscar dados
$sql = "SELECT * FROM relatorios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->execute([$id]);
$relatorio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$relatorio) {
    echo "Relatório não encontrado!";
    exit;
}

// Atualizar
if (isset($_POST['submit'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE relatorios SET titulo = ?, descricao = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute([$titulo, $descricao, $id]);

    header("Location: READRelatorio.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Relatório</title>
    <link rel="stylesheet" href="assets/css/relatorios.css">
</head>
<body>

<h2>Editar Relatório</h2>

<form method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?= $relatorio['titulo'] ?>" required>

    <label>Descrição:</label>
    <textarea name="descricao" required><?= $relatorio['descricao'] ?></textarea>

    <button type="submit" name="submit">Salvar Alterações</button>
</form>

</body>
</html>