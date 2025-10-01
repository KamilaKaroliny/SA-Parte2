<?php
include("./db/conexao.php");

$id = $_GET['id'] ?? null;
if(!$id) die("Usuário inválido.");

$sql = "DELETE FROM usuarios WHERE id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo "Usuário excluído com sucesso. <a href='../../index.php'>Voltar</a>";
} else {
    echo "Erro ao excluir: " . $mysqli->error;
}
?>