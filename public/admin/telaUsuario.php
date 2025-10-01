<?php
session_start();
include("../../db/conexao.php");

    // garante que o usuário está logado
    if (!isset($_SESSION["user_id"])) {
        header("Location: ../../index.php");
        exit;
    }

    $id = $_SESSION["user_id"];

    // busca os dados do usuário logado
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    $stmt->close();

    if (!$usuario) {
        die("Usuário não encontrado.");
    }
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Tela Usuário</title>
</head>
<body>

    <!-- cabeçalho -->
    <div id="flex4">
        <div class="meio1">
            <a href="paginaInicial.php">
                <img id="seta" src="../../assets/icons/seta.png" alt="seta">
            </a>
        </div>

        <div class="meio1">
            <img id="logo4" src="../../assets/icons/logoTremalize.png" alt="logo">
        </div>

        <div class="meio2">
            <a href="paginaInicial.php">
                <img id="casa1" src="../../assets/icons/casa.png" alt="casa">
            </a>
        </div>
    </div>

    <!-- icone do usuário e o seu nome -->
    <div>
        <img id="iconeUsuario" src="../../assets/icons/usuario.png" alt="Icone Usuário">
        <h2 id="Margin"><?= htmlspecialchars($usuario['nome']) ?></h2>
    </div>

    <!-- quadradinho do logout e meu perfil -->
    <div id="flex">
        <div class="quadradinho4">
            <a href="../login/logout.php">
                <img id="imgTelaUsu" src="../../assets/icons/logout.png" alt="Imagem logout">
                <h2>LOGOUT</h2>
            </a>
        </div>
    
        <div class="quadradinho4">
            <a href="../login/telaEditar.php?id=<?= $usuario['id'] ?>">
                <img id="imgTelaUsu" src="../../assets/icons/meuPerfil.png" alt="Imagem meu perfil">
                <h2>MEU PERFIL</h2>
            </a>
        </div>
    </div>

    <!-- dados pessoais -->
    <div>
        <h2>DADOS PESSOAIS</h2>

        <div>
            <h2 class="dadosPessoais">Nome: <?= htmlspecialchars($usuario['nome']) ?></h2>
            <h2 class="dadosPessoais">Telefone: <?= htmlspecialchars($usuario['telefone']) ?></h2>
            <h2 class="dadosPessoais">Idade: <?= htmlspecialchars($usuario['idade']) ?></h2>
            <h2 class="dadosPessoais">ID: <?= htmlspecialchars($usuario['id']) ?></h2>
        </div>
    </div>

</body>
</html>