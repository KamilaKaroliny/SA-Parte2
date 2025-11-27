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

// PEGAR ID DO TREM E DO RELATÓRIO
$trem_id       = isset($_GET['id_trem']) ? (int)$_GET['id_trem'] : 0;
$id_relatorio  = isset($_GET['id_relatorio']) ? (int)$_GET['id_relatorio'] : 0;

if ($id_relatorio <= 0 || $trem_id <= 0) {
    die("ID do trem ou relatório não informado.");
}

// BUSCAR TREM
$sql_trem = "SELECT nome, imagem FROM trem WHERE id = ?";
$stmt_trem = $mysqli->prepare($sql_trem);
$stmt_trem->bind_param("i", $trem_id);
$stmt_trem->execute();
$result_trem = $stmt_trem->get_result();

if ($result_trem->num_rows == 0) {
    die("Trem não encontrado.");
}

$trem = $result_trem->fetch_assoc();
$nome_trem = $trem['nome'];
$imagem_trem = $trem['imagem'] ?: 'default.jpg';

// DELETAR RELATÓRIO
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $mysqli->prepare("DELETE FROM relatorios_trens WHERE id = ?");
    $stmt->bind_param("i", $id_relatorio);
    
    if ($stmt->execute()) {
        $msg = "<div class='notif success'>Relatório deletado com sucesso!</div>";
    } else {
        $msg = "<div class='notif error'>Erro ao deletar relatório.</div>";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Relatório - <?php echo strtoupper($nome_trem); ?></title>
    <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>

<div class="rel-form-container">
    <div class="rel-perfil">
        <h2><?php echo strtoupper($nome_trem); ?></h2>
        <h3>Deseja realmente deletar este relatório?</h3>
    </div>

    <?php if (!empty($msg)) echo $msg; ?>

    <div class="actions">
        <form method="POST" style="display:inline;">
            <button type="submit" class="btn-confirm">Sim, deletar</button>
        </form>
        <a href="READRelatorioTrens.php?id=<?php echo $trem_id; ?>" class="btn-cancel">Cancelar</a>
    </div>
</div>

</body>
</html>