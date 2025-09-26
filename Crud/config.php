<?php
$host = "localhost";
$user = "root"; // seu usuário MySQL
$pass = "";     // sua senha MySQL
$db   = "crud_mundo";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
