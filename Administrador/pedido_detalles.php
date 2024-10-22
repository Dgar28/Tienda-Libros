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
    body {
        font-family: Arial, sans-serif;
        background-color: #E0F7FA;
        margin: 0;
        padding: 0;
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
        padding-left: 50px;
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
 

    .container {
        max-width: 500px;
        margin: 30px auto;
        background-color: #FFFFFF;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .container h2, .container h3 {
        text-align: center;
        color: #00838F;
    }

    .producto {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .producto p {
        margin: 5px 0;
    }

    .volver {
        text-align: center;
        margin-top: 20px;
    }

    .volver a {
        color: #00838F;
        text-decoration: none;
        font-size: 16px;
    }

    .volver a:hover {
        text-decoration: underline;
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
    <div class="contenido">
    <?php
// Verifica si se proporcionó un ID de pedido válido
$id_pedido = isset($_GET['id']) ? $_GET['id'] : null; 

// Si no se proporcionó un ID de pedido válido, muestra un mensaje de error
if ($id_pedido === null) {
    echo "<p>ID de pedido no válido.</p>";
    exit;
}



// Consulta para seleccionar los detalles del pedido del cliente
$query = "SELECT pp.id_producto, pp.costo, pp.cant, p.nombre AS nombre_producto
          FROM pedidos_productos pp
          INNER JOIN productos p ON pp.id_producto = p.id
          WHERE pp.id_pedido = $id_pedido";
$result = $con->query($query);

$costo_total = 0;

// Si se encontraron resultados, muestra los detalles del pedido
if ($result->num_rows > 0) {
    echo "<h2>Detalles del Pedido</h2>";
    while ($row = $result->fetch_assoc()) {
        $costo_unitario = $row['costo'] / $row['cant'];
        echo "<div class='producto'>";
        echo "<p>Producto: " . $row['nombre_producto'] . "</p>";
        echo "<p>Cantidad: " . $row['cant'] . "</p>";
        echo "<p>Precio Original: $" . number_format($costo_unitario, 2) . "</p>";
        echo "<p>Precio Total: $" . $row['costo'] . "</p>";
        echo "</div>";
        // Sumar el costo del producto al costo total
        $costo_total += $row['costo'];
    }
    // Mostrar el costo total del pedido
    echo "<h3>Costo Total del Pedido: $" . number_format($costo_total, 2) . "</h3>";
} else {
    // Si no se encontraron resultados, muestra un mensaje indicando que no hay detalles disponibles
    echo "<p>No se encontraron detalles para este pedido.</p>";
}

// Cierra la conexión a la base de datos
$con->close();
?>
<div class="volver">
    <a href="pedidos.php">Volver a la lista de pedidos</a>
</div>
</body>
</html>