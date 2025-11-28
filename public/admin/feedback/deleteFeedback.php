<?php
session_start();
include("../../../db/conexao.php");

if (!isset($_SESSION['email'])) {
    die("Acesso negado. Faça login.");
}

$emailLogado = $_SESSION['email'];
$ehAdmin = str_ends_with($emailLogado, "@administrador.com");

if (!$ehAdmin) {
    die("Acesso negado. Apenas administradores podem excluir.");
}

if (!isset($_POST['id_usuario'])) {
    die("ID inválido.");
}

$id = intval($_POST['id_usuario']);

$sql = "UPDATE usuarios SET feedback = NULL WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirecionar de volta para a tela de feedback
    header("Location: READFeedback.php");
    exit;
} else {
    echo "Erro ao excluir feedback: " . $stmt->error;
}
