<?php
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$rol = $_REQUEST['rol'];
$encriptado = md5($pass);

// Inicialización de $archivo con el valor anterior
// Necesitarías buscar el valor actual antes de actualizar si el usuario no carga un nuevo archivo
$archivoAnteriorQuery = "SELECT archivo FROM empleados WHERE id = $id";
$resultado = $con->query($archivoAnteriorQuery);
if ($fila = $resultado->fetch_assoc()) {
    $archivo = $fila['archivo']; // Mantener el archivo anterior si no se sube uno nuevo
}

// Verificar si se subió un archivo y procesarlo
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
    $file_name = $_FILES['archivo']['name'];
    $file_tmp = $_FILES['archivo']['tmp_name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_enc = md5_file($file_tmp);
    $dir = "archivos/";
    $archivo = "$file_enc.$ext";
    copy($file_tmp, $dir.$archivo);
}

// Actualización de la base de datos
$sql = "UPDATE empleados 
        SET nombre = '$nombre', apellidos = '$apellidos', correo = '$correo', pass = '$encriptado', rol = $rol, archivo = '$archivo' 
        WHERE id = $id";
$res = $con->query($sql);

header("Location: empleados_lista.php");
?>
