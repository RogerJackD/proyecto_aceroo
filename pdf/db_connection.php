<?php
$servername = "localhost";
$username = "root";
$password = "mysql114114";
$dbname = "prueeba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
