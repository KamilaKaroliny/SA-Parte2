<?php
include("../../db/conexao.php"); 

if (!isset($_GET['id'])) {
    die('Maquinista não especificado.');
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM usuarios WHERE id = ? AND tipo = 'USER'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('Maquinista não encontrado.');
}

$maquinista = $result->fetch_assoc();

$nome = $maquinista['nome'];
$telefone = $maquinista['telefone'];
$idade = $maquinista['idade'];
$credencial = $maquinista['credencial'];
$foto = $maquinista['foto_perfil'] ?? 'default.jpg';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Tela de Informações Usuários</title>
</head>
<body>
    <div id="flex7">
        <a href="chat.php?id=<?php echo $id; ?>">
            <img id="seta" src="../../assets/icons/seta.png" alt="seta">
        </a>
        <a href="paginaInicial.php">
            <img id="casa1" src="../../assets/icons/casa.png" alt="casa">
        </a>
    </div>

    <div>
        <img id="logo2" src="../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
    </div>

    <main>
        <div>
            <br><br>
            <img src="../../assets/images/<?php echo $foto; ?>" alt="Foto do maquinista">
            <h3><?php echo strtoupper($nome); ?></h3>
        </div>

        <div id="flex">
            <div class="quadradinho1">
                <a href="chat.php?id=<?php echo $id; ?>">
                    <img id="imgTelaInfo" src="../../assets/icons/mensagens.png" alt="Imagem chat">  
                </a>
                <a href="chat.php?id=<?php echo $id; ?>">
                    <H2>CHAT</H2>
                </a>
            </div>
            <a href="relatorio.php?id=<?php echo $id; ?>">
                <div class="quadradinho1">
                    <img id="imgTelaInfo" src="../../assets/icons/relatorio.png" alt="Imagem relatorio"> 
                    <H2>RELATÓRIO</H2>
                </div>
            </a>
        </div>

        <h3>DADOS PESSOAIS</h3>
        <div class="dados">
            <span><strong>Nome: </strong><?php echo $nome; ?></span><br>
            <span><strong>Telefone: </strong><?php echo $telefone; ?></span><br>
            <span><strong>Idade:</strong> <?php echo $idade; ?> anos</span><br>
            <span><strong>ID: </strong><?php echo $credencial; ?></span>
        </div>
    </main>
</body>
</html>