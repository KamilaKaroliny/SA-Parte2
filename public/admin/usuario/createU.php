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
        $mensagemErro = "Preencha todos os campos obrigatórios!";
    } else {

        // VERIFICA EMAIL EXISTENTE
        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagemErro = "Este e-mail já está em uso!";
            $stmt->close();
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
                // Insere notificação
                $mensagemNoti = "Novo maquinista cadastrado: " . $nome;
                $stmtNoti = $mysqli->prepare("INSERT INTO notificacoes (mensagem) VALUES (?)");
                $stmtNoti->bind_param("s", $mensagemNoti);
                $stmtNoti->execute();
                $stmtNoti->close();

                $mensagemSucesso = "Cadastro realizado com sucesso!";
                header("Location: telaUsuarios.php?msg=cadastrado");
                exit;
            } else {
                $mensagemErro = "Erro ao cadastrar usuário.";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
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

    <?php if (!empty($mensagemErro)): ?>
        <div class='message'><p><?php echo $mensagemErro; ?></p></div><br>
    <?php endif; ?>

    <?php if (!empty($mensagemSucesso)): ?>
        <div class='message'><p><?php echo $mensagemSucesso; ?></p></div><br>
    <?php endif; ?>

    <!-- FORMULÁRIO -->
    <form action="" id="maquinistaForm" method="POST">

        <div class="espacamento">
            <label class="labelUp1">Nome:</label>
            <input class="esticadinho2" type="text" name="nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Data nascimento:</label>
            <input class="esticadinho2" type="text" name="dataNascimento" value="<?php echo htmlspecialchars($dataNascimento ?? ''); ?>">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Telefone:</label>
            <input class="esticadinho2" type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($telefone ?? ''); ?>">
        </div>

        <div class="api">
            <div class="flexApi">
                <div class="espacamento4">
                    <label class="labelUp1">CEP:</label>
                    <input class="esticadinho5" type="text" name="cep" id="cep" value="<?php echo htmlspecialchars($cep ?? ''); ?>">
                </div>
        
                <div class="espacamento4">
                    <label class="labelUp1">Rua:</label>
                    <input class="esticadinho5" type="text" name="rua" id="rua" readonly value="<?php echo htmlspecialchars($rua ?? ''); ?>">
                </div>
            </div>
    
            <div class="flexApi">
                <div class="espacamento4">
                    <label class="labelUp1">Bairro:</label>
                    <input class="esticadinho5" type="text" name="bairro" id="bairro" readonly value="<?php echo htmlspecialchars($bairro ?? ''); ?>">
                </div>
        
                <div class="espacamento4">
                    <label class="labelUp1">Cidade:</label>
                    <input class="esticadinho5" type="text" name="cidade" id="cidade" readonly value="<?php echo htmlspecialchars($cidade ?? ''); ?>">
                </div>
            </div>
    
            <div class="flexApi">
                <div class="espacamento4">
                    <label class="labelUp1">Número:</label>
                    <input class="esticadinho5" type="text" name="numero" value="<?php echo htmlspecialchars($numero ?? ''); ?>">
                </div>
                
                <div class="espacamento4">
                    <label class="labelUp1">Complemento:</label>
                    <input class="esticadinho5" type="text" name="complemento" value="<?php echo htmlspecialchars($complemento ?? ''); ?>">
                </div>
            </div>
        </div>

        <div class="espacamento">
            <label class="labelUp1">ID empresa:</label>
            <input class="esticadinho2" type="text" name="id" value="<?php echo htmlspecialchars($credencial ?? ''); ?>">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Email:</label>
            <input class="esticadinho2" type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
        </div>

        <div class="espacamento">
            <label class="labelUp1">Senha:</label>
            <input class="esticadinho2" type="password" name="senha">
        </div>

        <div class="espacamento">
            <label class="labelUp2">Tipo:</label>
            <select class="esticadinho4" name="tipo">
                <option value="USER" <?php echo (isset($tipo) && $tipo === "USER") ? "selected" : ""; ?>>Maquinista</option>
                <option value="ADM" <?php echo (isset($tipo) && $tipo === "ADM") ? "selected" : ""; ?>>Administrador</option>
            </select>
        </div> <br>

        <div class="espacamento">
            <button id='button8' type="submit">Cadastrar</button>
        </div>

    </form>

</header>

<!-- API ViaCEP -->
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