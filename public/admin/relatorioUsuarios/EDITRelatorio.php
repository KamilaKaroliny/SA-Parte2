<?php
include("../../../db/conexao.php");

// PEGAR USUÁRIO SELECIONADO
$maquinista_id = isset($_GET['id_usuario']) ? (int)$_GET['id_usuario'] : 0;
$id_relatorio = isset($_GET['id_relatorio']) ? (int)$_GET['id_relatorio'] : 0;

if ($maquinista_id <= 0 || $id_relatorio <= 0) {
    die("ID do usuário ou relatório não informado.");
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

// BUSCAR RELATÓRIO EXISTENTE
$sql_rel = "SELECT * FROM relatorios WHERE id = ? AND id_usuario = ?";
$stmt_rel = $mysqli->prepare($sql_rel);
$stmt_rel->bind_param("ii", $id_relatorio, $maquinista_id);
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
    $rel_tempo_empresa     = trim($_POST['tempo_empresa'] ?? '');
    $rel_qtd_viagens       = trim($_POST['qtd_viagens'] ?? '');
    $rel_advertencias      = trim($_POST['advertencias'] ?? '');

    if (empty($rel_ano) || empty($rel_mes)) {
        $msg = "<p style='color:red'>Ano e Mês são obrigatórios!</p>";
    } else {
        $stmt_update = $mysqli->prepare("
            UPDATE relatorios SET
                ano=?, mes=?, velocidade_media=?, km_percorridos=?,
                tempo_medio_viagem=?, combustivel_medio=?, tempo_empresa=?,
                quantidade_viagens=?, advertencias=?
            WHERE id=? AND id_usuario=?
        ");

        $stmt_update->bind_param(
            "iiddddddiii",
            $rel_ano, $rel_mes, $rel_velocidade_media, $rel_km_percorridos,
            $rel_tempo_medio, $rel_combustivel_medio, $rel_tempo_empresa,
            $rel_qtd_viagens, $rel_advertencias, $id_relatorio, $maquinista_id
        );

        if ($stmt_update->execute()) {
            $msg = "<p style='color:green'>Relatório atualizado com sucesso!</p>";
            // Atualiza os valores para preencher novamente o formulário
            $relatorio['ano'] = $rel_ano;
            $relatorio['mes'] = $rel_mes;
            $relatorio['velocidade_media'] = $rel_velocidade_media;
            $relatorio['km_percorridos'] = $rel_km_percorridos;
            $relatorio['tempo_medio_viagem'] = $rel_tempo_medio;
            $relatorio['combustivel_medio'] = $rel_combustivel_medio;
            $relatorio['tempo_empresa'] = $rel_tempo_empresa;
            $relatorio['quantidade_viagens'] = $rel_qtd_viagens;
            $relatorio['advertencias'] = $rel_advertencias;
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
<title>Editar Relatório - <?php echo strtoupper($nome_maquinista); ?></title>
<link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<header>
    <div class="meio7">
        <a href="READRelatorio.php?id=<?php echo $maquinista_id; ?>">
            <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
        </a>
    </div>

    <img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
    <h1 id="padding">EDITAR RELATÓRIO</h1>
</header>

<main class="rel-form-container">

    <div class="rel-perfil">
        <img src="../../../assets/images/<?php echo $foto_maquinista; ?>" class="rel-perfil-foto" alt="Foto do Maquinista">
        <h2><?php echo strtoupper($nome_maquinista); ?></h2>
    </div>

    <?php if (!empty($msg)) echo $msg; ?>

    <form action="" method="POST" class="rel-form">

        <div class="rel-input-group">
            <label>Ano:</label>
            <input type="number" name="ano" required value="<?php echo htmlspecialchars($relatorio['ano']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Mês:</label>
            <input type="number" name="mes" min="1" max="12" required value="<?php echo htmlspecialchars($relatorio['mes']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Velocidade Média (KM/H):</label>
            <input type="number" step="0.1" name="velocidade_media" value="<?php echo htmlspecialchars($relatorio['velocidade_media']); ?>">
        </div>

        <div class="rel-input-group">
            <label>KM Percorridos:</label>
            <input type="number" step="0.1" name="km_percorridos" value="<?php echo htmlspecialchars($relatorio['km_percorridos']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Tempo Médio de Viagem (h):</label>
            <input type="number" step="0.1" name="tempo_medio" value="<?php echo htmlspecialchars($relatorio['tempo_medio_viagem']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Média de Combustível (L):</label>
            <input type="number" step="0.1" name="combustivel_medio" value="<?php echo htmlspecialchars($relatorio['combustivel_medio']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Tempo de Empresa (anos):</label>
            <input type="number" name="tempo_empresa" value="<?php echo htmlspecialchars($relatorio['tempo_empresa']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Quantidade de Viagens:</label>
            <input type="number" name="qtd_viagens" value="<?php echo htmlspecialchars($relatorio['quantidade_viagens']); ?>">
        </div>

        <div class="rel-input-group">
            <label>Advertências:</label>
            <input type="number" name="advertencias" value="<?php echo htmlspecialchars($relatorio['advertencias']); ?>">
        </div>

        <div class="rel-input-group">
            <button type="submit">Atualizar Relatório</button>
        </div>

    </form>
</main>

</body>
</html>