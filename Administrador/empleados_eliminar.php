<?php
//empleados_elimina.php
require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST["id"];
$ban = 0;

//$query = "DELETE FROM empleados WHERE id = $id";
$query = "UPDATE empleados SET eliminar = 1 WHERE id = $id";

$sql = $con->query($query);

if ($sql) {
    $ban = 1;
}
echo $ban;

header("Location: empleados_lista.php");
?>