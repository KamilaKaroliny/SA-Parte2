<?php
include("../../db/conexao.php");

// LISTAR MARCAÇÕES
$sql = "SELECT * FROM marcacao ORDER BY id DESC";
$res = $mysqli->query($sql);

// EDITAR MARCAÇÃO
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $localizacao = $_POST['localizacao'];
    $icone = $_POST['icone'];

    $sqlUpdate = "UPDATE marcacao SET localizacao=?, icone=? WHERE id=?";
    $stmt = $mysqli->prepare($sqlUpdate);
    $stmt->bind_param("ssi", $localizacao, $icone, $id);
    $stmt->execute();

    header("Location: editarMarcacao.php");
    exit;
}

// EXCLUIR MARCAÇÃO
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $mysqli->query("DELETE FROM marcacao WHERE id = $id");
    header("Location: editarMarcacao.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../style/style.css">
    <link rel="stylesheet" href="../../style/styleMapa.css">
    <title>Editar Marcações</title>

    
</head>

<body>

<!-- Cabeçalho -->
<div>
    <div class="meio7">
        <a href="paginaInicial.php">
            <img id="setaEditar" src="../../assets/icons/seta.png">
        </a>
    </div>
        <img id="logoEditar" src="../../assets/icons/logoTremalize.png">
    </div>
</div>

<main>

    <h2 style="text-align:center; font-size:50px;">Editar Marcações</h2>
    <hr>

    <div class="lista">

        <?php while($m = $res->fetch_assoc()): ?>
        <div class="card">

            <div>
                <img src="../../assets/icons/<?php echo $m['icone']; ?>.png" width="30">
                <strong><?php echo $m['localizacao']; ?></strong>
            </div>

            <div>
                <a href="editarMarcacao.php?edit=<?php echo $m['id']; ?>">
                    <button>Edit</button>
                </a>

                <a href="editarMarcacao.php?del=<?php echo $m['id']; ?>" onclick="return confirm('Excluir marcação?')">
                    <button style="background:#dc2626;">Excluir</button>
                </a>
            </div>

        </div>
        <?php endwhile; ?>

    </div>

    <!-- Formulário de edição -->
    <?php if (isset($_GET['edit'])):
        $idEdit = (int)$_GET['edit'];
        $dados = $mysqli->query("SELECT * FROM marcacao WHERE id=$idEdit")->fetch_assoc();
    ?>

    <div class="form-editar">
        <h3>Editar Marcação</h3>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">

            <label>Localização:</label>
            <input type="text" name="localizacao" value="<?php echo $dados['localizacao']; ?>">

            <label>Ícone:</label>
            <select name="icone">
                <option value="Acidente" <?php if($dados['icone']=="Acidente") echo "selected"; ?>>Acidente</option>
                <option value="Obras" <?php if($dados['icone']=="Obras") echo "selected"; ?>>Obras</option>
                <option value="Quebra" <?php if($dados['icone']=="Quebra") echo "selected"; ?>>Quebra</option>
            </select>

            <button type="submit" name="editar">Salvar</button>
        </form>

    </div>

    <?php endif; ?>

</main>

</body>
</html>
