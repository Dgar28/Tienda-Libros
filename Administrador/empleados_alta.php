<?php
$file_name = $_FILES['archivo']['name']; //Nombre real del archivo
$file_tmp  = $_FILES['archivo']['tmp_name'];//Nombre temporal del archivo
$arreglo   = explode(".", $file_name);//Separa el nombre para obtener
$len       = count($arreglo);//Cuenta los elementos del archivos
$pos       = $len - 1;//Saca la posicion
$ext       = $arreglo[$pos];//Extension
$dir       = "archivos/";//Carpeta donde se guardan los archivos
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
            $apellidos = $_REQUEST["apellidos"];
            $correo = $_REQUEST["correo"];
            $rol = $_REQUEST["rol"];
            $pass = $_REQUEST["pass"];
            $encriptado = md5($pass);
            $archivo = $fileName1;
            

        $sql = "INSERT INTO empleados (nombre, apellidos, correo, rol, pass, archivo)
                VALUES ('$nombre','$apellidos', '$correo', $rol, '$encriptado', '$archivo')";
        if($con->query($sql)===true){
            echo "Registro exitoso";
        }
        else{
            echo "Error al realizar el registro";
        }
        header('Location: empleados_lista.php');
    
    ?>
    </body>
    </html>