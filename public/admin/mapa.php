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
  
  <!-- Mapa -->
  <svg id="svgMapa" width="100%" height="400" viewBox="0 0 1000 500">

    
    <path id="trilho" 
      d="M 150 400
         C 200 300, 350 250, 500 250
         C 650 250, 800 300, 850 400
         C 700 380, 500 380, 300 390
         C 180 395, 150 400, 150 400"
      stroke="white" stroke-width="5" fill="none" />

    
    <g id="sensores"></g>

    <!-- Trem -->
    <image 
    id="trem"
    href="../../assets/icons/trenzinho.png"
    width="40"
    height="40"
    x="150"
    y="400"
    />


  </svg>

  <!-- Botões -->
  <div style="margin-top:10px;">
    <button id="btnIniciar">Iniciar</button>
    <button id="btnPausar">Pausar</button>
    <button id="btnReset">Resetar</button>
  </div>

  <!-- Painel -->
  <div id="painel">
    <p>Velocidade atual: <span id="velAtual">0</span> px/s</p>
    <p>Próximo sensor: <span id="proxSensor">—</span></p>
  </div>

</div>

<script>

const trilho = document.getElementById('trilho');

// ❗ Primeiro calcula o comprimento do trilho
const caminhoTotal = trilho.getTotalLength();


let sensores = [
  { id: "S1", pct: 0.20, ativo: false },
  { id: "S2", pct: 0.50, ativo: false },
  { id: "S3", pct: 0.80, ativo: false }
];


const grupoSensores = document.getElementById('sensores');

// Criar marcadores dos sensores
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
    c.style.cursor = "pointer";

    c.addEventListener("click", () => toggleSensor(s.id));

    grupoSensores.appendChild(c);
  });
}

criarSensores();


let trens = [
  {
    id: "trem",
    el: document.getElementById("trem"),
    posicao: 0,
    velocidadeAtual: 40,
    velocidadeAlvo: 150
  }
  /*
  -> Se quiser ativar o TREM 2 depois:
  {
    id: "trem2",
    el: document.getElementById("trem2"),
    posicao: caminhoTotal * 0.15,
    velocidadeAtual: 40,
    velocidadeAlvo: 150
  }
  */
];

let rodando = false;
let ultimoTempo = null;

// Alternar sensor
function toggleSensor(id) {
  const s = sensores.find(x => x.id === id);
  s.ativo = !s.ativo;

  const el = document.querySelector(`[data-id="${id}"]`);
  el.classList.toggle("sensor-on", s.ativo);
  el.classList.toggle("sensor-off", !s.ativo);
}

function getProxSensor(pos) {
  const pct = pos / caminhoTotal;

  for (let s of sensores) {
    if (s.pct > pct) return s;
  }
  return sensores[0];
}

function animar(time) {
  if (!rodando) return requestAnimationFrame(animar);

  if (ultimoTempo == null) ultimoTempo = time;
  const dt = (time - ultimoTempo) / 1000;
  ultimoTempo = time;

  trens.forEach(t => {
    const prox = getProxSensor(t.posicao);

    t.velocidadeAlvo = prox.ativo ? 40 : 150;
    t.velocidadeAtual += (t.velocidadeAlvo - t.velocidadeAtual) * 0.1;

    t.posicao += t.velocidadeAtual * dt;
    if (t.posicao >= caminhoTotal) t.posicao = 0;

    const p = trilho.getPointAtLength(t.posicao);
    t.el.setAttribute("x", p.x - 20);
    t.el.setAttribute("y", p.y - 20);
  });

  requestAnimationFrame(animar);
}

// Botões
document.getElementById("btnIniciar").onclick = () => {
  rodando = true;
  ultimoTempo = null;
};

document.getElementById("btnPausar").onclick = () => {
  rodando = false;
};

document.getElementById("btnReset").onclick = () => {
  rodando = false;

  trens.forEach(t => {
    t.posicao = 0;
    t.velocidadeAtual = 0;

    const p = trilho.getPointAtLength(0);
    t.el.setAttribute("x", p.x - 20);
    t.el.setAttribute("y", p.y - 20);
  });
};

// Iniciar loop
requestAnimationFrame(animar);
</script>

</body>
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
            <h2>Expresso Verde</h2>
          </div>
        </div>

        <!-- Icone do Trem-->
        <div class="tremInfoContainer">
          <img class="imagemTrem" src="../../assets/icons/trenzinho.png" alt="Trem circular">
        </div>

        <!-- Botão do maquinista para ele receber as infos deles -->
        <div class="infoComplementarTrem">
          <a href="telaInformacoesJosevaldo.php">
              <button class="boxMaquinistaInfo">
                <img src="../../assets/icons/maquinistas.png" alt="icone do motorista">
                <div>
                  <h4>Clodoaldo</h4>
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
