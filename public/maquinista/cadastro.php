<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <script src="../scripts/linkagemDaPagina.js"></script>
    <script src="../scripts/validaCadastro.js"></script>
    <title>cadastro</title>
</head>

<body>
    <header>

        <!-- Logo e nome do Cadastro -->
        <img id="logo2" src="../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
        <H1 id="padding">CADASTRO</H1>

        <!-- Formulário do cadastro -->
        <form action="" id="maquinistaForm">

            <div class="espacamento">
                <label for="nome"></label> 
                <input class="esticadinho2" type="text" name="nome" id="nome" value="" placeholder="Nome completo">
                <div class="erro" id="erroNome"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="data nascimento"></label> 
                <input class="esticadinho2" type="text" name="dataNascimento" id="dataNascimento" value="" placeholder="Data de Nascimento">
                <div class="erro" id="erroDataNascimento"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="ID da empresa"></label> 
                <input class="esticadinho2" type="password" name="id" id="id"  value="" placeholder="ID da empresa">
                <div class="erro" id="erroId"></div>
                <br>
            </div>
        
            <div class="espacamento">
                <label for="email"></label>
                <input class="esticadinho2" type="text" name="email" id="email"  value="" placeholder="E-mail">
                <div class="erro" id="erroEmail"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="senha"></label>
                <input class="esticadinho2" type="password" name="senha" id="senha" value="" placeholder="Senha">
                <div class="erro" id="erroSenha"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="confirmarSenha"></label>
                <input class="esticadinho2" type="password" name="confirmarSenha" id="confirmarSenha" value="" placeholder="Confirmar Senha">
                <div class="erro" id="erroConfirmarSenha"></div>
                <br>
                <br>
            </div>

            <!-- Botão com a validação do JS -->
            <div class="espacamento">
                <br>
                <button id='button2' type="submit"> ⟶ </button>
            </div>
            
        </form>

    </header>
</body>
</html>