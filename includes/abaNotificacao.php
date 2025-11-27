<?php
include("../../db/conexao.php");

// Contar notificações não lidas
$sql_count = "SELECT COUNT(*) AS total FROM notificacoes WHERE lida = 0";
$res = $mysqli->query($sql_count)->fetch_assoc();
$totalNoti = $res["total"] ?? 0;

// Buscar últimas notificações
$sql_not = "SELECT id, mensagem, data_hora, lida 
            FROM notificacoes 
            ORDER BY data_hora DESC 
            LIMIT 20";

$notificacoes = $mysqli->query($sql_not);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Aba de Notificação ADM</title>
</head>
<body>

<label>

    <!-- CHECKBOX QUE ABRE A ABA -->
    <input class="noticacao" id="abrirNoti" type="checkbox" onclick="marcarComoLida()">

    <!-- BOTÃO (SINO) -->
    <div class="toggle">
        <img id="sininho2" src="../../assets/icons/sininho.png" alt="Notificação">

        <?php if ($totalNoti > 0): ?>
            <span class="badgeNoti" id="badgeNoti"><?= $totalNoti ?></span>
        <?php endif; ?>
    </div>

    <!-- ABA DESLIZANDO -->
    <div class="notificacoes">
        <h2 class="titulo">NOTIFICAÇÕES</h2>

        <?php if (!$notificacoes || $notificacoes->num_rows == 0): ?>
            <p>Nenhuma notificação encontrada.</p>

        <?php else: ?>
            <?php while ($n = $notificacoes->fetch_assoc()): ?>
                <div class="notificacao-item <?= ($n['lida'] == 0) ? 'unread' : '' ?>">
                    <h2 class="tituloNoti">Notificação</h2>
                    <h3 class="noti">
                        <?= htmlspecialchars($n["mensagem"]); ?>
                    </h3>

                    <p style="font-size: 12px; opacity: .8;">
                        <?= date("d/m/Y H:i", strtotime($n["data_hora"])); ?>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</label>

<script>
function marcarComoLida() {
    const chk = document.getElementById("abrirNoti");

    if (chk.checked) {
        // chama PHP através de uma imagem invisível
        let img = new Image();
        img.src = "../../includes/marcarLidas.php?t=" + new Date().getTime();

        // some com o badge
        let badge = document.getElementById("badgeNoti");
        if (badge) badge.remove();
    }
}
</script>

</body>
</html>