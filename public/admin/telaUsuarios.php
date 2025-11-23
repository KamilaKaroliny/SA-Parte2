<?php
include("../../db/conexao.php");

$busca = isset($_GET['q']) ? trim($_GET['q']) : "";

$sql = "SELECT id, nome, tipo FROM usuarios";

if ($busca !== "") {
    $sql .= " WHERE nome LIKE ?";
    $sql .= " ORDER BY nome ASC";
    $stmt = $mysqli->prepare($sql);
    $like = "%$busca%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql .= " ORDER BY nome ASC";
    $result = $mysqli->query($sql);
}

if (!$result) {
    die("Erro: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Lista de Maquinistas</title>
</head>
<body>

    <!-- cabeçalho -->
    <div id="cabecalhoEditar">
            <div class="meio7">
                <a href="./paginaInicial.php">
                    <img id="setaEditar" src="../../assets/icons/seta.png" alt="seta">
                </a>
            </div>

            <div class="meio7">
                <img id="logoEditar" src="../../assets/icons/logoTremalize.png" alt="logo">
            </div>

            <div class="meio6">
                <a href="./paginaInicial.php">
                    <img id="casaEditar" src="../../assets/icons/casa.png" alt="casa">
                </a>
            </div>
    </div>

    <!-- barra de pesquisa -->
    <form method="GET" id="searchContainer">
        <input 
            type="text" name="q" id="pesquisa" placeholder="Pesquisa" 
            value="<?php echo htmlspecialchars($busca); ?>">
        <button type="submit" id="btnBuscar">
            <img id="lupa" src="../../assets/icons/lupa.png" alt="buscar">
        </button>
    </form>

    <!-- listagem -->
    <div class="lista">
    <?php while ($u = $result->fetch_assoc()): ?>
        <div class="card usuario">
            <div class="infos">
                <h2><?php echo strtoupper($u['nome']); ?></h2>
                <p><?php echo ($u['tipo'] === "USER") ? "Maquinista" : "Admin"; ?></p>
            </div>

            <div class="icones">
                <!-- EDITAR -->
                <a href="../../includes/updateM.php?id=<?php echo $u['id']; ?>">
                    <img class="ic" src="../../assets/icons/editarMaquinistas.png">
                </a>

                <!-- DELETAR -->
                <a href="../../includes/deleteM.php?id=<?php echo $u['id']; ?>">
                    <img class="ic" src="../../assets/icons/lixeira.png">
                </a>

                <!-- INFORMACOES -->
                <a href="telaInformacoes.php?id=<?php echo $u['id']; ?>">
                    <img class="ic" src="../../assets/icons/setinha.png">
                </a>
            </div>
        </div>
    <?php endwhile; ?>
    </div>

    <!-- BOTÃO DE ADICIONAR -->
    <div id="addButton">
        <a href="add.php">
            <img src="../../assets/icons/add.png">
        </a>
    </div>

</body>
</html>