<?php
session_start();
include("../db/conexao.php");

$tipoUsuario = $_SESSION["tipo"] ?? "";

// ADM marca tudo
if ($tipoUsuario === "ADM") {
    $sql = "UPDATE notificacoes SET lida = 1 WHERE lida = 0";
}

// USER marca apenas TREM
else {
    $sql = "UPDATE notificacoes SET lida = 1 WHERE lida = 0 AND tipo = 'TREM'";
}

$mysqli->query($sql);
?>
