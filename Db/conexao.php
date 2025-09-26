<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tremalize_db";

$conn =  mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexao falhou: " . $conn->connect_error);
}

?>