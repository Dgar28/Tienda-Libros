<?php
$archivo = $_FILES['archivo']['name']; //Nombre real del archivo
$file_tmp  = $_FILES['archivo']['tmp_name'];//Nombre temporal del archivo
$arreglo   = explode(".", $archivo);//Separa el nombre para obtener
$len       = count($arreglo);//Cuenta los elementos del archivos
$pos       = $len - 1;//Saca la posicion
$ext       = $arreglo[$pos];//Extension
$dir       = "archivos/";//Carpeta donde se guardan los archivos
$archivo_n  = md5_file($file_tmp);//Nombre del archivo encriptado

echo "archivo: $archivo <br>";
echo "file_tmp: $file_tmp <br>";
echo "ext: $ext <br>";
echo "archivo_n: $archivo_n <br>";

if ($archivo !=''){
    $archivo1 = "$archivo_n.$ext";
    copy($file_tmp, $dir.$archivo1);
}