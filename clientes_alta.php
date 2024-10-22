<html>
    <head>
    </head>
    <body>
    <?php
        require "Administrador/funciones/conecta.php";
        $con = conecta();
            $nombre = $_REQUEST["nombre"];
            $apellidos = $_REQUEST["apellidos"];
            $correo = $_REQUEST["correo"];
            $pass = $_REQUEST["pass"];
            $encriptado = md5($pass);
            $pregunta = $_REQUEST["pregunta"];
            $encriptadopreg = md5($pregunta);
            

        $sql = "INSERT INTO clientes (nombre, apellidos, correo, pass, pregunta)
                VALUES ('$nombre','$apellidos', '$correo', '$encriptado', '$encriptadopreg')";
        if($con->query($sql)===true){
            echo "Registro exitoso";
        }
        else{
            echo "Error al realizar el registro";
        }
        header('Location: index.php');
    
    ?>
    </body>
    </html>
