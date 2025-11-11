<?php 
include("../../db/conexao.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

// ID do usuário logado (não vem mais da URL!)
$id = $_SESSION['user_id'];

// busca os dados do usuário correspondente
$stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dados = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

        $sql = "UPDATE usuarios SET nome = ?, senha = ?, WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssi", $nome, $senha, $id);

        if ($stmt->execute()) {
            echo "Registro atualizado com sucesso.
            <a href='telaUsuario.php?id=$id'>Voltar ao perfil</a>
            ";
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
        $mysqli->close();
        exit(); 
}
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Tremalize</title>
</head>

<body>
    <header>

        <div id="cabecalhoEditar">
            <div class="meio7">
                <a href="../admin/telaUsuario.php">
                    <img id="setaEditar" src="../../assets/icons/seta.png" alt="seta">
                </a>
            </div>
    
            <div class="meio7">
                <img id="logoEditar" src="../../assets/icons/logoTremalize.png" alt="logo">
            </div>
    
            <div class="meio6">
                <a href="../admin/paginaInicial.php">
                    <img id="casaEditar" src="../../assets/icons/casa.png" alt="casa">
                </a>
            </div>
        </div> 

        <h1 id="padding">MEU PERFIL</h1>

        <!-- Formulário para Editar -->
        <form action="" method="post" id="maquinistaForm">

            <!-- Nome (editável) -->
            <div class="espacamento">
                <input class="esticadinho2" type="text" name="nome" id="nome" 
                       value="<?= htmlspecialchars($dados['nome']) ?>" 
                       placeholder="Nome completo" autocomplete="off">
                <br>
            </div>

            <!-- Data de Nascimento (somente visualização) -->
            <div class="espacamento">
                <input class="esticadinho2" type="text" name="data_nascimento" id="data_nascimento" 
                       value="<?= htmlspecialchars($dados['data_nascimento']) ?>"
                       disabled>
                <br>
            </div>

            <!-- ID do usuário (somente visualização) -->
            <div class="espacamento">
                <input class="esticadinho2" type="text"  
                       value="<?= $dados['id'] ?>" disabled>
                <br>
            </div>
        
            <!-- Email (somente visualização) -->
            <div class="espacamento">
                <input class="esticadinho2" type="text" name="email" id="email"
                       value="<?= htmlspecialchars($dados['email']) ?>" disabled>
                <br>
            </div>

            <!-- Senha (editável) -->
            <div class="espacamento">
                <input class="esticadinho2" type="password" name="senha" id="senha" 
                       value="<?= htmlspecialchars($dados['senha']) ?>">
                <br>
            </div>

            <!-- Botão salvar -->
             <button id='button6' type="submit"> Salvar </button>
            
        </form>

    </header>
</body>
</html>