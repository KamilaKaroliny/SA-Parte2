<?php
include("../../../db/conexao.php");

// PEGAR USUÁRIO SELECIONADO
$maquinista_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($maquinista_id <= 0) {
    die("ID do usuário não informado.");
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

// TRATAMENTO DO FORMULÁRIO
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CAPTURAR CAMPOS
    $rel_ano               = trim($_POST['ano'] ?? '');
    $rel_mes               = trim($_POST['mes'] ?? '');
    $rel_velocidade_media  = trim($_POST['velocidade_media'] ?? '');
    $rel_km_percorridos    = trim($_POST['km_percorridos'] ?? '');
    $rel_tempo_medio       = trim($_POST['tempo_medio'] ?? '');
    $rel_combustivel_medio = trim($_POST['combustivel_medio'] ?? '');
    $rel_tempo_empresa     = trim($_POST['tempo_empresa'] ?? '');
    $rel_qtd_viagens       = trim($_POST['qtd_viagens'] ?? '');
    $rel_advertencias      = trim($_POST['advertencias'] ?? '');

    // VALIDAR CAMPOS OBRIGATÓRIOS
    if (
        empty($rel_ano) || empty($rel_mes)
    ) {
        $msg = "<p style='color:red'>Ano e Mês são obrigatórios!</p>";
    } else {
        // INSERIR NO BANCO
        $stmt = $mysqli->prepare("
            INSERT INTO relatorios_usuarios
            (id_usuario, ano, mes, velocidade_media, km_percorridos, tempo_medio_viagem,
            combustivel_medio, tempo_empresa, quantidade_viagens, advertencias)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiidddiiii",
            $maquinista_id, $rel_ano, $rel_mes, $rel_velocidade_media, $rel_km_percorridos,
            $rel_tempo_medio, $rel_combustivel_medio, $rel_tempo_empresa, $rel_qtd_viagens, $rel_advertencias
        );

        if ($stmt->execute()) {
            $msg = "<p style='color:green'>Relatório adicionado com sucesso!</p>";
        } else {
            $msg = "<p style='color:red'>Erro ao adicionar relatório.</p>";
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
    <title>Adicionar Relatório - <?php echo strtoupper($nome_maquinista); ?></title>
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
    <h1 id="padding">ADICIONAR RELATÓRIO</h1>
</header>

<main class="rel-form-container">

    <div class="rel-perfil">
        <img src="../../../assets/images/<?php echo $foto_maquinista; ?>" class="rel-perfil-foto" alt="Foto do Maquinista">
        <h2><?php echo strtoupper($nome_maquinista); ?></h2>
    </div>

    <?php if (!empty($msg)) echo $msg; ?>

    <form action="" method="POST" class="rel-form">
        <!-- MANTER ID DO USUÁRIO OU TREM SE NECESSÁRIO -->
        <input type="hidden" name="id" value="<?php echo $id_usuario ?? $trem_id; ?>">

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
            <label class="rel-label">Tempo de Empresa (anos)</label>
            <input class="rel-input" type="number" name="tempo_empresa">
        </div>

        <div class="rel-form-group">
            <label class="rel-label">Quantidade de Viagens</label>
            <input class="rel-input" type="number" name="qtd_viagens">
        </div>

        <div class="rel-form-group">
            <label class="rel-label">Advertências</label>
            <input class="rel-input" type="number" name="advertencias">
        </div>

        <div class="rel-form-group">
            <button type="submit" class="rel-btn">Adicionar Relatório</button>
        </div>
    </form>

</main>

</body>
</html>