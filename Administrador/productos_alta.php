<?php
$file_name = $_FILES['archivo']['name']; //Nombre real del archivo
$file_tmp  = $_FILES['archivo']['tmp_name'];//Nombre temporal del archivo
$arreglo   = explode(".", $file_name);//Separa el nombre para obtener
$len       = count($arreglo);//Cuenta los elementos del archivos
$pos       = $len - 1;//Saca la posicion
$ext       = $arreglo[$pos];//Extension
$dir       = "productos/";//Carpeta donde se guardan los archivos
$file_enc  = md5_file($file_tmp);//Nombre del archivo encriptado

if ($file_name !=''){
    $fileName1 = "$file_enc.$ext";
    copy($file_tmp, $dir.$fileName1);
}
?>  
    <html>
    <head>
        <script src="js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
    <?php
        require "funciones/conecta.php";
        $con = conecta();
            $nombre = $_REQUEST["nombre"];
            $codigo = $_REQUEST["codigo"];
            $descripcion = $_REQUEST["descripcion"];
            $costo = $_REQUEST["costo"];
            $stock = $_REQUEST["stock"];
            $archivo_n = $fileName1;
            $archivo = $file_name;
            

        $sql = "INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo, archivo_n)
                VALUES ('$nombre',$codigo, '$descripcion', $costo, $stock, '$archivo', '$archivo_n')";
        if($con->query($sql)===true){
            echo "Registro exitoso";
        }
        else{
            echo "Error al realizar el registro";
        }
        header('Location: productos_lista.php');
    
    ?>
    </body>
    </html>
