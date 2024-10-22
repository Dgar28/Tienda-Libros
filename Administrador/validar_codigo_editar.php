<?php
require "funciones/conecta.php";
$con = conecta();
$codigo = $_REQUEST['codigo'];
$id = $_REQUEST['id']; // Obtener el ID del empleado actual


$query = "SELECT * FROM productos WHERE codigo = '$codigo' AND id != $id"; // Excluir el producto actual

$sql = $con->query($query);

if (mysqli_num_rows($sql) > 0) {
    echo "Codigo duplicado";
} else {
    echo "disponible";
}