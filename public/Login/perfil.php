<?php
session_start();
include("../../db/conexao.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_SESSION["user_id"];

$sql= "SELECT id, nome, foto_perfil, telefone, idade FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    die("Usuário não encontrado.");
}

$nome = $usuario['nome'];
$foto = $usuario['foto_perfil'] ?: 'default.jpg';
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Tela Usuário</title>

</head>
<body>

<?php
    $tipo = $_SESSION["tipo"] ?? "";

    if ($tipo === "ADM") {
        $voltar = "../admin/paginaInicial.php";
        $home   = "../admin/paginaInicial.php";
    } else {
        $voltar = "../maquinista/paginaInicial.php";
        $home   = "../maquinista/paginaInicial.php";
    }
?>

<div id="flex4">
    <div class="meio1">
        <a href="<?= $voltar ?>">
            <img id="seta" src="../../assets/icons/seta.png" alt="seta">
        </a>
    </div>

    <div class="meio1">
        <img id="logo4" src="../../assets/icons/logoTremalize.png" alt="logo">
    </div>

    <div class="meio2">
        <a href="<?= $home ?>">
            <img id="casa1" src="../../assets/icons/casa.png" alt="casa">
        </a>
    </div>
</div>

<div class="perfil-container2">
    <div class="perfil-container1">
        <div class="perfil-foto-box1">
            <img src="../../assets/images/<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" 
                 class="perfil-foto1" alt="Foto de Perfil">
        </div>
    
        <div class="perfil-info1">
            <h2 id="Margin"> <?= htmlspecialchars($usuario['nome']) ?></h2>

            <a class="btn-editar1" href="../login/alterarFoto.php">Editar foto</a>
        </div>
    </div>
</div>

<!-- quadradinho do logout e meu perfil -->
<div id="flex">
    <div class="quadradinho4">
        <a href="../login/logout.php">
            <img id="imgTelaUsu" src="../../assets/icons/logout.png" alt="Imagem logout">
            <h2>LOGOUT</h2>
        </a>
    </div>

    <div class="quadradinho4">
        <a href="../login/telaEditar.php?id=<?= $usuario['id']?>">
            <img id="imgTelaUsu" src="../../assets/icons/meuPerfil.png" alt="Imagem meu perfil">
            <h2>MEU PERFIL</h2>
        </a>
    </div>
</div>

<!-- dados pessoais -->
<div>
    <h2>DADOS PESSOAIS</h2>

    <div>
        <h2 class="dadosPessoais">Nome: <?= htmlspecialchars($usuario['nome']) ?></h2>
        <h2 class="dadosPessoais">Telefone: <?= htmlspecialchars($usuario['telefone']) ?></h2>
        <h2 class="dadosPessoais">Idade: <?= htmlspecialchars($usuario['idade']) ?></h2>
        <h2 class="dadosPessoais">ID: <?= htmlspecialchars($usuario['id']) ?></h2>
    </div>
</div>

</body>
</html>