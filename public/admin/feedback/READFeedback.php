<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <script src="../../scripts/validaLogin.js"></script>
    <script src="../../scripts/validaCadastro.js"></script>
    <script src="../../scripts/validaEsqueceusenha.js"></script>
    <script src="../../scripts/validaEsqueceusenha2.js"></script>
    <script src="../../scripts/graficoRelatorioM.js"></script>
    <title>Feedback</title>
</head>
<body>
    <!-- Parte de cima do feedback (seta, casa e logo tremalize -->
    <div id="flex4">
        <div class="meio1">
            <a href="paginaInicial.php">
                <img id="seta" src="../../assets/icons/seta.png" alt="seta">
            </a>
        </div>

        <div class="meio1">
            <img id="logo4" src="../../assets/icons/logoTremalize.png" alt="logo">
        </div>

        <div class="meio2">
            <a href="paginaInicial.php">
                <img id="casa1" src="../../assets/icons/casa.png" alt="casa">
            </a>
        </div>
    </div>

    <!-- Título: "Feedback" -->
    <div>
        <H2> FEEDBACK </H2>   
    </div>

  <br>

    <!-- Todos os feedbacks das pessoas (nome da pessoa, quantidade de estrelas e a mensagem) --> 
    <main>
      <div class="branca">
        <div id="flex9">
            <H4>Jackson Oliveira</H4>
            <img class= "estrelas"src="../../assets/icons/estrelas.png" alt="Quantidade de Estrelas">
        </div>
        <p>"Experiência incrível! O trem era muito confortável,
            os assentos eram espaçosos e a viagem foi super
            tranquila. Além disso, a pontualidade foi impecável.
            Com certeza viajarei novamente!"</p>
      </div>
      <div class="branca">
        <div id="flex9">
            <H4>Otávio Ferreira </H4>
            <img class="estrelas" src="../../assets/icons/estrelas.png" alt="Quantidade de Estrelas">
        </div>
        <p>"Ótimo serviço! A equipe de bordo foi muito
            atenciosa, e o vagão-restaurante tinha boas opções
            de comida. Só acho que poderia ter mais tomadas
            para carregar o celular, mas no geral, foi uma
            viagem excelente!"</p>
      </div>
      </div>
      <div class="branca">
        <div id="flex9">
            <H4>Jaqueline Elisabeth</H4>
            <img class="estrelas" src="../../assets/icons/estrelas.png" alt="Quantidade de Estrelas">
        </div>
        <p>"Viagem perfeita! O trem era silencioso e muito
            limpo. Gostei bastante da paisagem ao longo do
            trajeto. Cheguei ao destino no horário certo e sem
            estresse. Super recomendo!"</p>

      </div>
      <div class="branca">
        <div id="flex9">
            <H4>Rodrigo Medeiros</H4>
            <img  class= "estrelas" src="../../assets/icons/estrelas.png" alt="Quantidade de Estrelas">
            
        </div>
        <p>"Gostei muito da experiência! O ar-condicionado
            estava na temperatura ideal, e os assentos eram
            confortáveis. A única coisa que poderia melhorar é
            o Wi-Fi, que às vezes falhava. Fora isso, tudo
            excelente!"</p>
      </div>
    </main>
   
</body>
</html>



<?php
include("../../../db/conexao.php"); 

// =============================
// PEGAR ID DO TREM
// =============================
$id_trem = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_trem <= 0) {
    die("ID do trem não informado.");
}

// =============================
// BUSCAR TREM
// =============================
$sql_trem = "SELECT nome, tipo FROM trem WHERE id = ?";
$stmt_trem = $mysqli->prepare($sql_trem);
$stmt_trem->bind_param("i", $id_trem);
$stmt_trem->execute();
$result_trem = $stmt_trem->get_result();

if ($result_trem->num_rows == 0) {
    die("Trem não encontrado.");
}

$trem = $result_trem->fetch_assoc();
$nome = $trem['nome'];
$tipo = $trem['tipo'];

// =============================
// ANOS DISPONÍVEIS
// =============================
$sql_anos = "SELECT DISTINCT ano FROM relatorios_trens WHERE id_trem = ? ORDER BY ano DESC";
$stmt_anos = $mysqli->prepare($sql_anos);
$stmt_anos->bind_param("i", $id_trem);
$stmt_anos->execute();
$result_anos = $stmt_anos->get_result();

