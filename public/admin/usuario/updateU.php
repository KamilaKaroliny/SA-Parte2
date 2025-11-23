<?php
include("../../../db/conexao.php");

// PEGAR ID
$id = $_GET['id'] ?? 0;

// BUSCAR USUÁRIO PARA EDITAR
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Usuário não encontrado.");
}

$u = $result->fetch_assoc();

// SE O FORM FOR ENVIADO (UPDATE)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome     = $_POST['nome'];
    $dataNasc = $_POST['dataNascimento'];
    $cred     = $_POST['credencial'];
    $email    = $_POST['email'];
    $telefone = $_POST['telefone'];
    $tipo     = $_POST['tipo'];

    // novos campos
    $cep   = $_POST['cep'];
    $rua   = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];

    $sqlUpdate = "UPDATE usuarios 
                  SET nome=?, data_nascimento=?, credencial=?, email=?, telefone=?, tipo=?, 
                      cep=?, rua=?, bairro=?, cidade=?, numero=?, complemento=?
                  WHERE id=?";
    $stmtUpd = $mysqli->prepare($sqlUpdate);
    $stmtUpd->bind_param("ssssssssssssi", 
        $nome, $dataNasc, $cred, $email, $telefone, $tipo,
        $cep, $rua, $bairro, $cidade, $numero, $complemento,
        $id
    );

    if ($stmtUpd->execute()) {
        header("Location:telaUsuarios.php?msg=editado");
        exit;
    } else {
        echo "Erro ao atualizar: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<div class="meio7">
    <a href="telaUsuarios.php">
        <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
    </a>
</div>

<img id="logo2" src="../../../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
<h1 id="padding">EDITAR USUÁRIO</h1>

<form action="" method="POST" id="maquinistaForm">

    <div class="espacamento">
        <label class="labelUp1">Nome:</label>
        <input class="esticadinho2" type="text" name="nome" value="<?php echo $u['nome']; ?>" required>
    </div>

    <div class="espacamento">
        <label class="labelUp1">Data de nascimento:</label>
        <input class="esticadinho2" type="text" name="dataNascimento" value="<?php echo $u['data_nascimento']; ?>">
    </div>

    <div class="espacamento">
        <label class="labelUp1">ID empresa:</label>
        <input class="esticadinho2" type="text" name="credencial" value="<?php echo $u['credencial']; ?>">
    </div>

    <div class="espacamento">
        <label class="labelUp1">Email:</label>
        <input class="esticadinho2" type="email" name="email" value="<?php echo $u['email']; ?>" required>
    </div>

    <div class="espacamento">
        <label class="labelUp1">Telefone:</label>
        <input class="esticadinho2" type="text" name="telefone" value="<?php echo $u['telefone']; ?>">
    </div>

    <div class="api">
        
        <div class="flex">
            <div class="espacamento4">
                <label class="labelUp1">CEP:</label>
                <input class="esticadinho5" type="text" id="cep" name="cep" value="<?php echo $u['cep']; ?>">
            </div>
        
            <div class="espacamento4">
                <label class="labelUp1">Rua:</label>
                <input class="esticadinho5" type="text" id="rua" name="rua" value="<?php echo $u['rua']; ?>">
            </div>
        </div>
            
        <div class="flex">
            <div class="espacamento4">
                <label class="labelUp1">Bairro:</label>
                <input class="esticadinho5" type="text" id="bairro" name="bairro" value="<?php echo $u['bairro']; ?>">
            </div>
            
            <div class="espacamento4">
                <label class="labelUp1">Cidade:</label>
                <input class="esticadinho5" type="text" id="cidade" name="cidade" value="<?php echo $u['cidade']; ?>">
            </div>
        </div>

        <div class="flex">
            <div class="espacamento4">
                <label class="labelUp1">Número:</label>
                <input class="esticadinho5" type="text" name="numero" value="<?php echo $u['numero']; ?>">
            </div>
        
            <div class="espacamento4">
                <label class="labelUp1">Complemento:</label>
                <input class="esticadinho5" type="text" name="complemento" value="<?php echo $u['complemento']; ?>">
            </div>
        </div>

    </div>

    <div class="espacamento">
        <label class="labelUp2">Tipo:</label>
        <select class="esticadinho4" name="tipo">
            <option value="USER" <?php echo ($u['tipo'] === "USER") ? "selected" : ""; ?>>Maquinista</option>
            <option value="ADM"  <?php echo ($u['tipo'] === "ADM") ? "selected" : ""; ?>>Administrador</option>
        </select>
    </div> <br>

    <div class="espacamento3">
        <button id='button7' type="submit">Salvar Alterações</button>
    </div>

</form>

<!-- VIA CEP -->
<script>
document.getElementById("cep").addEventListener("blur", async function () {
    let cep = this.value.replace(/\D/g, "");

    if (cep.length === 8) {
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);

        let dados = await response.json();

        if (!dados.erro) {
            document.getElementById("rua").value = dados.logradouro;
            document.getElementById("bairro").value = dados.bairro;
            document.getElementById("cidade").value = dados.localidade;
        }
    }
});
</script>

</body>
</html>