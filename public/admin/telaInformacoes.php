<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <script src="../../scripts/validaLogin.js"></script>
    <title>Tela de Informações Clodoaldo</title>
</head>
<body>
    <!-- Parte de cima do Informações Clodoaldo (flecha, casa e logo) -->
    <div id="flex7">
        <a href="chatClodoaldo.php">
            <img id="seta" src="../../assets/icons/seta.png" alt="seta">
        </a>
        <a href="paginaInicial.php">
            <img id="casa1" src="../../assets/icons/casa.png" alt="casa">
        </a>
    </div>

        <div>
            <img id="logo2" src="../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
        </div>

    <!-- Nome do maquinista e sua Foto -->
    <main>
        <div>
            <br>
            <br>
            <img src="../../assets/images/clodoaldo.png">
            <h3>CLODOALDO KOWALSKI</h3>
        </div>

        <!-- Acessos ao chat e relatório do Maquinista -->
        <div id="flex">
            <div class="quadradinho1">
                <a href="chatClodoaldo.php">
                    <img id="imgTelaInfo" src="../../assets/icons/mensagens.png" alt="Imagem chat">  
                </a>
                <a href="chatClodoaldo.php">
                    <H2>CHAT</H2>
                </a>
            </div>
            <a href="relatorioclodaldo.php">
                <div class="quadradinho1">
                    <img id="imgTelaInfo" src="../../assets/icons/relatorio.png" alt="Imagem relatorio"> 
                    <H2>RELATÓRIO</H2>
                </div>
            </a>
        </div>

        <!-- Dados pessoais do maquinista (Nome, telefone, idade e ID)-->
        <h3>DADOS PESSOAIS</h3>
        <div class="dados">
            <span><strong>Nome: </strong>Clodoaldo Kowalski</span><br>
            <span><strong>Telefone: </strong>+55 (21) 95432-1098</span><br>
            <span><strong>Idade:</strong> 71 anos</span><br>
            <span><strong>ID: </strong>X9Y4Z6A1B3</span>
        </div>

    </main>
    
</body>
</html>