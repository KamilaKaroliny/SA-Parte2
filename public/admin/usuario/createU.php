<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/style.css">
    <title>cadastrar novo usuario</title>
</head>

<body>
<header>

    <div class="meio7">
        <a href="telaUsuarios.php">
            <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
        </a>
    </div>

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
        $tipo = $_POST['tipo'] ?? 'USER';
        $telefone = $_POST['telefone'] ?? '';
        $cep = $_POST['cep'] ?? '';
        $rua = $_POST['rua'] ?? '';
        $bairro = $_POST['bairro'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $complemento = $_POST['complemento'] ?? '';

        // Verifica senha
        if ($senha !== $confirmarSenha) {
            echo "<div class='message'><p>As senhas não coincidem.</p></div><br>";
        } else {

            // Verifica email existente
            $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "<div class='message'><p>Este e-mail já está em uso, tente outro.</p></div><br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Voltar</button></a>";
            } else {
                $stmt->close();

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                // INSERIR NO BANCO COM ENDEREÇO COMPLETO
                $stmt = $mysqli->prepare(
                    "INSERT INTO usuarios 
                    (nome, senha, credencial, email, tipo, data_nascimento, telefone, cep, rua, cidade, bairro, numero, complemento)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );

                $stmt->bind_param(
                    "sssssssssssis",
                    $nome, $senhaHash, $credencial, $email, $tipo, $dataNascimento,
                    $telefone, $cep, $rua, $cidade, $bairro, $numero, $complemento
                );

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

    <!-- FORMULÁRIO -->
    <form action="" id="maquinistaForm" method="POST">

        <div class="espacamento">
            <label class="labelUp1">Nome:</label>
            <input class="esticadinho2" type="text" name="nome" autocomplete="off">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Data nascimento:</label>
            <input class="esticadinho2" type="text" name="dataNascimento" autocomplete="off">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Telefone:</label>
            <input class="esticadinho2" type="text" name="telefone" id="telefone" autocomplete="off">
        </div>

        <div class="api">
            <div class="flex">
                <div class="espacamento4">
                    <label class="labelUp1">CEP:</label>
                    <input class="esticadinho5" type="text" name="cep" id="cep" autocomplete="off">
                </div>
        
                <div class="espacamento4">
                    <label class="labelUp1">Rua:</label>
                    <input class="esticadinho5" type="text" name="rua" id="rua" autocomplete="off" readonly>
                </div>
            </div>
    
            <div class="flex">
                <div class="espacamento4">
                    <label class="labelUp1">Bairro:</label>
                    <input class="esticadinho5" type="text" name="bairro" id="bairro" autocomplete="off" readonly>
                </div>
        
                <div class="espacamento4">
                    <label class="labelUp1">Cidade:</label>
                    <input class="esticadinho5" type="text" name="cidade" id="cidade" autocomplete="off" readonly>
                </div>
            </div>
    
            <div class="flex">
                <div class="espacamento4">
                    <label class="labelUp1">Número:</label>
                    <input class="esticadinho5" type="text" name="numero" autocomplete="off">
                </div>
                
                <div class="espacamento4">
                    <label class="labelUp1">Complemento:</label>
                    <input class="esticadinho5" type="text" name="complemento" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="espacamento">
            <label class="labelUp1">ID empresa:</label>
            <input class="esticadinho2" type="text" name="id" autocomplete="off">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Email:</label>
            <input class="esticadinho2" type="text" name="email" autocomplete="off">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Senha:</label>
            <input class="esticadinho2" type="password" name="senha" autocomplete="off">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Confirmar senha:</label>
            <input class="esticadinho2" type="password" name="confirmarSenha" autocomplete="off">
        </div>

        <div class="espacamento">
            <label class="labelUp2">Tipo:</label>
            <select class="esticadinho4" name="tipo">
                <option value="USER">Maquinista</option>
                <option value="ADM">Administrador</option>
            </select>
        </div>

        <div class="espacamento">
            <button id='button8' type="submit">Cadastrar</button>
        </div>

    </form>

    <?php } ?>

</header>

<!-- API ViaCEP -->
<script>
document.getElementById("cep").addEventListener("blur", function(){

    let cep = this.value.replace(/\D/g, "");

    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(resp => resp.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById("rua").value = data.logradouro;
                    document.getElementById("bairro").value = data.bairro;
                    document.getElementById("cidade").value = data.localidade;
                }
            });
    }
});
</script>

</body>
</html>