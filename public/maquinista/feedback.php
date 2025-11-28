<?php
session_start();
include("../../db/conexao.php");

if (!isset($_SESSION['email'])) {
    die("Acesso negado. Faça login.");
}

$emailLogado = $_SESSION['email'];
$ehAdmin = str_ends_with($emailLogado, "@administrador.com");


$sql = "SELECT id, nome, foto_perfil, feedback 
        FROM usuarios 
        WHERE feedback IS NOT NULL AND feedback <> ''";

$result = $mysqli->query($sql);


if (!$result) {
    die("Erro ao buscar feedbacks: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="stylesheet" href="../../style/style.css">

   
</head>
<body>

<!-- Topo -->
<div id="flex4">
    <div class="meio1">
        <a href="paginaInicial.php">
            <img id="seta" src="../../assets/icons/seta.png">
        </a>
    </div>
    <div class="meio1">
        <img id="logo4" src="../../assets/icons/logoTremalize.png">
    </div>
    <div class="meio2">
        <a href="paginaInicial.php">
            <img id="casa1" src="../../assets/icons/casa.png">
        </a>
    </div>
</div>

<h2>FEEDBACK</h2>
<br>

<main>

<?php if ($result->num_rows > 0): ?>
    
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="branca">
            <div id="flex9">
                <h4><?= htmlspecialchars($row['nome']) ?></h4>
                <img class="estrelas" src="../../assets/icons/estrelas.png" alt="Estrelas">
            </div>

            <p><?= htmlspecialchars($row['feedback']) ?></p>

            <?php if ($ehAdmin): ?>
                 <form method="POST" action="deleteFeedback.php"
                      onsubmit="return confirm('Tem certeza que deseja excluir este feedback?')">
                    
                    <input type="hidden" name="id_usuario" value="<?= $row['id'] ?>">
                    <button class="btn-delete" type="submit">Excluir Feedback</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

<?php else: ?>

    <p>Nenhum feedback encontrado.</p>

<?php endif; ?>

</main>

</body>
</html>
