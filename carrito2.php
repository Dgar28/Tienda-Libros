<!-- carrito.php -->
<?php
require "Administrador/funciones/conecta.php";
$con = conecta();

$id_pedido = $_REQUEST['id_pedido'];
$sql_pedido = "SELECT pp.id_producto, pp.cant, pp.costo, p.nombre, p.costo AS costo_unitario
               FROM pedidos_productos pp
               JOIN productos p ON pp.id_producto = p.id
               WHERE pp.id_pedido = '$id_pedido'";
$result_pedido = $con->query($sql_pedido);

$gran_total = 0;

echo "<h2>Carrito de compras</h2>";
echo "<table border='1'>
<tr>
    <th>Nombre del producto</th>
    <th>Cantidad</th>
    <th>Costo unitario</th>
    <th>Costo total</th>
    <th>Eliminar</th>
</tr>";

while ($row = $result_pedido->fetch_assoc()) {
    $nombre = $row['nombre'];
    $cantidad = $row['cant'];
    $costo_unitario = $row['costo_unitario'];
    $costo_total = $row['costo'];
    $id_producto = $row['id_producto'];

    echo "<tr>
    <td>$nombre</td>
    <td>$cantidad</td>
    <td>$$costo_unitario</td>
    <td>$$costo_total</td>
    <td><a href='eliminar_producto.php?id_producto=$id_producto&id_pedido=$id_pedido'>Eliminar</a></td>
    </tr>";

    $gran_total += $costo_total;
}

echo "</table>";
echo "<h3>Gran Total: $$gran_total</h3>";

echo "<form action='aceptar_pedido.php' method='post'>
    <input type='hidden' name='id_pedido' value='$id_pedido'>
    <input type='hidden' name='gran_total' value='$gran_total'>
    <button type='submit'>Aceptar Pedido</button>
</form>";
?>