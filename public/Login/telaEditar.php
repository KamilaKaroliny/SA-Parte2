<?php 
   session_start();

   include("../db/conexao.php");
   if(!isset($_SESSION['valid'])){
    header("Location: ../../index.php");
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
                    <img id="setaEditar" src="../assets/icons/seta.png" alt="seta">
                </a>
            </div>
    
            <div class="meio7">
                <img id="logoEditar" src="../assets/icons/logoTremalize.png" alt="logo">
            </div>
    
            <div class="meio6">
                <a href="paginaInicial.html">
                    <img id="casaEditar" src="../assets/icons/casa.png" alt="casa">
                </a>
            </div>
        </div> 

        <H1 id="padding">MEU PERFIL</H1>

        <!-- Formulário para Editar -->
        <form action="" id="maquinistaForm">

             <?php 
               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];

                $id = $_SESSION['id'];

                $edit_query = mysqli_query($con,"UPDATE users SET Username='$username', Email='$email', Age='$age' WHERE Id=$id ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Perfil atualizado!</p>
                </div> <br>";
              echo "<a href='home.php'><button class='btn'>Ir para a página inicial</button>";
       
                }
               }else{

                    $id = $_SESSION['id'];
                    $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                    while($result = mysqli_fetch_assoc($query)){
                        $res_Uname = $result['Username'];
                        $res_Email = $result['Email'];
                        $res_Age = $result['Age'];
                    }
            ?>

            <div class="espacamento">
                <label for="nome"></label> 
                <input class="esticadinho2" type="text" name="nome" id="nome" value="" placeholder="Nome completo" autocomplete="off">
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
                <input class="esticadinho2" type="password" name="id" id="id"  value="<?php echo $res_Uname; ?>"  disabled>
                <div class="erro" id="erroId"></div>
                <br>
            </div>
        
            <div class="espacamento">
                <label for="email"></label>
                <input class="esticadinho2" type="text" name="email" id="email"  value="<?php echo $res_Uname; ?>"  disabled>
                <div class="erro" id="erroEmail"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="senha"></label>
                <input class="esticadinho2" type="password" name="senha" id="senha" value="<?php echo $res_Uname; ?>">
                <div class="erro" id="erroSenha"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="confirmarSenha"></label>
                <input class="esticadinho2" type="password" name="confirmarSenha" id="confirmarSenha" value="<?php echo $res_Uname; ?>">
                <div class="erro" id="erroConfirmarSenha"></div>
                <br>
                <br>
            </div>

            <div class="espacamento2">
                <h4>EDITAR</h4>
            </div>
            
        </form>

        <div> 
            <?php } ?>
        </div>

    </header>
</body>
</html>