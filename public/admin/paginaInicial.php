<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">

    <title>Tremalize</title>

</head>

<body>

 <?php include("../../includes/abaNotificacaoADM.php"); ?>

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
        <div>
            <div id="flex">
                <a href="mapa.php">
                    <div class="quadradinho1"><img class="imgTelaInicial" src="../../assets/icons/trilho.png"
                            alt="Imagem de Trilho">
                        <h3 id="flex">MAPA</h3>
                    </div>
                </a>
                <a href="usuario/telaUsuarios.php">
                    <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/usuarios.png"
                        alt="Imagem Usuários">
                        <h3 id="flex" style="margin-top: 10px " ;>USUARIOS</h3>
                    </div>
                </a>
            </div>
        </div>

        <div>
            <div id="flex">
                <a href="trens/telaCircular.php">
                    <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/linhas.png" alt="Imagem Linhas">
                        <h3 id="flex">TRENS</h3>
                    </div>
                </a>
                <a href="../login/perfil.php">
                    <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/usuario.png"
                        alt="Imagem Usuário">
                        <h3 id="flex">PERFIL</h3>
                    </div>
                </a>
            </div>
        </div>

            <div id="flex">
                <a href="feedback.php">
                    <div class="quadradinho1"> <img class="imgTelaInicial" src="../../assets/icons/feedback.png"
                            alt="Imagem Feedback">
                        <h3 id="flex">FEEDBACK</h3>
                    </div>
                </a>

            </div>
        </div>
    </div>

</body>

</html>