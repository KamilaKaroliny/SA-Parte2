 <?php 
  session_start();
  include("../../db/conexao.php"); 


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $localizacao = $_POST['localizacao'];
    $icone = $_POST['icone'] ?? null;

    if (!empty($localizacao) && !empty($icone)) {
        $sql = "INSERT INTO marcacao (localizacao, icone) VALUES ('$localizacao', '$icone')";

        if ($mysqli->query($sql) === true) {

            $_SESSION['ultima_marcacao_local'] = $localizacao;
            $_SESSION['ultima_marcacao_icone'] = $icone;

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } 
    }
 }

  $sql_listar = "SELECT * FROM marcacao ORDER BY id DESC";
  $resultado_marcacoes = $mysqli->query($sql_listar);
 ?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../style/styleMapa.css"/>
  <link rel="stylesheet" href="../../style/style.css" />
  <title>Tremalize</title>
</head>
<body>

  <!-- Cabeçalho -->
  <header class="cabecalho">

    <div id="containerCabecalho">
      <div class="colunaCabecalhoEsq">
          <a href="paginaInicial.php">
              <img id="iconeVoltar" src="../../assets/icons/seta.png" alt="seta">
          </a>
      </div>

      <div class="colunaCabecalhoCentro">
          <img id="logoTremalize" src="../../assets/icons/logoTremalize.png" alt="logo">
      </div>

      <div class="colunaCabecalhoDir">
          <a href="paginaInicial.php">
              <img id="iconeHome" src="../../assets/icons/casa.png" alt="casa">
          </a>
      </div>
    </div>

  </header>

  <main>

    <!-- Legenda -->
    <section class="secaoClima">

      <div class="containerClima">

        <!-- Umidade -->
        <div class="boxClimaInfo">
          <h4>20% UR</h4>
          <img src="../../assets/icons/umidade.png" alt="Ícone Umidade" />
        </div>

        <!-- Temperatura -->
        <div class="boxClimaInfo">
          <h4>30°C</h4>
          <img src="../../assets/icons/sol.png" alt="Ícone Sol" />
        </div>
      
          <label>
            <input class="noticacao" type="checkbox"> 

              <!-- Icone para ver a legenda -->
              <div class="toggle, boxClimaInfo">
                <img src="../../assets/icons/legenda.png" alt="icone de marcação">
              </div>

              <!-- Tela da legenda -->
              <div class="invisivel"></div>
                <div class="legenda">
                    <h2 class="tituloMapa">Legenda</h2>

                    <div class="imagemLegenda">
                      <div class="ajustarLegenda">
                        <img src="../../assets/icons/Circular.avif" alt="Icone circular vermelho">
                        <br>
                        <h3>Circular</h3>
                      </div>
                    </div>
                  
                  <div class="ajustarLegenda">
                    <img src="../../assets/icons/Carga.webp" alt="Icone carga laranja">
                    <br>
                    <h3>Carga</h3>
                  </div>

                  <div class="ajustarLegenda">
                    <img src="../../assets/icons/Turismo.webp" alt="Icone turismo verde">
                    <br>
                    <h3>Turismo</h3>
                  </div>

                  <div class="ajustarLegenda">
                    <img src="../../assets/icons/acidente.png" alt="Icone de acidente">
                    <br>
                    <h3>Acidente</h3>
                  </div>
                  
                  <div class="ajustarLegenda">
                    <img src="../../assets/icons/obras.png" alt="Icone de obras">
                    <br>
                    <h3>Obras</h3>
                  </div>
                  
                  <div class="ajustarLegenda">
                    <img src="../../assets/icons/quebraNoTrilho.png" alt="Icone de quebra no trilho">
                    <br>
                    <h3>Quebra no trilho</h3>
                  </div>

                </div>
                </div>
              </label>
          </label>
         
      </div>

    </section>

    <!-- Mapa -->
    <section class="secaoMapaGoogle">
      <div class="containerMapa">

        <iframe
          title="Mapa"
          width="100%"
          height="350"
          frameborder="0"
          style="border:0"
          src="https://maps.google.com/maps?q=Joinville&z=12&output=embed"
          allowfullscreen>
        </iframe>

      </div>
    </section>

    <!-- Informações -->
    <section class="secaoInfoTrem">
      
      <!-- Bateria do Trem-->
      <div class="cartaoInfoTrem">

        <div class="iconeBateriaContainer">
          <img class= "iconeBateria" src="../../assets/icons/bateria.png" alt="bateria dos trens">
        </div>

        <!-- Nome do Trem-->
        <div>
          <div class="tremInfoContainer">
            <h2>Circular: 1970</h2>
          </div>
        </div>

        <!-- Icone do Trem-->
        <div class="tremInfoContainer">
          <img class="imagemTrem" src="../../assets/icons/trenzinho.png" alt="Trem circular">
        </div>

        <!-- Botão do maquinista para ele receber as infos deles -->
        <div class="infoComplementarTrem">
          <a href="telaInformacoes.php?id=2">
              <button class="boxMaquinistaInfo">
                <img src="../../assets/icons/maquinistas.png" alt="icone do motorista">
                <div>
                  <h4>Cloadoaldo</h4>
                </div>
              </button>
          </a>

          <!-- Informação de próxima parada -->
          <div class="boxMaquinistaInfo">
            <h5>Próxima Parada:</h5>
            <h6>Jardim Sofia</h6>
            <h3>15:30</h3>
          </div>

          <!-- Botão de Marcação -->
          <label>
            <input class="noticacao" type="checkbox">

              <div class="toggleMapa, boxMaquinistaInfo">
                <img src="../../assets/icons/marcacao.png" alt="icone de marcação">
                <h4>Marcação</h4>
              </div>

              <!-- Tela de Marcação -->
              <div class="invisivel"></div>
              <div class="notificacoesMapa">
                

                <div class="boxMarcacao">
                  <h2 class="tituloMapa">MARCAÇÃO:</h2>

                  <a href="editarMarcacao.php">
                    <div class="boxMarcacaoEditar" style = "margin-left: 10px;" >
                      <div class="iconeMarcacaoContainer">
                        <img class= "iconeMarcacao" src="../../assets/icons/editar.png" alt="bateria dos trens">
                      </div>
                    </div>
                  </a>
                  
                  
                </div>
                
                <?php
                  if (isset($_SESSION['ultima_marcacao_local']) && isset($_SESSION['ultima_marcacao_icone'])) {

                  $icone = $_SESSION['ultima_marcacao_icone'];
                  $local = $_SESSION['ultima_marcacao_local'];
                }
                ?>

                <form method="POST" action="">
                <div class="imagemMarcacao">
                
                  <input type="radio" name="icone" id="acidente" value="Acidente">
                  <label for="acidente">
                    <img src="../../assets/icons/acidente.png" alt="Ícone de acidente" class="imagemMarcacaoImg">
                  </label>

                  <input type="radio" name="icone" id="obras" value="Obras">
                  <label for="obras">
                    <img src="../../assets/icons/obras.png" alt="Ícone de obras" class="imagemMarcacaoImg">
                  </label>

                  <input type="radio" name="icone" id="quebra" value="Quebra">
                  <label for="quebra">
                    <img src="../../assets/icons/quebraNoTrilho.png" alt="Ícone de quebra no trilho" class="imagemMarcacaoImg">
                  </label>

                </div>

                <div>
                    
                    
                    <input class="localizacao" type="text" name = "localizacao">
               </div>
               
               <div class="botao">
                <input class="botaoMarcacao" type="submit" value="Marcar">
               </div>

              </div>
              </label>
        </div>

        <!-- Tipo do trem -->
        <div class="infoComplementarTrem"> 
          <div class="tremInfoContainer">
            <div class="boxTipoVelocidadeTrem">
             <div class="listaMarcacoes">
               <h3>Marcações recentes:</h3>

               <?php
                  if ($resultado_marcacoes->num_rows > 0) {
                  while ($linha = $resultado_marcacoes->fetch_assoc()) {
                    echo "
                  <div class='itemMarcacao'>
                  <img src='../../assets/icons/".$linha['icone'].".png' style='width:20px; margin-right:6px;'>
                  <span>".$linha['localizacao']."</span>
                  </div>
                  ";
                }
                } else {
                  echo "<p>Nenhuma marcação registrada.</p>";
                }
                ?>
              </div>
          </div>
        </div>
        
      </div>
    </section>
  </main>
</body>
</html>
