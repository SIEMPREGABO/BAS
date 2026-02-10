<?php
$servername = "localhost";
$username = "u699741583_BeautyAndSoul";
$password = "7TSh!7h25:UJUVj";
$dbname = "u699741583_BeautyAndSoul";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>