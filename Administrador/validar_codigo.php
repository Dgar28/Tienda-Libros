<?php
// Conectarse a la base de datos
require "funciones/conecta.php";
$con = conecta();
$codigo = $_GET["codigo"];

$query = "SELECT * FROM productos WHERE codigo = '$codigo'";
$sql = $con->query($query);

if (mysqli_num_rows($sql) > 0) {
    echo "Codigo duplicado";
} else {
    echo "disponible";
}
?>