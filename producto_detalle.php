<?php
session_start();
    require "Administrador/funciones/conecta.php";
    $con = conecta();
    if (isset($_SESSION['id_cliente'])) {
        $id_cliente = $_SESSION['id_cliente'];
        $query = "SELECT * FROM clientes WHERE id = $id_cliente";
        $sql = $con->query($query);

        if (mysqli_num_rows($sql) > 0) {
            $row_cliente = mysqli_fetch_assoc($sql); // Datos del usuario logueado
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
        background-color: cadetblue;
    }
    .encabezado {
            width: 100%;
            height: 60px;
            background-color: #87CEEB;
            display: flex;
            align-items: center; /* Centra verticalmente */
            justify-content: space-between; /* Espacio entre elementos */
            padding-right: 10px;
    }
    .linea_encabezado {
            width: 100%;
            height: 10px;
            background-color:#4682B4;

    }
    .encabezado a {
            color: black;
            padding: 10px;
            text-decoration: none;
        }
        .encabezado a:hover, .encabezado a.active {
            background-color:white;
            border-radius: 5px;
        }
    .texto {
        font-size: 16px;
        padding: 10px;
        margin-bottom: 10px; /* Espacio entre cada bloque de texto */
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
    .foto{
        width: 100px;
        height: 100px;
    }
    .fila{
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3); /* Sombra */
    margin: 20px auto; /* Centramos la fila */
    max-width: 800px; /* Ancho máximo */

    }
    .bloque {
    flex: 1;
    padding: 20px;
    }

    .bloque img {
    width: 250px;
    height: 300px;
    border-radius: 8px;
    margin-top: -90px;
    margin-left: 20px;
    }
        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
            margin-top: 20px;
        }

        footer a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
        
</style>
</head>
<body>
    <?php
$query_carrito_count = "SELECT COUNT(*) as num_productos FROM pedidos_productos pp JOIN pedidos ped ON pp.id_pedido = ped.id WHERE ped.status = 0";
$result_carrito_count = $con->query($query_carrito_count);
$row_carrito_count = $result_carrito_count->fetch_assoc();
$num_filas = $row_carrito_count['num_productos'];
?>
<div class="encabezado">
    <img src="RABE.jpeg" style=" height:60px; width: 90px;">
    <a href="home.php" style="color:black;">Home</a>
    <a href="productos_lista.php" style="color:black;"class="active" >Productos</a>
    <a href="contacto.php" style="color:black;">Contacto</a> 
    <a href="carrito.php" style="color:black;" >Carrito <?php echo $num_filas; ?></a>
    <a href="cerrar_sesion.php" style="color:black;">Cerrar sesion</a>
</div>
    <div class="linea_encabezado"></div>
<?php
// empleados_detalle.php

// Obteniendo el ID del empleado desde el URL
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$query = "SELECT * FROM productos WHERE id = $id";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>Detalles del Producto</h1>";
    echo "<div class='fila'>";
    echo "<div class='bloque'>";
    echo "<div class='texto'>Nombre: " . $row['nombre'] . "</div>"; 
    echo "<div class='texto'>Codigo: " . $row['codigo'] . "</div>";
    echo "<div class='texto'>Descripcion: " . $row['descripcion'] . "</div>";
    echo "<div class='texto'>Precio: $" . $row['costo'] . "</div>";
    echo "<div class='texto'>Existentes " . $row['stock'] . "</div>";
    echo "<form action='agregar_pedido.php' method='post'>"; //formulario de pedido
        echo "<input type='hidden' name='id_producto' value='" . $row['id'] . "'>";
        echo "<input type='hidden' name='nombre' value='" . $row['nombre'] . "'>";
        echo "<input type='hidden' name='costo' value='" . $row['costo'] . "'>";
        echo "<label for='cantidad'> Agregar al carrito:</label>";
        echo "<input type='number' id='cantidad' name='cantidad' min='1' max='" . $row['stock'] . "' required>";
        echo "<button type='submit'>Aceptar</button>";
        echo "</form>";
    echo "</div>";
    echo "<div class='bloque'>";
    echo "<div class='foto'><img src='Administrador/productos/" . $row['archivo_n'] . "'></div>";
    echo "</div>";
    echo "</div>";
    
    $query_similares = "SELECT * FROM productos 
    WHERE id != $id AND status = 1 AND eliminado = 0 ORDER BY RAND() LIMIT 3";
    $result_similares = $con->query($query_similares);

    if ($result_similares->num_rows > 0) {
        echo "<h2>Recomendaciones</h2>";
        echo "<div class='fila' style='justify-content: space-between;'>"; // Nuevo estilo para el contenedor
        while ($row_similar = $result_similares->fetch_assoc()) {
            echo "<div class='bloque'>";
            echo "<a href='producto_detalle.php?id=" . $row_similar['id'] . "'>";
            echo "<div class='foto'><img src='Administrador/productos/" . $row_similar['archivo_n'] . "' style='width: 150px; height: 150px; padding-top: 80px'></div>";
            echo "</a>";
            echo "<div class='texto' style='padding-top: 50px;'>Nombre: " . $row_similar['nombre'] . "</div>"; 
            echo "<div class='texto'>Precio: $" . $row_similar['costo'] . "</div>";
            echo "<form action='agregar_pedido.php' method='post'>"; //formulario de pedido
                echo "<input type='hidden' name='id_producto' value='" . $row_similar['id'] . "'>";
                echo "<input type='hidden' name='nombre' value='" . $row_similar['nombre'] . "'>";
                echo "<input type='hidden' name='costo' value='" . $row_similar['costo'] . "'>";
                echo "<label for='cantidad'> Agregar al carrito:</label>";
                echo "<input type='number' id='cantidad' name='cantidad' min='1' max='" . $row['stock'] . "' required>";
                echo "<button type='submit'>Aceptar</button>";
        echo "</form>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "No hay productos similares disponibles.";
    }

} else {
    echo "Producto no encontrado.";
}
?>
<a href="productos_lista.php"style="left: 20px;"><button>Volver</button></a>
</div>
</div>
<br>
    <footer>
        <p>&copy; 2024 Derechos Reservados</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="https://facebook.com" target="_blank">Facebook</a>
        <a href="https://twitter.com" target="_blank">Twitter</a>
        <a href="https://instagram.com" target="_blank">Instagram</a>
    </footer>

</body>
</html>