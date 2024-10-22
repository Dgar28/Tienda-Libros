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
    .centrar {
            margin: 0 auto; /* Margen automático en los lados izquierdo y derecho */
            background-color: #AFEEEE;
            text-align: center;
            }
    
    .texto{
        background-color: #87CEEB;
        font-weight: bold;
        font-size: 16px;
        padding:10px;
    }      
    h1 {
        background-color: #4682B4; /* Color de fondo */
        color: #FFFFFF; /* Color del texto */
        text-align: center; /* Centra el texto */
        padding: 10px 0; /* Espacio por encima y por debajo del texto */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra sutil */
        margin-top: 20px; /*Margen superior*/ 
        font-size: 24px; /* Tamaño de la fuente más grande */
    }  
    .boton-mover {
            padding-left: 400px;
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
    <div class="fondo">
    <div class="boton-mover">
    <a href="promociones_lista.php">Volvera a la lista</a>
    </div>
<div class="centrar">
<?php
// empleados_detalle.php

// Obteniendo el ID del empleado desde el URL
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$query = "SELECT * FROM promociones WHERE id = $id";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status_activo = $row['eliminado'] == 0 ? 'Activa' : 'Inactivo';
    echo  "<h1>Detalles de la promocion</h1>";
    echo "<div class='texto'>" . $row['nombre'] . "</div>";
    echo "<div class='texto'>Promocion " . $status_activo . "</div>";
    echo "<div class='foto'><img src='banner/" . $row['archivo'] . "' style='width:600px; height:200px;'></div>";

} else {
    echo "Promocion no encontrada.";
}
?>

</div>
</div>
</body>
</html>