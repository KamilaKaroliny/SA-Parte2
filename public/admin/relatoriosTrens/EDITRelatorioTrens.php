<?php
include("../../../db/conexao.php");

// PEGAR TREM E RELATÓRIO
$trem_id      = isset($_GET['id_trem']) ? (int)$_GET['id_trem'] : 0;
$id_relatorio = isset($_GET['id_relatorio']) ? (int)$_GET['id_relatorio'] : 0;

if ($trem_id <= 0 || $id_relatorio <= 0) {
    die("ID do trem ou relatório não informado.");
}

// BUSCAR TREM
$sql_trem = "SELECT nome, imagem FROM trem WHERE id = ?";
$stmt_trem = $mysqli->prepare($sql_trem);
$stmt_trem->bind_param("i", $trem_id);
$stmt_trem->execute();
$result_trem = $stmt_trem->get_result();

if ($result_trem->num_rows == 0) {
    die("Trem não encontrado.");
}

$trem = $result_trem->fetch_assoc();
$nome_trem = $trem['nome'];
$imagem_trem = $trem['imagem'] ?: 'default.jpg';

// BUSCAR RELATÓRIO EXISTENTE
$sql_rel = "SELECT * FROM relatorios_trens WHERE id = ? AND id_trem = ?";
$stmt_rel = $mysqli->prepare($sql_rel);
$stmt_rel->bind_param("ii", $id_relatorio, $trem_id);
$stmt_rel->execute();
$result_rel = $stmt_rel->get_result();

if ($result_rel->num_rows == 0) {
    die("Relatório não encontrado.");
}

$relatorio = $result_rel->fetch_assoc();

// TRATAMENTO DO FORMULÁRIO
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $rel_ano               = trim($_POST['ano'] ?? '');
    $rel_mes               = trim($_POST['mes'] ?? '');
    $rel_velocidade_media  = trim($_POST['velocidade_media'] ?? '');
    $rel_km_percorridos    = trim($_POST['km_percorridos'] ?? '');
    $rel_tempo_medio       = trim($_POST['tempo_medio'] ?? '');
    $rel_combustivel_medio = trim($_POST['combustivel_medio'] ?? '');
    $rel_manutencoes       = trim($_POST['manutencoes'] ?? '');
    $rel_incidentes        = trim($_POST['incidentes'] ?? '');

    if (empty($rel_ano) || empty($rel_mes)) {
        $msg = "<p style='color:red'>Ano e Mês são obrigatórios!</p>";
    } else {
        $stmt_update = $mysqli->prepare("
            UPDATE relatorios_trens SET
                ano=?, mes=?, velocidade_media=?, km_percorridos=?,
                tempo_medio_viagem=?, combustivel_medio=?, manutencoes=?,
                incidentes=?
            WHERE id=? AND id_trem=?
        ");

        $stmt_update->bind_param(
            "iiddddiiii",
            $rel_ano, $rel_mes, $rel_velocidade_media, $rel_km_percorridos,
            $rel_tempo_medio, $rel_combustivel_medio, $rel_manutencoes,
            $rel_incidentes, $id_relatorio, $trem_id
        );

        if ($stmt_update->execute()) {
            $msg = "<p style='color:green'>Relatório atualizado com sucesso!</p>";

            $relatorio['ano']               = $rel_ano;
            $relatorio['mes']               = $rel_mes;
            $relatorio['velocidade_media']  = $rel_velocidade_media;
            $relatorio['km_percorridos']    = $rel_km_percorridos;
            $relatorio['tempo_medio_viagem']= $rel_tempo_medio;
            $relatorio['combustivel_medio'] = $rel_combustivel_medio;
            $relatorio['manutencoes']       = $rel_manutencoes;
            $relatorio['incidentes']        = $rel_incidentes;
        } else {
            $msg = "<p style='color:red'>Erro ao atualizar relatório.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Relatório - <?php echo strtoupper($nome_trem); ?></title>
<link rel="stylesheet" href="../../../style/style.css">
</head>
<body class="rel-body">

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

<div class="rel-perfil-trem">
    <h2 class="rel-trem-nome"><?php echo strtoupper($nome_trem); ?></h2>
</div>

<?php if (!empty($msg)) echo "<div class='rel-msg'>{$msg}</div>"; ?>

<form method="POST" class="rel-form">

    <div class="rel-form-group">
        <label class="rel-label">Ano</label>
        <input class="rel-input" type="number" name="ano" required value="<?php echo htmlspecialchars($relatorio['ano']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">Mês</label>
        <input class="rel-input" type="number" name="mes" min="1" max="12" required value="<?php echo htmlspecialchars($relatorio['mes']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">Velocidade Média (KM/H)</label>
        <input class="rel-input" type="number" step="0.1" name="velocidade_media" value="<?php echo htmlspecialchars($relatorio['velocidade_media']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">KM Percorridos</label>
        <input class="rel-input" type="number" step="0.1" name="km_percorridos" value="<?php echo htmlspecialchars($relatorio['km_percorridos']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">Tempo Médio de Viagem (h)</label>
        <input class="rel-input" type="number" step="0.1" name="tempo_medio" value="<?php echo htmlspecialchars($relatorio['tempo_medio_viagem']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">Média de Combustível (L)</label>
        <input class="rel-input" type="number" step="0.1" name="combustivel_medio" value="<?php echo htmlspecialchars($relatorio['combustivel_medio']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">Manutenções Realizadas</label>
        <input class="rel-input" type="number" name="manutencoes" value="<?php echo htmlspecialchars($relatorio['manutencoes']); ?>">
    </div>

    <div class="rel-form-group">
        <label class="rel-label">Incidentes Registrados</label>
        <input class="rel-input" type="number" name="incidentes" value="<?php echo htmlspecialchars($relatorio['incidentes']); ?>">
    </div>

    <button type="submit" class="rel-btn">Atualizar Relatório</button>

</form>

</body>
</html>