<?php
include("../../../db/conexao.php");

$id = $_GET['id'] ?? 0;

// BUSCAR USUÁRIO
$sql = "SELECT nome FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Usuário não encontrado.");
}

$u = $result->fetch_assoc();

$erro = "";

// SE CONFIRMAR A EXCLUSÃO
if (isset($_POST['confirmar'])) {

    // ---- VERIFICAR VÍNCULOS ----
    // Trem → maquinista
    $check1 = $mysqli->prepare("SELECT COUNT(*) AS total FROM trem WHERE maquinista = ?");
    $check1->bind_param("i", $id);
    $check1->execute();
    $v1 = $check1->get_result()->fetch_assoc()['total'];

    // Relatórios de usuários
    $check2 = $mysqli->prepare("SELECT COUNT(*) AS total FROM relatorios_usuarios WHERE id_usuario = ?");
    $check2->bind_param("i", $id);
    $check2->execute();
    $v2 = $check2->get_result()->fetch_assoc()['total'];

    if ($v1 > 0 || $v2 > 0) {
        $erro = "❌ Não é possível excluir. O usuário possui vínculos em:</br>
                • Trens<br>
                • Relatórios de usuários<br>";
    } else {

        // ---- EXCLUIR ----
        $sqlDel = "DELETE FROM usuarios WHERE id = ?";
        $stmtDel = $mysqli->prepare($sqlDel);
        $stmtDel->bind_param("i", $id);

        if ($stmtDel->execute()) {

            // Notificação
            $mensagemNoti = "O maquinista " . $u['nome'] . " foi excluído.";
            $tipoNoti = "USER";
            $stmtNoti = $mysqli->prepare("INSERT INTO notificacoes (mensagem, tipo) VALUES (?, ?)");
            $stmtNoti->bind_param("ss", $mensagemNoti, $tipoNoti);
            $stmtNoti->execute();
            $stmtNoti->close();

            header("Location: telaUsuarios.php?msg=deletado");
            exit;
        } else {
            $erro = "Erro ao deletar: " . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Usuário</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<div class="meio7">
    <a href="telaUsuarios.php">
        <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
    </a>
</div>

<img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo">
<h1 id="padding">EXCLUIR USUÁRIO</h1>

<div class="cardConfirmar">

    <?php if (!empty($erro)): ?>
        <p><?= $erro ?></p>
        <br>
        <a href="telaUsuarios.php">
            <button id="button8">Voltar</button>
        </a>
    <?php else: ?>

    <p>Tem certeza que deseja excluir o usuário <strong><?= htmlspecialchars($u['nome']) ?></strong>?</p>

    <form method="POST">
        <button type="submit" name="confirmar" id="button8">Sim, excluir</button>
    </form>

    <?php endif; ?>

</div>

</body>
</html>