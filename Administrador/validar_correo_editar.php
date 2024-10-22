<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];
$id = $_REQUEST['id']; // Obtener el ID del empleado actual


$query = "SELECT * FROM empleados WHERE correo = '$correo' AND id != $id"; // Excluir el producto actual

$sql = $con->query($query);

if (mysqli_num_rows($sql) > 0) {
    echo "El correo $correo ya cuenta con un registro previo ";
} else {
    echo "disponible";
}