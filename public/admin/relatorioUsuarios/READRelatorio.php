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
$nome = $user['nome'];
$foto = $user['foto_perfil'] ?: 'default.jpg';

// =============================
// ANOS DISPONÍVEIS
// =============================
$sql_anos = "SELECT DISTINCT ano FROM relatorios WHERE id_usuario = ? ORDER BY ano DESC";
$stmt_anos = $mysqli->prepare($sql_anos);
$stmt_anos->bind_param("i", $id_usuario);
$stmt_anos->execute();
$result_anos = $stmt_anos->get_result();

$anos = [];
while ($i = $result_anos->fetch_assoc()) {
    $anos[] = $i['ano'];
}

// Ano selecionado via GET
$anoSelecionado = isset($_GET['ano']) ? (int)$_GET['ano'] : ($anos[0] ?? null);

// =============================
// PAGINAÇÃO DOS MESES (5 POR PÁGINA)
// =============================
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$porPagina = 5;
$offset = ($pagina - 1) * $porPagina;

// =============================
// BUSCAR MESES DO ANO SELECIONADO
// =============================
$sql_meses = "SELECT id, mes FROM relatorios WHERE id_usuario = ? AND ano = ? ORDER BY mes ASC LIMIT ? OFFSET ?";
$stmt_meses = $mysqli->prepare($sql_meses);
$stmt_meses->bind_param("iiii", $id_usuario, $anoSelecionado, $porPagina, $offset);
$stmt_meses->execute();
$result_meses = $stmt_meses->get_result();

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
    <title>Relatórios Usuários</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

    <!-- cabeçalho -->
    <div id="cabecalhoEditar">
        <div class="meio7">
            <a href="../telaInformacoes.php?id=<?php echo $id_usuario; ?>">
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

    <main>

        <!-- Foto + Nome -->
        <div class="perfil">
            <img src="../../../assets/images/<?php echo $foto; ?>" class="perfil-foto">
            <h3 class="perfil-nome"><?php echo strtoupper($nome); ?></h3>
            <hr class="divisor">
        </div>

        <!-- Seleção de ano -->
        <div class="ano-box">
            <form method="GET">
                <input type="hidden" name="id" value="<?php echo $id_usuario; ?>">
                <select name="ano" class="select-ano">
                    <?php foreach ($anos as $a): ?>
                        <option value="<?php echo $a; ?>" <?php echo ($a == $anoSelecionado) ? 'selected' : ''; ?>>
                            <?php echo $a; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-filtrar" type="submit">Filtrar</button>
            </form>
        </div>

        <!-- Lista de meses -->
        <div class="lista">
            <?php if ($result_meses->num_rows == 0): ?>
                <p class="sem-registros">Nenhum relatório encontrado neste ano.</p>
            <?php else: ?>
                <?php while ($m = $result_meses->fetch_assoc()): ?>
                    <div class="cartao">
                        <strong><?php echo nomeMes($m['mes']); ?></strong>

                        <div class="icones">
                            <!-- EDITAR -->
                            <a href="EDITRelatorio.php?id_usuario=<?php echo $id_usuario; ?>&id_relatorio=<?php echo $m['id']; ?>">
                                <img class="ic" src="../../../assets/icons/editarMaquinistas.png">
                            </a>

                            <!-- DELETAR -->
                            <a href="DELETERelatorio.php?id_usuario=<?php echo $id_usuario; ?>&id_relatorio=<?php echo $m['id']; ?>">
                            <img class="ic" src="../../../assets/icons/lixeira.png">
                            </a>

                            <!-- INFORMACOES -->
                            <a href="READRelatorioMaquinista.php?id=<?php echo $id_usuario; ?>&ano=<?php echo $anoSelecionado; ?>&mes=<?php echo $m['mes']; ?>">
                                <img class="ic" src="../../../assets/icons/setinha.png">
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- Botão novo relatório -->
        <div id="addButton">
            <a href="ADDRelatorio.php?id=<?php echo $id_usuario; ?>">
                <img src="../../../assets/icons/add.png">
            </a>
        </div>

    </main>
</body>
</html>