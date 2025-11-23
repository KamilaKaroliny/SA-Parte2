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

        // CAPTURA
        $nome = trim($_POST['nome'] ?? '');
        $dataNascimento = trim($_POST['dataNascimento'] ?? '');
        $credencial = trim($_POST['id'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = trim($_POST['senha'] ?? '');
        $tipo = $_POST['tipo'] ?? 'USER';
        $telefone = trim($_POST['telefone'] ?? '');
        $cep = trim($_POST['cep'] ?? '');
        $rua = trim($_POST['rua'] ?? '');
        $bairro = trim($_POST['bairro'] ?? '');
        $cidade = trim($_POST['cidade'] ?? '');
        $numero = trim($_POST['numero'] ?? '');
        $complemento = trim($_POST['complemento'] ?? '');

        // VALIDAR CAMPOS OBRIGATÓRIOS
        if (
            empty($nome) || empty($dataNascimento) || empty($telefone) ||
            empty($cep) || empty($rua) || empty($bairro) || empty($cidade) ||
            empty($numero) || empty($credencial) || empty($email) || empty($senha)
        ) {
            echo "<div class='message'><p>Preencha todos os campos obrigatórios!</p></div><br>";
        } else {

            // VERIFICA EMAIL EXISTENTE
            $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "<div class='message'><p>Este e-mail já está em uso!</p></div><br>";
                echo "<a href='javascript:self.history.back()'><button id='button8'>Voltar</button></a>";
            } else {
                $stmt->close();

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                // INSERIR NO BANCO
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
            <input class="esticadinho2" type="text" name="nome">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Data nascimento:</label>
            <input class="esticadinho2" type="text" name="dataNascimento">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Telefone:</label>
            <input class="esticadinho2" type="text" name="telefone" id="telefone">
        </div>

        <div class="api">
            <div class="flex">
                <div class="espacamento4">
                    <label class="labelUp1">CEP:</label>
                    <input class="esticadinho5" type="text" name="cep" id="cep">
                </div>
        
                <div class="espacamento4">
                    <label class="labelUp1">Rua:</label>
                    <input class="esticadinho5" type="text" name="rua" id="rua" readonly>
                </div>
            </div>
    
            <div class="flex">
                <div class="espacamento4">
                    <label class="labelUp1">Bairro:</label>
                    <input class="esticadinho5" type="text" name="bairro" id="bairro" readonly>
                </div>
        
                <div class="espacamento4">
                    <label class="labelUp1">Cidade:</label>
                    <input class="esticadinho5" type="text" name="cidade" id="cidade" readonly>
                </div>
            </div>
    
            <div class="flex">
                <div class="espacamento4">
                    <label class="labelUp1">Número:</label>
                    <input class="esticadinho5" type="text" name="numero">
                </div>
                
                <div class="espacamento4">
                    <label class="labelUp1">Complemento:</label>
                    <input class="esticadinho5" type="text" name="complemento">
                </div>
            </div>
        </div>

        <div class="espacamento">
            <label class="labelUp1">ID empresa:</label>
            <input class="esticadinho2" type="text" name="id">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Email:</label>
            <input class="esticadinho2" type="email" name="email">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Senha:</label>
            <input class="esticadinho2" type="password" name="senha">
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

<!-- API ViaCEP (mantida, não é validação) -->
<script>
document.getElementById("cep").addEventListener("blur", function () {
    let cep = this.value.replace(/\D/g, "");
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(r => r.json())
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