<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">

    <title>Tremalize</title>

</head>

<body>

    <?php include("../../includes/abaNotificacaoUSER.php"); ?>

    <!-- div flex que comporta a logo -->
    <div id=flex2>
        <div class="meio6">
            <div id=flex2>
                <div class="meio4">
                    <img id="logo3" src="../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
                </div>
            </div>
        </div>
    </div>

    <!-- div que comporta a linkagem de todo o nossa app (chat, mapa, maquinistas...) -->
    <div id="centralizar">
        <div id="flex">
            <a href="mapa.php">
                <div class="quadradinho1"><img class="imgTelaInicial" src="../../assets/icons/trilho.png"
                        alt="Imagem de Trilho">
                    <h3 id="flex">MAPA</h3>
                </div>
            </a>
            <a href="trens/telaCircular.php">
                <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/linhas.png" alt="Imagem Linhas">
                    <h3 id="flex">LINHAS</h3>
                </div>
            </a>
        </div>

        <div id="flex">
            
        </div>
        <div id="flex">
            <a href="../login/perfil.php">
                <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/usuario.png"
                    alt="Imagem Usuário">
                    <h3 id="flex">Perfil</h3>
                </div>
            </a>

            <a href="feedback.php">
                <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/feedback.png"
                        alt="Imagem Feedback">
                    <h3 id="flex">FEEDBACK</h3>
                </div>
            </a>

        </div>
    </div>

</body>

</html>