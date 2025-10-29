<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <script src="../../scripts/validaEsqueceusenha2.js"></script>
    <script src="../../scripts/linkagemDaPagina.js"></script>
    <title>Confirmação de senha </title>

</head>
<body>
  <header>
    <!-- Parte de cima do esqueceu senha2 (logo e nome "esqueci senha") -->
      <div id="Esqueceusenha">
        <img id = "logo" src="../../assets/icons/logoTremalize.png" alt="Logo Tremalize">
        <H1 id="padding">ESQUECI A SENHA</H1>

        <!-- formulario "esqueceusenha2" -->
        <form action="" id="esqueceusenha2">
          <label for="novaSenha"></label> <br> 
          <input class="esticadinho" type="text" name="novaSenha" id="novaSenha" value="" placeholder="Sua nova senha">
          <div class="erro" id="erroNovaSenha"></div>
        
          <br> 
            
            
          <label for="codigo"></label> <br>
          <input class="esticadinho" type="password" name="codigo" id="codigo" value="" placeholder="Código">
          <div class="erro" id="erroCodigo"></div>

          <!-- botão do formulario "esqueceusenha" que leva a validação o JS -->
           <div id="separacao">
              <button id='button4' type="submit">Redefinir</button>
           </div>

        </form>

      </div>

  </header>

</body>
</html>