<?php
include("../../../db/conexao.php"); 

// PEGAR ID DO TREM E DO RELATÓRIO
$trem_id       = isset($_GET['id_trem']) ? (int)$_GET['id_trem'] : 0;
$id_relatorio  = isset($_GET['id_relatorio']) ? (int)$_GET['id_relatorio'] : 0;

if ($id_relatorio <= 0 || $trem_id <= 0) {
    die("ID do trem ou relatório não informado.");
}

// BUSCAR TREM
$sql_trem = "SELECT nome, imagem FROM trem WHERE id = ?";
$stmt_trem = $mysqli->prepare($sql_trem);
$stmt_trem->bind_param("i", $trem_id);
$stmt_trem->execute();
$result_trem = $stmt_trem->get_result();

if ($result_trem->num_rows == 0) {
    die("Trem não encontrado.");
}

$trem = $result_trem->fetch_assoc();
$nome_trem = $trem['nome'];
$imagem_trem = $trem['imagem'] ?: 'default.jpg';

// DELETAR RELATÓRIO
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $mysqli->prepare("DELETE FROM relatorios_trens WHERE id = ?");
    $stmt->bind_param("i", $id_relatorio);
    
    if ($stmt->execute()) {
        $msg = "<div class='notif success'>Relatório deletado com sucesso!</div>";
    } else {
        $msg = "<div class='notif error'>Erro ao deletar relatório.</div>";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Relatório - <?php echo strtoupper($nome_trem); ?></title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<div class="rel-form-container">
    <div class="rel-perfil">
        <h2><?php echo strtoupper($nome_trem); ?></h2>
        <h3>Deseja realmente deletar este relatório?</h3>
    </div>

    <?php if (!empty($msg)) echo $msg; ?>

    <div class="actions">
        <form method="POST" style="display:inline;">
            <button type="submit" class="btn-confirm">Sim, deletar</button>
        </form>
        <a href="READRelatorioTrens.php?id=<?php echo $trem_id; ?>" class="btn-cancel">Cancelar</a>
    </div>
</div>

</body>
</html>