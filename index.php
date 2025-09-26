<?php 
   session_start();
?>

<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>

<body>

    <!-- Nessa div está o formulario e a logo com o nome login -->
    <div class="flex">

            <?php 
             
              include("./db/conexao.php");
              if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                }else{
                    echo "<div class='message'>
                      <p>Nome de usuário ou senha incorretos</p>
                       </div> <br>";
                   echo "<a href='index.php'><button class='btn'>Voltar</button>";
         
                }
                if(isset($_SESSION['valid'])){
                    header("Location: ../public/admin/paginainicial.php");
                }
              }else{

            
            ?>

        <div id="formulario">
            <img id = "logo" src="./assets/icons/logoTremalize.png" alt="Logo Tremalize">
            <h1 id="padding">LOGIN</h1>

            <form action="" id="gestorForm">
        
                <label for="email"></label><br>
                <input class="esticadinho" type="email" nome="email" id="email" value="" placeholder="E-mail" autocomplete="off">
                <div class="erro" id="erroEmail">
    
                <label for="senha"></label><br>
                <input class="esticadinho"  nome="senha" id="senha" value="" placeholder="Senha" autocomplete="off">
                <div class="erro" id="erroSenha">

                <div id="esqueceuSenhaa">
                    <a href="./public/esqueceusenha.html">Esqueceu a senha?</a>
                </div>
                <br>
                <br>
                
                <!-- botão que leva a validação no JS -->
                <button id='button1' type="submit">Enviar</button>
                
            </form>

        </div>
        
        <div> 
            <?php } ?>
        </div>

    </div>

</body>

</html>