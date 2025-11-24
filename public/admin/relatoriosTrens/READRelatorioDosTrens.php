<?php
include("../../../db/conexao.php");

// PEGAR PARÂMETROS
$trem_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rel_ano = isset($_GET['ano']) ? (int)$_GET['ano'] : null;
$rel_mes = isset($_GET['mes']) ? (int)$_GET['mes'] : null;

if ($trem_id <= 0 || $rel_ano === null || $rel_mes === null) {
    die("Parâmetros insuficientes.");
}

// BUSCAR TREM
$sql_trem = "SELECT nome, tipo FROM trem WHERE id = ?";
$stmt_trem = $mysqli->prepare($sql_trem);
$stmt_trem->bind_param("i", $trem_id);
$stmt_trem->execute();
$result_trem = $stmt_trem->get_result();

if ($result_trem->num_rows == 0) {
    die("Trem não encontrado.");
}

$trem = $result_trem->fetch_assoc();
$nome_trem = $trem['nome'];
$tipo_trem = $trem['tipo'];

// BUSCAR RELATÓRIO DO MÊS
$sql_relatorio = "
    SELECT velocidade_media, km_percorridos, tempo_medio_viagem, combustivel_medio, manutencoes, incidentes
    FROM relatorios_trens
    WHERE id_trem = ? AND ano = ? AND mes = ?
    LIMIT 1
";
$stmt_rel = $mysqli->prepare($sql_relatorio);
$stmt_rel->bind_param("iii", $trem_id, $rel_ano, $rel_mes);
$stmt_rel->execute();
$result_rel = $stmt_rel->get_result();

if ($result_rel->num_rows == 0) {
    die("Nenhum relatório encontrado para este mês.");
}

$relatorio = $result_rel->fetch_assoc();

// VARIÁVEIS PARA HTML
$rel_velocidade_media = $relatorio['velocidade_media'];
$rel_km_percorridos = $relatorio['km_percorridos'];
$rel_tempo_medio = $relatorio['tempo_medio_viagem'];
$rel_combustivel_medio = $relatorio['combustivel_medio'];
$rel_manutencoes = $relatorio['manutencoes'];
$rel_incidentes = $relatorio['incidentes'];

// FUNÇÃO PARA NOME DO MÊS
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
    <title>Relatório - <?php echo strtoupper($nome_trem); ?> - <?php echo nomeMes($rel_mes) . "/" . $rel_ano; ?></title>
    <link rel="stylesheet" href="../../../style/style.css">
    <link rel="stylesheet" href="../../../style/relatorio_maquinista.css">
</head>
<body>
<!-- cabeçalho -->
<header class="rel-header">
    <div id="cabecalhoEditar">
        <div class="meio7">
            <a href="READRelatorioTrens.php?id=<?php echo $trem_id; ?>">
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
</header>

<main class="rel-main">
    <!-- Perfil -->
    <div class="rel-perfil">
        <h3 class="rel-perfil-nome"><?php echo strtoupper($nome_trem); ?></h3>
        <hr class="rel-separator">
        <h4 class="rel-mes-ano"><?php echo nomeMes($rel_mes) . "/" . $rel_ano; ?></h4>
    </div>

    <!-- Cards -->
    <div class="rel-cards">
        <div class="rel-card">
            <strong>Velocidade Média</strong>
            <span><?php echo $rel_velocidade_media; ?> KM/H</span>
        </div>
        <div class="rel-card">
            <strong>KM Percorridos</strong>
            <span><?php echo $rel_km_percorridos; ?></span>
        </div>
        <div class="rel-card">
            <strong>Tempo Médio de Viagem</strong>
            <span><?php echo $rel_tempo_medio; ?> h</span>
        </div>
        <div class="rel-card">
            <strong>Média de Combustível</strong>
            <span><?php echo $rel_combustivel_medio; ?> L</span>
        </div>
        <div class="rel-card">
            <strong>Manutenções</strong>
            <span><?php echo $rel_manutencoes; ?></span>
        </div>
        <div class="rel-card">
            <strong>Incidentes</strong>
            <span><?php echo $rel_incidentes; ?></span>
        </div>
    </div>
</main>
</body>
</html>