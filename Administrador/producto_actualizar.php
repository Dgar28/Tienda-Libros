<?php
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$codigo = $_REQUEST['codigo'];
$descripcion = $_REQUEST['descripcion'];
$costo = $_REQUEST['costo'];
$stock = $_REQUEST['stock'];

// Recuperamos el archivo actual si no se sube un nuevo archivo
$archivoAnteriorQuery = "SELECT archivo, archivo_n FROM productos WHERE id = $id";
$resultado = $con->query($archivoAnteriorQuery);
if ($fila = $resultado->fetch_assoc()) {
    $archivo = $fila['archivo'];
    $archivo_n = $fila['archivo_n'];
}

// Verificar si se subió un archivo y procesarlo
if (isset($_FILES['archivo_n']) && $_FILES['archivo_n']['error'] == UPLOAD_ERR_OK) {
    $file_name = $_FILES['archivo_n']['name'];
    $file_tmp = $_FILES['archivo_n']['tmp_name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_enc = md5_file($file_tmp);
    $dir = "productos/";
    $archivo_n = "$file_enc.$ext"; // Nuevo nombre de archivo
    $archivo = $file_name; // Original file name for human-readable purposes
    move_uploaded_file($file_tmp, $dir.$archivo_n);
}

// Actualización de la base de datos con la nueva información, incluyendo nuevos nombres de archivo si corresponde
$sql = "UPDATE productos SET nombre = '$nombre', codigo = '$codigo', descripcion = '$descripcion', costo = '$costo', stock = '$stock', archivo = '$archivo', archivo_n = '$archivo_n' WHERE id = $id";
$res = $con->query($sql);

header("Location: productos_lista.php");
?>

