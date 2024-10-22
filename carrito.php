<?php
session_start();
require "Administrador/funciones/conecta.php";
$con = conecta();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: index.php'); // Redirige al usuario si no está autenticado
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
?>
<html>
<head>
<style>
    body {
        background-color: cadetblue;
    }
    .encabezado {
        width: 100%;
        height: 60px;
        background-color: #87CEEB;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-right: 10px;
    }
    .linea_encabezado {
        width: 100%;
        height: 10px;
        background-color: #4682B4;
    }
    .encabezado a {
        color: black;
        padding: 10px;
        text-decoration: none;
    }
    .encabezado a:hover, .encabezado a.active {
        background-color: white;
        border-radius: 5px;
    }
    .texto {
        font-size: 16px;
        padding: 10px;
        margin-bottom: 10px;
    }
    h1 {
        background-color: #4682B4;
        color: #FFFFFF;
        text-align: center;
        padding: 10px 0;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-top: 20px;
        font-size: 24px;
    }
    .foto {
        width: 100px;
        height: 100px;
    }
    .fila {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        margin: 20px auto;
        max-width: 800px;
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
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    table th {
        background-color: #4682B4;
        color: white;
    }
    table tr:hover {
        background-color: #f5f5f5;
    }
    table .total-row {
        font-weight: bold;
        background-color: #f0f0f0;
    }
    footer {
        background-color: black;
        color: white;
        text-align: center;
        padding: 20px 0;
        width: 100%;
        margin-top: 400px;
    }
    footer a {
        color: white;
        margin: 0 10px;
        text-decoration: none;
    }
    footer a:hover {
        text-decoration: underline;
    }
    .btn-eliminar {
        background-color: #FF6347;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-eliminar:hover {
        background-color: #FF4500;
    }
    .mensaje{
        font-size: 40px;
        text-align: center;
        color:black;
    }
</style>

</head>
<body>
<?php
// Consulta para obtener el número de productos en el carrito
$query_carrito_count = "SELECT COUNT(*) as num_productos FROM pedidos_productos pp JOIN pedidos ped ON pp.id_pedido = ped.id WHERE ped.status = 0";
$result_carrito_count = $con->query($query_carrito_count);
$row_carrito_count = $result_carrito_count->fetch_assoc();
$num_filas = $row_carrito_count['num_productos'];
?>

<div class="encabezado">
<img src="RABE.jpeg" style="height:60px; width:90px;">
<a href="home.php" style="color:black;">Home</a>
<a href="productos_lista.php" style="color:black;">Productos</a>
<a href="contacto.php" style="color:black;">Contacto</a>
<a href="carrito.php" style="color:black;" class="active">Carrito <?php echo $num_filas; ?></a>
<a href="cerrar_sesion.php" style="color:black;">Cerrar sesión</a>
</div>
<div class="linea_encabezado"></div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {
$id_pedido = $_POST['id_pedido'];
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];

// Eliminar el producto del carrito
$sql_delete = "DELETE FROM pedidos_productos WHERE id = '$id_pedido'";
if ($con->query($sql_delete) === true) {
// Actualizar el stock del producto
$sql_update_stock = "UPDATE productos SET stock = stock + $cantidad WHERE id = '$id_producto'";
if ($con->query($sql_update_stock) === true) {
$num_filas--;
echo "<script>console.log('Producto eliminado del carrito y stock actualizado');</script>"; 
} else {
echo "<script>console.log('Error al actualizar el stock: " . $con->error . "');</script>";
}
} else {
echo "<script>console.log('Error al eliminar el producto del carrito: " . $con->error . "');</script>";
}
}

echo "<h1>Carrito de Compras</h1>";
$query_carrito = "SELECT pp.id as pedido_id, p.id as producto_id, p.nombre, pp.cant, pp.costo 
                  FROM pedidos_productos pp 
                  JOIN productos p ON pp.id_producto = p.id 
                  JOIN pedidos ped ON pp.id_pedido = ped.id
                  WHERE ped.status = 0";
$result_carrito = $con->query($query_carrito);

if ($result_carrito->num_rows > 0) {
echo "<table>";
echo "<tr><th>Producto</th><th>Cantidad</th><th>Costo</th><th>Acciones</th></tr>";
$total_cant = 0;
$total_costo = 0;
$id_pedido = null;
while ($row_carrito = $result_carrito->fetch_assoc()) {
$total_cant += $row_carrito['cant'];
$total_costo += $row_carrito['costo'];
$id_pedido = $row_carrito['pedido_id'];
echo "<tr>";
echo "<td>" . $row_carrito['nombre'] . "</td>";
echo "<td>" . $row_carrito['cant'] . "</td>";
echo "<td>$" . $row_carrito['costo'] . "</td>";
echo "<td>
<form method='post' action='' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\");'>
  <input type='hidden' name='id_pedido' value='" . $row_carrito['pedido_id'] . "'>
  <input type='hidden' name='id_producto' value='" . $row_carrito['producto_id'] . "'>
  <input type='hidden' name='cantidad' value='" . $row_carrito['cant'] . "'>
  <button type='submit' name='eliminar' class='btn-eliminar'>Eliminar</button>
</form>
</td>";
echo "</tr>";
}
echo "<tr class='total-row'><td colspan='3'>Total</td><td>$" . $total_costo . "</td></tr>";
echo "</table>";
echo "<form method='post' action='cerrar_pedido.php'>
<input type='hidden' name='id_pedido' value='" . $id_pedido . "'>
<input type='hidden' name='total_cant' value='$total_cant'>
<input type='hidden' name='total_costo' value='$total_costo'>
<button type='submit' name='aceptar' onclick='ocultarFilasPedidoFinalizado(); return confirm(\"¿Confirmas aceptar el pedido?\");'>Aceptar Pedido</button>
</form>";
} else {
echo "<p class='mensaje'>¡No hay productos en el carrito!</p>";
}
    ?>

    <footer>
        <p>&copy; 2024 Derechos Reservados</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="https://facebook.com" target="_blank">Facebook</a>
        <a href="https://twitter.com" target="_blank">Twitter</a>
        <a href="https://instagram.com" target="_blank">Instagram</a>
    </footer>
</body>
</html>