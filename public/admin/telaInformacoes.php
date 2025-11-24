<?php
include("../../db/conexao.php"); 

// Verifica se o ID foi enviado
if (!isset($_GET['id'])) {
    die('Usuário não especificado.');
}

$id = intval($_GET['id']);

// Busca qualquer usuário (USER ou ADM)
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Caso não encontre nenhum usuário
if ($result->num_rows == 0) {
    die('Usuário não encontrado.');
}

$usuario = $result->fetch_assoc();

// Variáveis
$nome = $usuario['nome'];
$telefone = $usuario['telefone'];
$idade = $usuario['idade'];
$credencial = $usuario['credencial'];
$tipo = $usuario['tipo']; // ADM ou USER
$foto = $usuario['foto_perfil'] ?: 'default.jpg';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Informações do Usuário</title>
</head>
<body>
    <div id="cabecalhoEditar">
            <div class="meio7">
                <a href="usuario/telaUsuarios.php">
                    <img id="setaEditar" src="../../assets/icons/seta.png" alt="seta">
                </a>
            </div>

            <div class="meio7">
                <img id="logoEditar" src="../../assets/icons/logoTremalize.png" alt="logo">
            </div>

            <div class="meio6">
                <a href="paginaInicial.php">
                    <img id="casaEditar" src="../../assets/icons/casa.png" alt="casa">
                </a>
            </div>
    </div>

    <main>

        <!-- Foto + Nome -->
        <div style="text-align:center;">
            <br><br>
            <img src="../../assets/images/<?php echo $foto; ?>" 
                 style="width:130px; height:130px; border-radius:50%; object-fit:cover;">
            <h3><?php echo strtoupper($nome); ?></h3>
            <p style="color:white; margin-top:-10px;">
                <?php echo ($tipo === "ADM" ? "Administrador" : "Maquinista"); ?>
            </p>
        </div>

        <!-- Botões -->
        <div id="flex">
            <!-- RELATÓRIO APENAS PARA MAQUINISTA -->
            <?php if ($tipo === "USER"): ?>
            <a href="relatorioUsuarios/READRelatorio.php?id=<?php echo $id; ?>">
                <div class="quadradinho1">
                    <img id="imgTelaInfo" src="../../assets/icons/relatorio.png" alt="Imagem relatorio"> 
                    <h2>RELATÓRIO</h2>
                </div>
            </a>
            <?php endif; ?>
        </div>

        <!-- Dados pessoais -->
        <h3>DADOS PESSOAIS</h3>
        <div class="dados">
            <span><strong>Nome: </strong><?php echo $nome; ?></span><br>
            <span><strong>Telefone: </strong><?php echo $telefone; ?></span><br>
            <span><strong>Idade: </strong><?php echo $idade; ?> anos</span><br>
            <span><strong>ID (Credencial): </strong><?php echo $credencial; ?></span><br>
            <span><strong>Tipo: </strong><?php echo ($tipo === "ADM" ? "Administrador" : "Maquinista"); ?></span>
        </div>

    </main>
</body>
</html>
