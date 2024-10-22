<?php
require "Administrador/funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass']; 
$encriptado = md5($pass);
$pregunta = $_REQUEST["pregunta"];
$encriptadopreg = md5($pregunta);
            
$query = "SELECT * FROM clientes
          WHERE status = 1 
          AND correo ='$correo'AND pass ='$encriptado' AND pregunta ='$encriptadopreg' ";
$res = $con->query($query);
$num = $res->num_rows;

if ($num > 0) {
    $row = $res->fetch_assoc(); // Obtener la fila del resultado
    session_start();
    $_SESSION['id_cliente'] = $row['id']; // Guardar el ID del usuario en la sesión
    $_SESSION['nombre_cliente'] = $row['nombre']; // Guardar el nombre del usuario en la sesión
    echo "Usuario encontrado";
} else {
    echo "Contraseña o correo incorrectos ";
    echo $pregunta;
}

?>