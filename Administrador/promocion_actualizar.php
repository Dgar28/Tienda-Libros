<?php
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];

// Inicialización de $archivo con el valor anterior
// Necesitarías buscar el valor actual antes de actualizar si el usuario no carga un nuevo archivo
$archivoAnteriorQuery = "SELECT archivo FROM promociones WHERE id = $id";
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
    $dir = "banner/";
    $archivo = "$file_enc.$ext";
    copy($file_tmp, $dir.$archivo);
}

// Actualización de la base de datos
$sql = "UPDATE promociones 
        SET nombre = '$nombre', archivo = '$archivo' 
        WHERE id = $id";
$res = $con->query($sql);

header("Location: promociones_lista.php");
?>