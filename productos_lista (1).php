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
        /*.fondo {
            width: 100%;
            height: 100%;
            background-color: #AFEEEE;
        }*/
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
    .foto {
        display:flex;
        width: 150px;
        height: 140px;
        margin: 0 auto; /* Centramos horizontalmente la foto */
        /*margin-bottom: 20px; /* Margen inferior para separar la foto del texto */

    }
    </style>
    <script src="ajax2.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
        
    </script>
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
    <a href="registro_productos.php" style="color:black;">Registrar producto</a>
    <?php
    //empleados_lista.php
    /*require "funciones/conecta.php";
    $con = conecta();*/
    $query = "SELECT * FROM productos 
              WHERE status = 1 AND eliminado = 0";
    $sql = $con->query($query);
    $num = $sql->num_rows;
    //echo "Lista de empleados <br><br>";
    echo "<table style='width: 960px; border-collapse: collapse; text-align:center'>";
    echo "<tr><td colspan='8' style='background-color: #4682B4;'><h1>Productos ($num)</h1></td></tr>";
    echo "<tr style='background-color: #AFEEEE;'><th>Nombre</th><th>Codigo</th><th>Descripcion</th><th>Costo</th><th>Stock</th><th></th><th></th></tr>";
    while ($row = $sql->fetch_array()) {
        $id = $row["id"];
        $nombre = $row["nombre"];
        $codigo = $row["codigo"];
        $descripcion = $row["descripcion"];
        $costo = $row["costo"];
        $stock = $row["stock"];
        $archivo_n = $row['archivo_n'];
        //echo "<a href=\"empleados_eliminar.php?id=$id\">Eliminar</a> <br>";
        
            echo "<tr id='fila_$id'>";
            echo "<td style='background-color: #87CEEB; padding: 5px;'>$nombre</td>";
            echo "<td style='background-color: #87CEEB;'>$codigo</td>";
            echo "<td style='background-color: #87CEEB;'>$descripcion</td>";
            echo "<td style='background-color: #87CEEB;'>$costo</td>";
            echo "<td style='background-color: #87CEEB;'>$stock</td>";
            echo "<td style='background-color: #87CEEB;'><a href=\"producto_detalles.php?id=$id\"> Detalles </a></td>";
            echo "<td style='background-color: #87CEEB;'><a href=\"producto_editar.php?id=$id\"> Editar </a></td>";
            //echo "<td style='background-color: #AFEEEE;'><a href=\"empleados_eliminar.php?id=$id\"> Eliminar </a></td>";
            echo "<td style='background-color: #87CEEB;'><a href='javascript:void(0);' onclick='confirmEliminar($id); actualizaEstilos($id);'>Eliminar</a></td>";




            echo "</tr>";
    }
    echo "</table>"
    ?>
    </div>
</div>
</body>
</html>
