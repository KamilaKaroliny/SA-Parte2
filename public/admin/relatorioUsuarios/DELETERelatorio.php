<?php
include("../../../db/conexao.php"); 

// =============================
// PEGAR ID DO USUÁRIO E DO RELATÓRIO
// =============================
$id_usuario  = isset($_GET['id_usuario']) ? (int)$_GET['id_usuario'] : 0;
$id_relatorio = isset($_GET['id_relatorio']) ? (int)$_GET['id_relatorio'] : 0;

if ($id_relatorio <= 0 || $id_usuario <= 0) {
    die("ID do usuário ou relatório não informado.");
}

// =============================
// BUSCAR USUÁRIO
// =============================
$sql_user = "SELECT nome, foto_perfil FROM usuarios WHERE id = ?";
$stmt_user = $mysqli->prepare($sql_user);
$stmt_user->bind_param("i", $id_usuario);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    die("Usuário não encontrado.");
}

$user = $result_user->fetch_assoc();
$nome_maquinista = $user['nome'];
$foto_maquinista = $user['foto_perfil'] ?: 'default.jpg';

// =============================
// DELETAR RELATÓRIO
// =============================
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $mysqli->prepare("DELETE FROM relatorios_usuarios WHERE id = ?");
    $stmt->bind_param("i", $id_relatorio);
    
    if ($stmt->execute()) {
        $msg = "<div class='notif success'>Relatório deletado com sucesso!</div>";
    } else {
        $msg = "<div class='notif error'>Erro ao deletar relatório.</div>";
    }
    
    $stmt->close();
}
?>

</head>
<body>
<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="../../../style/style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Relatório - <?php echo strtoupper($nome_maquinista); ?></title>
    <div class="perfil">
        <img src="../../../assets/images/<?php echo $foto_maquinista; ?>" alt="Foto do Maquinista">
        <h2><?php echo strtoupper($nome_maquinista); ?></h2>
        <h3>Deseja realmente deletar este relatório?</h3>
    </div>

    <?php if (!empty($msg)) echo $msg; ?>

    <div class="actions">
        <form method="POST" style="display:inline;">
            <button type="submit" class="btn-confirm">Sim, deletar</button>
        </form>
        <a href="READRelatorio.php?id=<?php echo $id_usuario; ?>" class="btn-cancel">Cancelar</a>
    </div>

</body>
</html>