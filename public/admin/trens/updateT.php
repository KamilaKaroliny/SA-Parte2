<?php
include("../../../db/conexao.php");

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM trem WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Trem não encontrado.");
}

$u = $result->fetch_assoc();

$sqlMaq = "SELECT id, nome FROM usuarios WHERE tipo = 'USER'";
$maquinistas = $mysqli->query($sqlMaq);


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $maquinista = trim($_POST['maquinista']);

    $sqlUpdate = "UPDATE trem SET nome = ?, tipo = ?, maquinista = ? WHERE id = ?";
    $stmtUpd = $mysqli->prepare($sqlUpdate);
    $stmtUpd->bind_param("ssii", $nome, $tipo, $maquinista, $id);

    if ($stmtUpd->execute()) {
        header("Location: telaCircular.php?msg=editado");
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
    <title>Editar Trem</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<div class="meio7">
    <a href="telaCircular.php">
        <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
    </a>
</div>

<img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo">
<h1 id="padding">EDITAR TREM</h1>

<form action="" method="POST" id="maquinistaForm">

    <div class="espacamento">
        <label class="labelUp1">Nome do Trem:</label>
        <input class="esticadinho2" type="text" name="nome" 
               value="<?php echo $u['nome']; ?>" required>
    </div>

    <div class="espacamento">
        <label class="labelUp1">Tipo:</label>
        <select class="esticadinho4" name="tipo">
            <option value="CIR" <?php echo ($u['tipo'] === "CIR") ? "selected" : ""; ?>>Circular</option>
            <option value="CAR" <?php echo ($u['tipo'] === "CAR") ? "selected" : ""; ?>>Carga</option>
            <option value="TUR" <?php echo ($u['tipo'] === "TUR") ? "selected" : ""; ?>>Turismo</option>
        </select>
    </div>

    <div class="espacamento">
        <label class="labelUp1">Maquinista:</label>
        <select class="esticadinho4" name="maquinista" required>
            <option value="">Selecione...</option>

            <?php while ($m = $maquinistas->fetch_assoc()) { ?>
                <option value="<?php echo $m['id']; ?>"
                    <?php echo ($u['maquinista'] == $m['id']) ? "selected" : ""; ?>>
                    <?php echo $m['nome']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <br>

    <div class="espacamento3">
        <button id="button7" type="submit">Salvar Alterações</button>
    </div>

</form>

</body>
</html>