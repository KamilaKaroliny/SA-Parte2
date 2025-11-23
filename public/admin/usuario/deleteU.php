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

// SE CONFIRMAR A EXCLUSÃO
if (isset($_POST['confirmar'])) {
    $sqlDel = "DELETE FROM usuarios WHERE id = ?";
    $stmtDel = $mysqli->prepare($sqlDel);
    $stmtDel->bind_param("i", $id);

    if ($stmtDel->execute()) {
        header("Location: ../public/admin/telaUsuarios.php?msg=deletado");
        exit;
    } else {
        echo "Erro ao deletar: " . $mysqli->error;
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

<div 
    class="meio7">
        <a href="telaUsuarios.php">
        <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
    </a>
</div>

<img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
<H1 id="padding">EXCLUIR USUÁRIOS</H1>

<div class="cardConfirmar">
    <p>
        Tem certeza que deseja excluir o usuário <strong><?php echo $u['nome']; ?></strong>?
    </p>
    <br>

    <form method="POST">
        <button type="submit" name="confirmar" id='button8'>Sim, excluir</button>
    </form>
</div>

</body>
</html>