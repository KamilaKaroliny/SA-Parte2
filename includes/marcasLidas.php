<?php
include("../../db/conexao.php");

// marca TODAS como lidas
$mysqli->query("UPDATE notificacoes SET lida = 1");

?>