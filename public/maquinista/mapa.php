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
          <h4 id="umidade">-- % UR</h4>
          <img src="../../assets/icons/umidade.png" alt="Ícone Umidade" />
          </div>

        <!-- Temperatura -->
        <div class="boxClimaInfo">
          <h4 id="temperatura">-- °C</h4>
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

 <style>
  body {
    background: #566abd;
    color: white;
    font-family: Arial;
    padding: 20px;
  }

  .area {
    background: #566abd;
    padding: 20px;
    border-radius: 10px;
    max-width: 900px;
    margin: auto;
  }

  button {
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    background: #2563eb;
    color: white;
    margin-right: 5px;
  }

  button:active {
    transform: scale(0.95);
  }

  #painel {
    margin-top: 20px;
    background: #1e293b;
    padding: 15px;
    border-radius: 10px;
  }

  .sensor-on { 
    fill: #16a34a !important; 
  }
  .sensor-off { 
    fill: #888 !important; 
  }
 </style>

<body>

<div class="area">
  
    <!-- MAPA -->
  <svg id="svgMapa" width="100%" height="400" viewBox="0 0 1000 500">

    <path id="trilho" 
      d="M 150 400
         C 200 300, 350 250, 500 250
         C 650 250, 800 300, 850 400
         C 700 380, 500 380, 300 390
         C 180 395, 150 400, 150 400"
      stroke="white" stroke-width="5" fill="none" />

    <g id="sensores"></g>

    <image 
      id="trem"
      href="../../assets/icons/trenzinho.png"
      width="40"
      height="40"
      x="150"
      y="400"
    />
  </svg>


  <!-- PAINEL -->
  <div id="painel">
    <p>Velocidade atual: <span id="velAtual">0</span> px/s</p>
    <p>Próximo sensor: <span id="proxSensor">—</span></p>
  </div>

</div>


<!-- Informações do trem -->
<section class="secaoInfoTrem">
  <div class="cartaoInfoTrem">

    <div class="iconeBateriaContainer">
      <img class="iconeBateria" src="../../assets/icons/bateria.png">
    </div>

    <div>
      <div class="tremInfoContainer">
        <h2>Expresso Verde</h2>
      </div>
    </div>

    <div class="tremInfoContainer">
      <img class="imagemTrem" src="../../assets/icons/trenzinho.png">
    </div>

    <div class="infoComplementarTrem">
      <button class="boxMaquinistaInfo" disabled>
        <img src="../../assets/icons/maquinistas.png">
        <div><h4>Clodoaldo</h4></div>
      </button>

      <div class="boxMaquinistaInfo">
        <h5>Próxima Parada:</h5>
        <h6>Jardim Sofia</h6>
        <h3>15:30</h3>
      </div>
    </div>

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
                  </div>";
              }
            } else {
              echo "<p>Nenhuma marcação registrada.</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

</main>


<!-- ====================== SCRIPTS ====================== -->
<script>
// =======================================================================
// CONFIGURAÇÃO DO TREM (SIMULADO)
// =======================================================================

const trilho = document.getElementById("trilho");
const caminhoTotal = trilho.getTotalLength();

let sensores = [
  { id: "S1", pct: 0.20, ativo: false },
  { id: "S2", pct: 0.50, ativo: false },
  { id: "S3", pct: 0.80, ativo: false }
];

const grupoSensores = document.getElementById("sensores");

// cria sensores sem clique
function criarSensores() {
  sensores.forEach(s => {
    const pos = caminhoTotal * s.pct;
    const p = trilho.getPointAtLength(pos);

    const c = document.createElementNS("http://www.w3.org/2000/svg", "circle");
    c.setAttribute("cx", p.x);
    c.setAttribute("cy", p.y);
    c.setAttribute("r", 12);
    c.setAttribute("data-id", s.id);
    c.classList.add("sensor-off");

    // maquinista NÃO pode clicar
    c.style.pointerEvents = "none";

    grupoSensores.appendChild(c);
  });
}

criarSensores();


// =======================================================================
// MOVIMENTO DO TREM
// =======================================================================

let trem = {
  el: document.getElementById("trem"),
  posicao: 0,
  velocidadeAtual: 60,
  velocidadeAlvo: 150
};

let rodando = true;
let ultimoTempo = null;

function animar(time) {
  if (!rodando) return requestAnimationFrame(animar);

  if (ultimoTempo === null) ultimoTempo = time;
  const dt = (time - ultimoTempo) / 1000;
  ultimoTempo = time;

  trem.velocidadeAtual += (trem.velocidadeAlvo - trem.velocidadeAtual) * 0.1;
  trem.posicao += trem.velocidadeAtual * dt;

  if (trem.posicao >= caminhoTotal) trem.posicao = 0;

  const p = trilho.getPointAtLength(trem.posicao);
  trem.el.setAttribute("x", p.x - 20);
  trem.el.setAttribute("y", p.y - 20);

  requestAnimationFrame(animar);
}

requestAnimationFrame(animar);


// =======================================================================
// ATUALIZA SENSORES EM TEMPO REAL (via PHP)
// =======================================================================

setInterval(() => {
  fetch("../../../api/sensores/status.php")
    .then(r => r.json())
    .then(dados => {
      sensores.forEach(s => {
        s.ativo = dados[s.id] == 1;

        const el = document.querySelector(`[data-id="${s.id}"]`);
        el.classList.toggle("sensor-on", s.ativo);
        el.classList.toggle("sensor-off", !s.ativo);

        trem.velocidadeAlvo = s.ativo ? 40 : 150;
      });
    });
}, 1000);

</script>
</html>
