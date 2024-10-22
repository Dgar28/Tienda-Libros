<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass']; 
$encriptado = md5($pass);
$query = "SELECT * FROM empleados
          WHERE status = 1 AND eliminar = 0
          AND correo ='$correo'AND pass ='$encriptado' ";
$res = $con->query($query);
$num = $res->num_rows;

if ($num > 0) {
    $row = $res->fetch_assoc(); // Obtener la fila del resultado
    session_start();
    $_SESSION['id_empleado'] = $row['id']; // Guardar el ID del usuario en la sesión
    $_SESSION['nombre_empleado'] = $row['nombre']; // Guardar el nombre del usuario en la sesión
    echo "Usuario encontrado";
} else {
    echo "Contraseña o correo incorrectos";
}

?>