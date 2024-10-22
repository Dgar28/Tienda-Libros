<?php
session_start();
    require "funciones/conecta.php";
    $con = conecta();
    if (isset($_SESSION['id_empleado'])) {
        $id_empleado = $_SESSION['id_empleado'];
        $query = "SELECT * FROM empleados WHERE id = $id_empleado";
        $sql = $con->query($query);

        if (mysqli_num_rows($sql) > 0) {
            $row_empleado = mysqli_fetch_assoc($sql); // Datos del usuario logueado
        }
        } else {
        header('Location: index.php'); // Redirige al usuario si no está autenticado
        exit();
    }
?>
<html>
<head>
<style>
    body{
        background-color: #AFEEEE;
        font-family: Arial, sans-serif;
    }
        .encabezado {
            width: 100%;
            height: 50px;
            background-color: #87CEEB;
            display: flex;
            align-items: center; /* Centra verticalmente */
            justify-content: space-between; /* Espacio entre elementos */
             /* Añade un poco de espacio alrededor del contenido */
        }
        .linea_encabezado {
            width: 100%;
            height: 10px;
            background-color:#4682B4;

        }
        .fondo {
            background-color: #AFEEEE;
            width: 100%;
            height:100%;
        }
        .centrar {
            margin: 0 auto; /* Margen automático en los lados izquierdo y derecho */
            background-color: #AFEEEE;
            width: 960px;
        }
        h1 {
        background-color: #4682B4; /* Color de fondo */
        color: #FFFFFF; /* Color del texto */
        text-align: center; /* Centra el texto */
        padding: 10px 0; /* Espacio por encima y por debajo del texto */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra sutil */
        margin-top: 20px; /* Margen superior */
        font-size: 24px; /* Tamaño de la fuente más grande */
    }
    </style>
    <script src="ajax1.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="encabezado">
        <h1> BIENVENID@ <?php echo $row_empleado['nombre']; ?> </h1>
        <a href="bienvenido.php" style="color:black;">Inicio</a>
        <a href="empleados_lista.php" style="color:black;">Empleados</a> 
        <a href="productos_lista.php" style="color:black;">Productos</a> 
        <a href="promociones_lista.php" style="color:black;">Promociones</a> 
        <a href="pedidos.php" style="color:black;">Pedidos</a> 
        <a href="cerrar_sesion.php" style="color:black;">Cerrar sesion</a>
    </div>
    <div class="linea_encabezado"></div>
<div class="fondo">
    <div class="centrar">
    <a href="registro.php" style="color:black;">Registrar empleado</a>
    <?php
    //empleados_lista.php
    /*require "funciones/conecta.php";
    $con = conecta();*/
    $query = "SELECT * FROM empleados 
              WHERE status = 1 AND eliminar = 0";
    $sql = $con->query($query);
    $num = $sql->num_rows;
    //echo "Lista de empleados <br><br>";
    echo "<table style='width: 960px; border-collapse: collapse; text-align:center'>";
    echo "<tr><td colspan='7' style='background-color: #4682B4;'><h1>Lista de empleados ($num)</h1></td></tr>";
    echo "<tr style='background-color: #AFEEEE;'><th>Nombre</th><th>Apellidos</th><th>Correo</th><th>Rol</th><th></th><th></th><th></th><th></th></tr>";
    while ($row = $sql->fetch_array()) {
        $id = $row["id"];
        $nombre = $row["nombre"];
        $apellidos = $row["apellidos"];
        $correo = $row["correo"];
        $rol = $row["rol"];
        //echo "<a href=\"empleados_eliminar.php?id=$id\">Eliminar</a> <br>";

            $rol_texto = '';
            switch ($rol) {
             case '1':
                $rol_texto = 'Gerente';
                break;
            case '2':
                $rol_texto = 'Ejecutivo';
            break;
            }
        
            echo "<tr id='fila_$id'>";
            echo "<td style='background-color: #87CEEB;'>$nombre</td>";
            echo "<td style='background-color: #87CEEB;'>$apellidos</td>";
            echo "<td style='background-color: #87CEEB;'>$correo</td>";
            echo "<td style='background-color: #87CEEB;'>$rol_texto</td>";
            echo "<td style='background-color: #AFEEEE;'><a href=\"empleado_detalle.php?id=$id\"> Detalles </a></td>";
            echo "<td style='background-color: #AFEEEE;'><a href=\"empleado_editar.php?id=$id\"> Editar </a></td>";
            //echo "<td style='background-color: #AFEEEE;'><a href=\"empleados_eliminar.php?id=$id\"> Eliminar </a></td>";
            echo "<td style='background-color: #AFEEEE;'><a href='javascript:void(0);' onclick='confirmEliminar($id); actualizaEstilos();'>Eliminar</a></td>";




            echo "</tr>";
    }
    echo "</table>"
    ?>
    </div>
</div>
</body>
</html>
