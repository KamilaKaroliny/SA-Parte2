<?php
include("../../../db/conexao.php");

// PEGAR TREM SELECIONADO
$trem_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($trem_id <= 0) {
    die("ID do trem não informado.");
}

// BUSCAR TREM
$sql_trem = "SELECT nome, imagem FROM trem WHERE id = ?";
$stmt_trem = $mysqli->prepare($sql_trem);

if (!$stmt_trem) {
    die("Erro ao preparar consulta: " . $mysqli->error);
}

$stmt_trem->bind_param("i", $trem_id);
$stmt_trem->execute();
$result_trem = $stmt_trem->get_result();

if ($result_trem->num_rows == 0) {
    die("Trem não encontrado.");
}

$trem = $result_trem->fetch_assoc();
$nome_trem = $trem['nome'];
$imagem_trem = $trem['imagem'] ?: 'default_trem.jpg';

$stmt_trem->close();

// TRATAMENTO DO FORMULÁRIO
$msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CAPTURAR CAMPOS
    $rel_ano               = trim($_POST['ano'] ?? '');
    $rel_mes               = trim($_POST['mes'] ?? '');
    $rel_velocidade_media  = trim($_POST['velocidade_media'] ?? '');
    $rel_km_percorridos    = trim($_POST['km_percorridos'] ?? '');
    $rel_tempo_medio       = trim($_POST['tempo_medio'] ?? '');
    $rel_combustivel_medio = trim($_POST['combustivel_medio'] ?? '');
    $rel_manutencoes       = trim($_POST['manutencoes'] ?? '');
    $rel_incidentes        = trim($_POST['incidentes'] ?? '');

    // VALIDAR CAMPOS OBRIGATÓRIOS
    if (empty($rel_ano) || empty($rel_mes)) {
        $msg = "<p style='color:red'>Ano e Mês são obrigatórios!</p>";
    } else {
        // INSERIR NO BANCO
        $stmt = $mysqli->prepare("
            INSERT INTO relatorios_trens
            (id_trem, ano, mes, velocidade_media, km_percorridos, tempo_medio_viagem,
             combustivel_medio, manutencoes, incidentes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            die("Erro ao preparar INSERT: " . $mysqli->error);
        }

        $stmt->bind_param(
            "iiidddiii",
            $trem_id, $rel_ano, $rel_mes, $rel_velocidade_media, $rel_km_percorridos,
            $rel_tempo_medio, $rel_combustivel_medio, $rel_manutencoes, $rel_incidentes
        );

        if ($stmt->execute()) {
            $msg = "<p style='color:green'>Relatório adicionado com sucesso!</p>";
        } else {
            $msg = "<p style='color:red'>Erro ao adicionar relatório: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Relatório - Tremalize</title>
<link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<header>
    <div id="cabecalhoEditar">
        <!-- BOTÃO VOLTAR -->
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

<?php if (!empty($msg)) echo "<div class='msg'>{$msg}</div>"; ?>

<main>
<form method="POST" class="rel-form">
    <!-- MANTER ID DO TREM -->
    <input type="hidden" name="id" value="<?php echo $trem_id; ?>">

    <div class="rel-form-group">
        <label class="rel-label">Ano</label>
        <input class="rel-input" type="number" name="ano" required>
    </div>
    <div class="rel-form-group">
        <label class="rel-label">Mês</label>
        <input class="rel-input" type="number" name="mes" min="1" max="12" required>
    </div>
    <div class="rel-form-group">
        <label class="rel-label">Velocidade Média (KM/H)</label>
        <input class="rel-input" type="number" step="0.1" name="velocidade_media">
    </div>
    <div class="rel-form-group">
        <label class="rel-label">KM Percorridos</label>
        <input class="rel-input" type="number" step="0.1" name="km_percorridos">
    </div>
    <div class="rel-form-group">
        <label class="rel-label">Tempo Médio de Viagem (h)</label>
        <input class="rel-input" type="number" step="0.1" name="tempo_medio">
    </div>
    <div class="rel-form-group">
        <label class="rel-label">Média de Combustível (L)</label>
        <input class="rel-input" type="number" step="0.1" name="combustivel_medio">
    </div>
    <div class="rel-form-group">
        <label class="rel-label">Manutenções Realizadas</label>
        <input class="rel-input" type="number" name="manutencoes">
    </div>
    <div class="rel-form-group">
        <label class="rel-label">Incidentes Registrados</label>
        <input class="rel-input" type="number" name="incidentes">
    </div>
    <button type="submit" class="rel-btn">Adicionar Relatório</button>
</form>
</main>

</body>
</html>
