<?php
include("../../../db/conexao.php"); 

// Pegar o ID do usuário da URL
$id_usuario = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_usuario <= 0) {
    die("ID do usuário inválido.");
}

// Buscar dados do usuário
$sql_user = "SELECT nome, tipo, foto_perfil FROM usuarios WHERE id = ?";
$stmt_user = $mysqli->prepare($sql_user);

if (!$stmt_user) {
    die("Erro na query SQL (usuário): " . $mysqli->error);
}

$stmt_user->bind_param("i", $id_usuario);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    die("Usuário não encontrado.");
}

$usuario = $result_user->fetch_assoc();
$nome = $usuario['nome'];
$foto = $usuario['foto_perfil'] ?: 'default.jpg';

// Buscar relatórios do usuário
$sql_rel = "SELECT * FROM relatorios WHERE id_usuario = ? ORDER BY data DESC";
$stmt_rel = $mysqli->prepare($sql_rel);

if (!$stmt_rel) {
    die("Erro na query SQL (relatórios): " . $mysqli->error);
}

$stmt_rel->bind_param("i", $id_usuario);
$stmt_rel->execute();
$result_rel = $stmt_rel->get_result();

// Organizar relatórios por ano e mês
$relatoriosPorAnoMes = [];
while ($rel = $result_rel->fetch_assoc()) {
    $ano = date('Y', strtotime($rel['data']));
    $mes = date('m', strtotime($rel['data']));
    $mesNome = strftime('%B', mktime(0, 0, 0, $mes, 10));
    $mesNome = ucfirst($mesNome);

    $relatoriosPorAnoMes[$ano][$mesNome][] = $rel;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/style.css">
    <title>Relatórios</title>
</head>
<body>

    <!-- Topo -->
    <div id="flex7">
        <a href="../telaInformacoes.php?id=<?php echo $id_usuario; ?>">
            <img id="seta" src="../../../assets/icons/seta.png" alt="voltar">
        </a>
        <a href="../../paginaInicial.php">
            <img id="casa1" src="../../../assets/icons/casa.png" alt="home">
        </a>
    </div>

    <!-- Logo -->
    <div>
        <img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo Tremalize">
    </div>

    <main>

        <!-- Foto + Nome -->
        <div style="text-align:center;">
            <br>
            <img src="../../../assets/images/<?php echo $foto; ?>" 
                 style="width:130px; height:130px; border-radius:50%; object-fit:cover;">
            <h3><?php echo strtoupper($nome); ?></h3>
            <p style="color:white; margin-top:-10px;">RELATÓRIOS</p>
        </div>

        <br>

        <?php if (empty($relatoriosPorAnoMes)): ?>
            <p style="color:white; font-size:16px;">
                Nenhum relatório cadastrado ainda.
            </p>
        <?php else: ?>
            <?php foreach ($relatoriosPorAnoMes as $ano => $meses): ?>
                <h2 style="color:white;"><?php echo $ano; ?></h2>
                <?php foreach ($meses as $mesNome => $relatorios): ?>
                    <h3 style="color:white; margin-left:10px;"><?php echo $mesNome; ?></h3>
                    <?php foreach ($relatorios as $rel): ?>
                        <div id="cartaoRelatorio">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span id="subTexto1">
                                    <?php echo date('d/m/Y', strtotime($rel['data'])); ?>
                                </span>
                                <span id="subTexto2">
                                    <?php echo $rel['horas_trabalhadas']; ?>H
                                </span>
                            </div>

                            <div style="margin-top:10px;">
                                <span id="subTexto3">Linha:</span>
                                <span id="textoInfoRelatorio">
                                    <?php echo $rel['linha']; ?>
                                </span>
                            </div>

                            <div style="margin-top:5px;">
                                <span id="subTexto3">Resumo:</span>
                                <p id="textoInfoRelatorio">
                                    <?php echo nl2br($rel['observacoes']); ?>
                                </p>
                            </div>

                            <br>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>

</body>
</html>