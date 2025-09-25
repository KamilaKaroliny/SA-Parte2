<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Josevaldo</title>
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>
    <!-- Parte de cima do chat (seta, foto do maquinista e o nome dele(a)) -->
    <div id="flex-container">
        <a href="telaChat.html">
            <img id="seta" src="../assets/icons/seta.png" alt="seta">
        </a>
        <a href="telaInformacoesJosevaldo.html">
            <img id="josevaldo" src="../assets/images/josevaldo.png" alt="Foto Josevaldo">
        </a>
        <a href="telaInformacoesJosevaldo.html">
            <span id="nome1">JOSEVALDO</span>
        </a>
    </div>

    <!-- mensagens do chat -->
    <div class="container-mensagens">
        <div class="mensagem">Rua Pio XII está interditada!</div>
        <div class="mensagem">Qual a próxima rota?</div>
        <div class="mensagem">Rua 123, Bairro Bonito</div>
    </div>

    <!-- Local para digitar algo e botão de envio -->
    <form id="flex-container1">
        <input class="esticadinho3" type="text" id="mensagem_id" placeholder="Digite aqui..." required>
        <button id="button5" type="submit">
            <img id="entregar" src="../assets/icons/entregar.png" alt="Enviar">
        </button>
    </form>

</body>

</html>