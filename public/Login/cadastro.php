<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>cadastro</title>
</head>

<body>
    <header>

        <!-- Logo e nome do Cadastro -->
        <img id="logo2" src="../assets/icons/logoTremalize.png" alt="Logo do Tremalize">
        <H1 id="padding">CADASTRO</H1>

        <?php 
         
        include("php/config.php");
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $dataNascimento = $_POST['dataNascimento'];
            $id = $_POST['id'];
            $email = $_POST['email'];
            $password = $_POST['password'];

         // verificando se o e-mail é único

        $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

        if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message'>
                      <p>Este e-mail já está em uso, tente outro por favor!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Voltar</button>";
        }
        else{

            mysqli_query($con,"INSERT INTO users(Username,Email,dataNascimento,Password) VALUES('$username','$dataNascimento','$id','$email','$password')") or die("Erroe Occured");

            echo "<div class='message'>
                      <p>Cadastro realizado com sucesso!</p>
                  </div> <br>";
            echo "<a href='../../index.php'><button class='btn'>Acessar agora</button>";
         

        }

        }else{
         
        ?>

        <!-- Formulário do cadastro -->
        <form action="" id="maquinistaForm">

            <div class="espacamento">
                <label for="nome"></label> 
                <input class="esticadinho2" type="text" name="nome" id="nome" value="" placeholder="Nome completo" autocomplete="off">
                <div class="erro" id="erroNome"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="data nascimento"></label> 
                <input class="esticadinho2" type="text" name="dataNascimento" id="dataNascimento" value="" placeholder="Data de Nascimento" autocomplete="off">
                <div class="erro" id="erroDataNascimento"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="ID da empresa"></label> 
                <input class="esticadinho2" type="password" name="id" id="id"  value="" placeholder="ID da empresa" autocomplete="off">
                <div class="erro" id="erroId"></div>
                <br>
            </div>
        
            <div class="espacamento">
                <label for="email"></label>
                <input class="esticadinho2" type="text" name="email" id="email"  value="" placeholder="E-mail" autocomplete="off">
                <div class="erro" id="erroEmail"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="senha"></label>
                <input class="esticadinho2" type="password" name="senha" id="senha" value="" placeholder="Senha" autocomplete="off">
                <div class="erro" id="erroSenha"></div>
                <br>
            </div>

            <div class="espacamento">
                <label for="confirmarSenha"></label>
                <input class="esticadinho2" type="password" name="confirmarSenha" id="confirmarSenha" value="" placeholder="Confirmar Senha" autocomplete="off">
                <div class="erro" id="erroConfirmarSenha"></div>
                <br>
                <br>
            </div>

            <div class="espacamento">
                <br>
                <a href="../../index.php">
                    <button id='button2' type="submit"> ⟶ </button>
                </a>
            </div>
            
        </form>

             </div>
                <?php } ?>
            </div>

    </header>
</body>
</html>