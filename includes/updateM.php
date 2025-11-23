<?php
include("../db/conexao.php");

// PEGAR ID
$id = $_GET['id'] ?? 0;

// BUSCAR USUÁRIO PARA EDITAR
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Usuário não encontrado.");
}

$u = $result->fetch_assoc();

// SE O FORM FOR ENVIADO (UPDATE)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];

    $sqlUpdate = "UPDATE usuarios SET nome=?, email=?, telefone=?, tipo=? WHERE id=?";
    $stmtUpd = $mysqli->prepare($sqlUpdate);
    $stmtUpd->bind_param("ssssi", $nome, $email, $telefone, $tipo, $id);

    if ($stmtUpd->execute()) {
        header("Location:../public/admin/telaUsuarios.php?msg=editado");
        exit;
    } else {
        echo "Erro ao atualizar: " . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>

<h1 style="text-align:center;">Editar Usuário</h1>

<form method="POST" class="formEditar">
    <label>Nome</label>
    <input type="text" name="nome" value="<?php echo $u['nome']; ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?php echo $u['email']; ?>" required>

    <label>Telefone</label>
    <input type="text" name="telefone" value="<?php echo $u['telefone']; ?>">

    <label>Tipo</label>
    <select name="tipo">
        <option value="USER" <?php echo ($u['tipo'] === "USER") ? "selected" : ""; ?>>Maquinista</option>
        <option value="ADM" <?php echo ($u['tipo'] === "ADM") ? "selected" : ""; ?>>Admin</option>
    </select>

    <button type="submit" class="btnSalvar">Salvar Alterações</button>
</form>

</body>
</html>