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
    .foto {
        display:flex;
        width: 150px;
        height: 140px;
        margin: 0 auto; /* Centramos horizontalmente la foto */
        margin-bottom: 20px; /* Margen inferior para separar la foto del texto */

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
<div class="centrar">
<?php
// empleados_detalle.php

// Obteniendo el ID del empleado desde el URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = "SELECT * FROM empleados WHERE id = $id";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status_activo = $row['eliminar'] == 0 ? 'Activo' : 'Inactivo';
    echo "<h1>Detalles del Empleado</h1>";
    echo "<div class='texto'>Nombre: " . $row['nombre'] . "</div>";
    echo "<div class='texto'>Apellidos: " . $row['apellidos'] . "</div>";
    echo "<div class='texto'>Correo: " . $row['correo'] . "</div>";
    echo "<div class='texto'>Status: " . $status_activo . "</div>";


    $rol_texto = '';
    switch ($row['rol']) {
        case '1':
            $rol_texto = 'Gerente';
            break;
        case '2':
            $rol_texto = 'Ejecutivo';
            break;
    }
    echo "<div class='texto'>Rol: " . $rol_texto . "</div>";
    echo "<div class='foto'><img src='archivos/" . $row['archivo'] . "'></div>";

} else {
    echo "Empleado no encontrado.";
}
?>
<a href="empleados_lista.php">Volver a la lista</a>
</div>
</body>
</html>