$anos = [];
while ($i = $result_anos->fetch_assoc()) {
    $anos[] = $i['ano'];
}

$anoSelecionado = isset($_GET['ano']) ? (int)$_GET['ano'] : ($anos[0] ?? null);

// =============================
// PAGINAÇÃO DOS MESES (5 POR PÁGINA)
// =============================
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$porPagina = 12;
$offset = ($pagina - 1) * $porPagina;

// =============================
// BUSCAR MESES DO ANO SELECIONADO
// =============================
$sql_meses = "SELECT id, mes FROM relatorios_trens WHERE id_trem = ? AND ano = ? ORDER BY mes ASC LIMIT ? OFFSET ?";
$stmt_meses = $mysqli->prepare($sql_meses);
$stmt_meses->bind_param("iiii", $id_trem, $anoSelecionado, $porPagina, $offset);
$stmt_meses->execute();
$result_meses = $stmt_meses->get_result();

function nomeMes($m) {
    $nomes = [
        1=>"Janeiro", 2=>"Fevereiro", 3=>"Março", 4=>"Abril",
        5=>"Maio", 6=>"Junho", 7=>"Julho", 8=>"Agosto",
        9=>"Setembro", 10=>"Outubro", 11=>"Novembro", 12=>"Dezembro"
    ];
    return $nomes[$m] ?? "Mês ?";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios do Trem</title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

    <!-- cabeçalho -->
    <div id="cabecalhoEditar">
        <div class="meio7">
            <a href="../trens/telaCircular.php">
                <img id="setaEditar" src="../../../assets/icons/seta.png" alt="seta">
            </a>
        </div>
        <div class="meio7">
            <img id="logoEditar" src="../../../assets/icons/logoTremalize.png" alt="logo">
        </div>
        <div class="meio6">
            <a href="../paginaInicial.php">
                <img id="casaEditar" src="../../../assets/icons/casa.png" alt="casa">
            </a>
        </div>
    </div>

    <main>

        <!-- Nome do trem -->
        <div class="perfil">
            <h3 class="perfil-nome"><?php echo strtoupper($nome); ?> (<?php echo $tipo; ?>)</h3>
            <hr class="divisor">
        </div>

        <!-- Seleção de ano -->
        <div class="ano-box">
            <form method="GET">
                <input type="hidden" name="id" value="<?php echo $id_trem; ?>">
                <select name="ano" class="select-ano">
                    <?php foreach ($anos as $a): ?>
                        <option value="<?php echo $a; ?>" <?php echo ($a == $anoSelecionado) ? 'selected' : ''; ?>>
                            <?php echo $a; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-filtrar" type="submit">Filtrar</button>
            </form>
        </div>

        <!-- Lista de meses -->
        <div class="lista">
            <?php if ($result_meses->num_rows == 0): ?>
                <p class="sem-registros">Nenhum relatório encontrado neste ano.</p>
            <?php else: ?>
                <?php while ($m = $result_meses->fetch_assoc()): ?>
                    <div class="cartao">
                        <strong><?php echo nomeMes($m['mes']); ?></strong>

                        <div class="icones">
                            <!-- EDITAR -->
                            <a href="EDITRelatorioTrens.php?id_trem=<?php echo $id_trem; ?>&id_relatorio=<?php echo $m['id']; ?>">
                                <img class="ic" src="../../../assets/icons/editarMaquinistas.png">
                            </a>

                            <!-- DELETAR -->
                            <a href="DELETERelatorioTrens.php?id_trem=<?php echo $id_trem; ?>&id_relatorio=<?php echo $m['id']; ?>">
                            <img class="ic" src="../../../assets/icons/lixeira.png">
                            </a>

                            <!-- INFORMAÇÕES -->
                            <a href="READRelatorioDosTrens.php?id=<?php echo $id_trem; ?>&ano=<?php echo $anoSelecionado; ?>&mes=<?php echo $m['mes']; ?>">
                                <img class="ic" src="../../../assets/icons/setinha.png">
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- Botão novo relatório -->
        <div id="addButton">
            <a href="ADDRelatorioTrens.php?id=<?php echo $id_trem; ?>">
                <img src="../../../assets/icons/add.png">
            </a>
        </div>

    </main>
</body>
</html>