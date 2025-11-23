<?php
include("../../../db/conexao.php");

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
        header("Location:telaUsuarios.php?msg=editado");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
<H1 id="padding">EDITAR USUÁRIOS</H1>

<form  action="" method="POST" id="maquinistaForm">
    <div class="espacamento">
        <label>Nome</label>
        <input class="esticadinho2" type="text" name="nome" value="<?php echo $u['nome']; ?>" required>
    </div>


    <div class="espacamento">
        <label>Email</label>
        <input class="esticadinho2" type="email" name="email" value="<?php echo $u['email']; ?>" required>
    </div>


    <div class="espacamento">
        <label>Telefone</label>
        <input class="esticadinho2" type="text" name="telefone" value="<?php echo $u['telefone']; ?>">
    </div>


    <label>Tipo</label>
    <select class="esticadinho2" name="tipo">
        <option value="USER" <?php echo ($u['tipo'] === "USER") ? "selected" : ""; ?>>Maquinista</option>
        <option value="ADM" <?php echo ($u['tipo'] === "ADM") ? "selected" : ""; ?>>Admin</option>
    </select>


    <div class="espacamento">
        <button id='button2' type="submit">Salvar Alterações</button>
    </div>

</form>

</body>
</html>