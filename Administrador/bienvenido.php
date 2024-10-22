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
        .fondo{ 
            width: 100%;
            height: 100%;
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
        .borde1{
            height: 100%;
            width: 120px;
            background-color:black;
            position: absolute; /* Posiciona el borde 1 de forma absoluta */
            left: 7px; /* Alinea el borde 1 a la izquierda del contenedor */
            
        }
        .borde2{
            height: 100%;
            width: 120px;
            background-color:black;
            position: absolute; /* Posiciona el borde 2 de forma absoluta */
            right: 7px; /* Alinea el borde 2 a la derecha del contenedor */
            
        }
    </style>

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
    <div class="borde1"></div>
    <div class="borde2"></div>

</body>
</html>