<?php
session_start();
include("../../db/conexao.php");

$tipoUsuario = strtoupper($_SESSION["tipo"] ?? "");

// CONTAR NOTIFICAÇÕES NÃO LIDAS
if ($tipoUsuario === "ADM") {
    $sql_count = "SELECT COUNT(*) AS total FROM notificacoes WHERE lida = 0";
} else {
    $sql_count = "SELECT COUNT(*) AS total FROM notificacoes WHERE lida = 0 AND tipo = 'TREM'";
}

$res = $mysqli->query($sql_count)->fetch_assoc();
$totalNoti = $res["total"] ?? 0;

// BUSCAR LISTA DE NOTIFICAÇÕES
if ($tipoUsuario === "ADM") {
    $sql_not = "SELECT * FROM notificacoes ORDER BY data_hora DESC LIMIT 20";
} else {
    $sql_not = "SELECT * FROM notificacoes WHERE tipo = 'TREM' ORDER BY data_hora DESC LIMIT 20";
}

$notificacoes = $mysqli->query($sql_not);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Notificações</title>
</head>
<body>

<!-- CHECKBOX PARA ABRIR A ABA -->
<input type="checkbox" id="checkNoti" class="noticacao" onclick="marcarComoLida()">

<!-- ÍCONE DO SINO -->
<label for="checkNoti" class="toggle">
    <img id="sininho2" src="../../assets/icons/sininho.png" alt="Notificação">
    <?php if ($totalNoti > 0): ?>
        <span class="badgeNoti" id="badgeNoti"><?= $totalNoti ?></span>
    <?php endif; ?>
</label>

<!-- A ABA DE NOTIFICAÇÕES -->
<div class="notificacoes">
    <div class="titulo">Notificações</div>

    <?php if ($notificacoes->num_rows > 0): ?>
        <?php while ($n = $notificacoes->fetch_assoc()): ?>
            <div class="notificacao-item <?= $n['lida'] == 0 ? 'unread' : '' ?>">
                <div class="tituloNoti">
                    <?= ($n["tipo"] === "USER" ? "Novo Usuário" : "Trem") ?>
                </div>

                <div class="noti">
                    <?= htmlspecialchars($n["mensagem"]) ?>
                </div>

                <small><?= date("d/m/Y H:i", strtotime($n["data_hora"])) ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhuma notificação encontrada.</p>
    <?php endif; ?>
</div>

<script>
function marcarComoLida() {
    const chk = document.getElementById("checkNoti");

    if (chk.checked) {
        let img = new Image();

        img.src = "marcarLidas.php?t=" + new Date().getTime();

        let badge = document.getElementById("badgeNoti");
        if (badge) badge.remove();
    }
}
</script>

</body>
</html>