<?php
include("../../../db/conexao.php");

if (!isset($_GET['id'])) {
    header("Location: READRelatorio.php");
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM relatorios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->execute([$id]);

header("Location: READRelatorio.php");
exit;
?>