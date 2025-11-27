<?php
session_start();
include("../../../db/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Trem</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>

<body>
<header>

    <div class="meio7">
        <a href="telaCircular.php">
            <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
        </a>
    </div>

    <img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo">
    <h1 id="padding">CADASTRAR TREM</h1>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $maquinista = trim($_POST['maquinista'] ?? '');

    if (empty($nome) || empty($tipo)) {
        echo "<div class='message'><p>Preencha todos os campos!</p></div><br>";
    } else {

        $stmt = $mysqli->prepare("INSERT INTO trem (nome, tipo, maquinista) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nome, $tipo, $maquinista);

        if ($stmt->execute()) {

            $msg = "Novo trem cadastrado: $nome";
            $tipoNoti = "TREM";
            $n = $mysqli->prepare("INSERT INTO notificacoes (mensagem, tipo) VALUES (?, ?)");
            $n->bind_param("ss", $msg, $tipoNoti);
            $n->execute();

            echo "<div class='message'><p>Trem cadastrado com sucesso!</p></div><br>";
            echo "<a href='telaCircular.php'><button id='button8'>Voltar</button></a>";
        } else {
            echo "<div class='message'><p>Erro ao cadastrar trem.</p></div><br>";
        }

        $stmt->close();
    }

} else {
?>

<form method="POST" id="maquinistaForm">

    <div class="espacamento">
        <label class="labelUp1">Nome do Trem:</label>
        <input class="esticadinho2" type="text" name="nome">
    </div>

    <div class="espacamento">
        <label class="labelUp1">Tipo:</label>
        <select class="esticadinho4" name="tipo">
            <option value="CIR">Circular</option>
            <option value="CAR">Carga</option>
            <option value="TUR">Turismo</option>
        </select>
    </div>

    <div class="espacamento">
        <label for="maquinista" class="labelUp1">Maquinista</label>
        <select name="maquinista" class="esticadinho4" required>
            <?php
                $result = $mysqli->query("SELECT id, nome FROM usuarios WHERE tipo='USER'");
                while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
            ?>
        </select>
    </div>

    <br>
    <div class="espacamento">
        <button id="button8" type="submit">Cadastrar</button>
    </div>

</form>

<?php } ?>

</header>
</body>
</html>