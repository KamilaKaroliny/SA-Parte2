<?php
require_once "../../../config/conexao.php";

// Buscar meses disponíveis da tabela relatorios
$sql = "SELECT id, mes FROM relatorios ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Relatórios - Lista</title>
</head>
<body>

    <h1 class="titulo">Relatórios Mensais</h1>

    <table class="tabela">
        <thead>
            <tr>
                <th>Mês</th>
                <th>Visualizar</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['mes'] ?></td>

                    <td>
                        <a href="VIEWRelatorio.php?id=<?= $row['id'] ?>">
                            <img src="../../assets/info/icones/seta.png" 
                                 alt="Abrir" width="25">
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
