<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "comunidades";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Não foi possível conectar ao banco de dados: " . mysqli_connect_error());
}

?>
