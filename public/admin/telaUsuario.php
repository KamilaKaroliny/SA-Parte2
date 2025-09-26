<?php

include("../../db/conexao.php");

$sql = "SELECT * FROM usuario";

$result = $mysqli->query($sql);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>telaChat</title>
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
        <h2 id="Margin">NOME DO USUÁRIO</h2>
    </div>

    <!-- quadradinho do logout e meu perfil -->
    <div id="flex">
        <div class="quadradinho4">
            <a href="../login/logout.php">
                <img id="imgTelaUsu" src="../../assets/icons/logout.png" alt="Imagem logout">
                <H2>LOGOUT</H2>
            </a>
        </div>
    
        <div class="quadradinho4">
            <a href="../login/telaEditar.php?id=<?= $row['id'] ?>">
                <img id="imgTelaUsu" src="../../assets/icons/meuPerfil.png" alt="Imagem meu perfil">
                <H2>MEU PERFIL</H2>
            </a>
        </div>
    </div>

    <!-- dados pessoais -->
    <div>
        <h2>DADOS PESSOAIS</h2>

        <div>
            <h2 class="dadosPessoais">Nome:</h2> 
            <h2 class="dadosPessoais">Telefone:</h2>
            <h2 class="dadosPessoais">Idade:</h2>
            <h2 class="dadosPessoais">ID:</h2>
        </div>
    </div>

</body>

</html>