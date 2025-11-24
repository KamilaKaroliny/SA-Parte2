<?php
include("../../../db/conexao.php");

// =============================
// PEGAR ID DO USUÁRIO
// =============================
$id_usuario = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_usuario <= 0) {
    die("ID do usuário não informado.");
}

// =============================
// BUSCAR DADOS DO USUÁRIO
// =============================
$sql_user = "SELECT nome, foto_perfil FROM usuarios WHERE id = ?";
$stmt_user = $mysqli->prepare($sql_user);
$stmt_user->bind_param("i", $id_usuario);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    die("Usuário não encontrado.");
}

$usuario = $result_user->fetch_assoc();
$nome_usuario = $usuario['nome'];
$foto_usuario = $usuario['foto_perfil'] ?: 'default.jpg';

// =============================
// BUSCAR ANOS DISPONÍVEIS
// =============================
$sql_anos = "SELECT DISTINCT ano FROM relatorios_usuarios WHERE id_usuario = ? ORDER BY ano DESC";
$stmt_anos = $mysqli->prepare($sql_anos);
$stmt_anos->bind_param("i", $id_usuario);
$stmt_anos->execute();
$result_anos = $stmt_anos->get_result();

$anos = [];
while ($a = $result_anos->fetch_assoc()) {
    $anos[] = $a['ano'];
}

// definir ano selecionado
$anoSelecionado = isset($_GET['ano']) ? (int)$_GET['ano'] : ($anos[0] ?? null);

// =============================
// PAGINAÇÃO
// =============================
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$porPagina = 5;
$offset = ($pagina - 1) * $porPagina;

// =============================
// BUSCAR MESES DO ANO
// =============================
$sql_meses = "SELECT * FROM relatorios_usuarios 
              WHERE id_usuario = ? AND ano = ?
              ORDER BY mes ASC LIMIT ? OFFSET ?";

$stmt_meses = $mysqli->prepare($sql_meses);
$stmt_meses->bind_param("iiii", $id_usuario, $anoSelecionado, $porPagina, $offset);
$stmt_meses->execute();
$result_meses = $stmt_meses->get_result();

// =============================
// FUNÇÃO PARA NOME DO MÊS
// =============================
function nomeMes($m) {
    $nomes = [
        1=>"Janeiro", 2=>"Fevereiro", 3=>"Março", 4=>"Abril",
        5=>"Maio", 6=>"Junho", 7=>"Julho", 8=>"Agosto",
        9=>"Setembro", 10=>"Outubro", 11=>"Novembro", 12=>"Dezembro"
    ];
    return $nomes[$m] ?? "Mês ?";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - <?php echo strtoupper($nome_usuario); ?></title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

    <!-- CABEÇALHO NO MESMO LAYOUT DA EDIÇÃO -->
    <div id="cabecalhoEditar">
        <div class="meio7">
            <a href="../usuario/telaUsuarios.php">
                <img id="setaEditar" src="../../../assets/icons/seta.png" alt="voltar">
            </a>
        </div>

        <div class="meio7">
            <img id="logoEditar" src="../../../assets/icons/logoTremalize.png" alt="logo">
        </div>

        <div class="meio6">
            <a href="../paginaInicial.php">
                <img id="casaEditar" src="../../../assets/icons/casa.png" alt="home">
            </a>
        </div>
    </div>

    <main>

        <!-- FOTO E NOME -->
        <div class="perfil">
            <img src="../../../assets/images/<?php echo $foto_usuario; ?>" class="rel-perfil-foto" alt="Foto">
            <h3 class="perfil-nome"><?php echo strtoupper($nome_usuario); ?></h3>
            <hr class="divisor">
        </div>

        <!-- SELEÇÃO DE ANO -->
        <div class="ano-box">
            <form method="GET">
                <input type="hidden" name="id" value="<?php echo $id_usuario; ?>">
                <select name="ano" class="select-ano">
                    <?php foreach ($anos as $a): ?>
                        <option value="<?php echo $a; ?>" <?php echo ($a == $anoSelecionado ? "selected" : ""); ?>>
                            <?php echo $a; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-filtrar" type="submit">Filtrar</button>
            </form>
        </div>

        <!-- LISTA DE MESES -->
        <div class="lista">
            <?php if ($result_meses->num_rows == 0): ?>
                <p class="sem-registros">Nenhum relatório encontrado neste ano.</p>
            <?php else: ?>
                <?php while ($mes = $result_meses->fetch_assoc()): ?>
                    <div class="cartao">
                        <strong><?php echo nomeMes($mes['mes']); ?></strong>

                        <div class="icones">

                            <!-- EDITAR -->
                            <a href="EDITRelatorio.php?id_usuario=<?php echo $id_usuario; ?>&id_relatorio=<?php echo $mes['id']; ?>">
                                <img class="ic" src="../../../assets/icons/editarMaquinistas.png" alt="Editar">
                            </a>

                            <!-- DELETAR -->
                            <a href="DELETERelatorio.php?id_usuario=<?php echo $id_usuario; ?>&id_relatorio=<?php echo $mes['id']; ?>">
                                <img class="ic" src="../../../assets/icons/lixeira.png" alt="Excluir">
                            </a>

                            <!-- VER RELATÓRIO -->
                             <a href="READRelatorioMaquinista.php?id=<?php echo $id_usuario; ?>&ano=<?php echo $anoSelecionado; ?>&mes=<?php echo $m['mes']; ?>">
                                <img class="ic" src="../../../assets/icons/setinha.png" alt="Ver">
                            </a>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- ADICIONAR NOVO -->
        <div id="addButton">
            <a href="ADDRelatorio.php?id=<?php echo $id_usuario; ?>">
                <img src="../../../assets/icons/add.png" alt="Adicionar">
            </a>
        </div>

    </main>

</body>
</html>