<?php
include("../../../db/conexao.php");

$busca = isset($_GET['q']) ? trim($_GET['q']) : "";

$sql = "SELECT id, nome, tipo FROM trem";

if ($busca !== "") {
    $sql .= " WHERE nome LIKE ? ORDER BY nome ASC";
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
    <link rel="stylesheet" href="../../../style/style.css">
    <title>Lista de Trens</title>
</head>
<body>

    <!-- cabeçalho -->
    <div id="cabecalhoEditar">
        <div class="meio7">
            <a href="../paginaInicial.php">
                <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
            </a>
        </div>

        <div class="meio7">
            <img id="logoEditar" src="../../../assets/icons/logoTremalize.png" alt="logo">
        </div>

        <div class="meio6">
            <a href="../paginaInicial.php">
                <img id="casaEditar" src="../../../assets/icons/casa.png" alt="casa">
            </a>
        </div>
    </div>

    <!-- barra de pesquisa -->
    <form method="GET" id="searchContainer">
        <input 
            type="text" name="q" id="pesquisa" placeholder="Pesquisa" 
            value="<?php echo htmlspecialchars($busca); ?>">
        <button type="submit" id="btnBuscar">
            <img id="lupa" src="../../../assets/icons/lupa.png" alt="buscar">
        </button>
    </form>

    <!-- listagem -->
    <div class="lista">
    <?php while ($u = $result->fetch_assoc()): ?>

        <div class="card usuario">
            <div class="infos">
                <h2><?php echo strtoupper($u['nome']); ?></h2>

                <p>
                <?php
                    $tipos = [
                        "CIR" => "Circular",
                        "CAR" => "Carga",
                        "TUR" => "Turismo"
                    ];
                    echo $tipos[$u['tipo']] ?? "Tipo desconhecido";
                ?>
                </p>
            </div>
                <div class="icones">

                <!-- INFORMAÇÕES -->
                <a href="../telaInformacoes.php?id=<?php echo $u['id']; ?>">
                    <img class="ic" src="../../../assets/icons/setinha.png">
                </a>
            </div>
        </div>

    <?php endwhile; ?>
    </div>

</body>
</html>