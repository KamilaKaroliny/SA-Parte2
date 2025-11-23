<?php
include("../../../db/conexao.php"); 

// PEGAR PARÂMETROS
$maquinista_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rel_ano = isset($_GET['ano']) ? (int)$_GET['ano'] : null;
$rel_mes = isset($_GET['mes']) ? (int)$_GET['mes'] : null;

if ($maquinista_id <= 0 || $rel_ano === null || $rel_mes === null) {
    die("Parâmetros insuficientes.");
}

// BUSCAR USUÁRIO
$sql_user = "SELECT nome, foto_perfil FROM usuarios WHERE id = ?";
$stmt_user = $mysqli->prepare($sql_user);
$stmt_user->bind_param("i", $maquinista_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    die("Usuário não encontrado.");
}

$user = $result_user->fetch_assoc();
$nome_maquinista = $user['nome'];
$foto_maquinista = $user['foto_perfil'] ?: 'default.jpg';

// BUSCAR RELATÓRIO DO MÊS
$sql_relatorio = "
SELECT velocidade_media, km_percorridos, tempo_medio_viagem, combustivel_medio,
       tempo_empresa, quantidade_viagens, advertencias
FROM relatorios
WHERE id_usuario = ? AND ano = ? AND mes = ?
LIMIT 1
";

$stmt_rel = $mysqli->prepare($sql_relatorio);
$stmt_rel->bind_param("iii", $maquinista_id, $rel_ano, $rel_mes);
$stmt_rel->execute();
$result_rel = $stmt_rel->get_result();

if ($result_rel->num_rows == 0) {
    die("Nenhum relatório encontrado para este mês.");
}

$relatorio = $result_rel->fetch_assoc();

// VARIÁVEIS PARA HTML
$rel_velocidade_media  = $relatorio['velocidade_media'];
$rel_km_percorridos    = $relatorio['km_percorridos'];
$rel_tempo_medio       = $relatorio['tempo_medio_viagem'];
$rel_combustivel_medio = $relatorio['combustivel_medio'];
$rel_tempo_empresa     = $relatorio['tempo_empresa'];
$rel_qtd_viagens       = $relatorio['quantidade_viagens'];
$rel_advertencias      = $relatorio['advertencias'];

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
    <title>Relatório - <?php echo strtoupper($nome_maquinista); ?> - <?php echo nomeMes($rel_mes) . "/" . $rel_ano; ?></title>
    <link rel="stylesheet" href="../../../style/style.css">
    <link rel="stylesheet" href="../../../style/relatorio_maquinista.css">
</head>
<body>

    <!-- cabeçalho -->
    <header class="rel-header">
    <div id="cabecalhoEditar">
            <div class="meio7">
                <a href="READRelatorio.php?id=<?php echo $maquinista_id; ?>">
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
            <img src="../../../assets/images/<?php echo $foto_maquinista; ?>" class="rel-perfil-foto" alt="Foto do Maquinista">
            <h3 class="rel-perfil-nome"><?php echo strtoupper($nome_maquinista); ?></h3>
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
                <strong>Tempo de Empresa</strong>
                <span><?php echo $rel_tempo_empresa; ?> anos</span>
            </div>
            <div class="rel-card">
                <strong>Quantidade de Viagens</strong>
                <span><?php echo $rel_qtd_viagens; ?></span>
            </div>
            <div class="rel-card">
                <strong>Advertências</strong>
                <span><?php echo $rel_advertencias; ?></span>
            </div>
        </div>
    </main>

</body>
</html>