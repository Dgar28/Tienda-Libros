<?php
// Conectarse a la base de datos
require "Administrador/funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST["correo"];

$query = "SELECT * FROM clientes WHERE correo = '$correo'";
$sql = $con->query($query);

if (mysqli_num_rows($sql) > 0) {
    echo "El correo $correo ya esta registrado";
} else {
    echo "disponible";
}
?>