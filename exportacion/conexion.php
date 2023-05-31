<?php
$host = "localhost";
$username = "muymucho_user";
$password = "XXT6O)GzzI0]";
$dbname = "muymucho_wp";

// Crear conexión
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>