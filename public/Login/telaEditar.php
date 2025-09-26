<?php 
   include("../../db/conexao.php");
   session_start();

    $id = $_GET['id'];
    $dados = $mysqli->query("SELECT * FROM usuario WHERE id=$id")->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['name'];
        $senha = $_POST['senha'];
        $confirmasenha = $_POST['confirmasenha'];

        $sql = "UPDATE usuarios SET name ='$name',senha ='$senha',confirmasenha ='$confirmasenha' WHERE id=$id";

        if ($mysqli->query($sql) === true) {
            echo "Registro atualizado com sucesso.
            <a href='read.php'>Ver registros.</a>
            ";
        } else {
            echo "Erro " . $sql . '<br>' . $mysqli->error;
        }
        $mysqli->close();
        exit(); 
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Tremalize</title>
</head>

<body>
    <header>

        <!-- Logo e nome do Meu Perfil -->
        <div id="cabecalhoEditar">
            <div class="meio7">
                <a href="../public/admin/telaUsuario.html">
                    <img id="setaEditar" src="../../assets/icons/seta.png" alt="seta">
                </a>
            </div>
    
            <div class="meio7">
                <img id="logoEditar" src="../../assets/icons/logoTremalize.png" alt="logo">
            </div>
    
            <div class="meio6">
                <a href="paginaInicial.html">
                    <img id="casaEditar" src="../../assets/icons/casa.png" alt="casa">
                </a>
            </div>
        </div> 

        <H1 id="padding">MEU PERFIL</H1>

        <!-- Formulário para Editar -->
        <form action="" id="maquinistaForm">

            <div class="espacamento">
                <label for="nome"></label> 
                <input class="esticadinho2" type="text" name="nome" id="nome" value="<?= $dados['nome'] ?>" placeholder="Nome completo" autocomplete="off">
                <div class="erro" id="erroNome"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="data nascimento"></label> 
                <input class="esticadinho2" type="text" name="dataNascimento" id="dataNascimento" value="" placeholder="Data de Nascimento" disabled>
                <div class="erro" id="erroDataNascimento"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="ID da empresa"></label> 
                <input class="esticadinho2" type="password" name="id" id="id"  value="" placeholder="ID da empresa" disabled>
                <div class="erro" id="erroId"></div>
                <br>
            </div>
        
            <div class="espacamento">
                <label for="email"></label>
                <input class="esticadinho2" type="text" name="email" id="email"  value="" placeholder="Email" disabled>
                <div class="erro" id="erroEmail"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="senha"></label>
                <input class="esticadinho2" type="password" name="senha" id="senha" value="<?= $dados['senha'] ?>">
                <div class="erro" id="erroSenha"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="confirmarSenha"></label>
                <input class="esticadinho2" type="password" name="confirmarSenha" id="confirmarSenha" value="<?= $dados['confirmasenha'] ?>">
                <div class="erro" id="erroConfirmarSenha"></div>
                <br>
                <br>
            </div>

            <div class="espacamento2">
                <h4>EDITAR</h4>
            </div>
            
        </form>

    </header>
</body>
</html>