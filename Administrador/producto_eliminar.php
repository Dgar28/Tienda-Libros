<?php
//empleados_elimina.php
require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST["id"];
$ban = 0;

//$query = "DELETE FROM empleados WHERE id = $id";
$query = "UPDATE productos SET eliminado = 1, status = 0 WHERE id = $id";

$sql = $con->query($query);

if ($sql) {
    $ban = 1;
}
echo $ban;

header("Location: productos_lista.php");
?>