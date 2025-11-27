<?php
session_start();
include("../../db/conexao.php");

$tipo = strtoupper($_SESSION["tipo"] ?? "");

if ($tipo === "ADM") {
    $mysqli->query("UPDATE notificacoes SET lida = 1");
} else {
    $mysqli->query("UPDATE notificacoes SET lida = 1 WHERE tipo = 'TREM'");
}

exit;
?>