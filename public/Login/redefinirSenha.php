<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Redefinir senha</title>

<body>
    <div class="flex">

        <div id="formulario">
            <img id = "logo" src="./assets/icons/logoTremalize.png" alt="Logo Tremalize">
            <h1 id="padding">Alterar senhas</h1>

            <form action="" id="gestorForm" method="POST">
        
                <label for="email"></label><br>
                <input class="esticadinho" type="email" name="email" id="email" value="" placeholder="E-mail">
                <div class="erro" id="erroEmail">
    
                <label for="senha"></label><br>
                <input class="esticadinho" name="senha" id="senha" value="" placeholder="Senha">
                <div class="erro" id="erroSenha">

                <div id="esqueceuSenhaa">
                    <a href="public/login/esqueceuSenha.php">Esqueceu a senha?</a>
                </div>
                <br>
                <br>
                
                <button id='button1' type="submit">Enviar</button>
                
            </form>

        </div>

    </div>

</body>

</html>