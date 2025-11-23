<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/style.css">
    <title>cadastrar novo usuario</title>
</head>

<body>
    <header>

        <!-- Logo e nome do Cadastro -->
        <img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
        <H1 id="padding">CADASTRO</H1>

        <?php 
        include("../../../db/conexao.php");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST['nome'] ?? '';
            $dataNascimento = $_POST['dataNascimento'] ?? '';
            $credencial = $_POST['id'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmarSenha'] ?? '';
            $tipo = 'USER';

            // Verifica se senhas coincidem
            if ($senha !== $confirmarSenha) {
                echo "<div class='message'><p>As senhas não coincidem.</p></div><br>";
            } else {
                // Verifica se e-mail já existe
                $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    echo "<div class='message'><p>Este e-mail já está em uso, tente outro por favor!</p></div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Voltar</button></a>";
                } else {
                    $stmt->close();

                    // Criptografa a senha
                    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                    // Insere usuário
                    $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, senha, credencial, email, tipo, data_nascimento) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $nome, $senhaHash, $credencial, $email, $tipo, $dataNascimento);
                    if ($stmt->execute()) {
                        echo "<div class='message'><p>Cadastro realizado com sucesso!</p></div><br>";
                        echo "<a href='telaUsuarios.php'><button id='button8'>Acessar agora</button></a>";
                    } else {
                        echo "<div class='message'><p>Erro ao cadastrar usuário.</p></div><br>";
                    }

                    $stmt->close();
                }
            }
        } else {
        ?>

        <!-- Formulário do cadastro -->
        <form action="" id="maquinistaForm" method="POST">

            <div class="espacamento">
                <label for="nome"></label> 
                <input class="esticadinho2" type="text" name="nome" id="nome" value="" placeholder="Nome completo" autocomplete="off">
                <div class="erro" id="erroNome"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="data nascimento"></label> 
                <input class="esticadinho2" type="text" name="dataNascimento" id="dataNascimento" value="" placeholder="Data de Nascimento" autocomplete="off">
                <div class="erro" id="erroDataNascimento"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="ID da empresa"></label> 
                <input class="esticadinho2" type="password" name="id" id="id"  value="" placeholder="ID da empresa" autocomplete="off">
                <div class="erro" id="erroId"></div>
                <br>
            </div>
        
            <div class="espacamento">
                <label for="email"></label>
                <input class="esticadinho2" type="text" name="email" id="email"  value="" placeholder="E-mail" autocomplete="off">
                <div class="erro" id="erroEmail"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="senha"></label>
                <input class="esticadinho2" type="password" name="senha" id="senha" value="" placeholder="Senha" autocomplete="off">
                <div class="erro" id="erroSenha"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="confirmarSenha"></label>
                <input class="esticadinho2" type="password" name="confirmarSenha" id="confirmarSenha" value="" placeholder="Confirmar Senha" autocomplete="off">
                <div class="erro" id="erroConfirmarSenha"></div>
                <br>
                <br>
            </div>

            <div class="espacamento">
                <br>
                <a href="telaUsuarios.php">
                    <button id='button8' type="submit"> Cadastrar </button>
                </a>
            </div>
            
        </form>

             </div>
                <?php } ?>
            </div>

    </header>
</body>
</html>