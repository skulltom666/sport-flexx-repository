<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPedido = $_POST["IdPedido"];
    $idCliente = $_POST["IdCliente"];
    $numeroPedido = $_POST["NumeroPedido"];
    $estado = $_POST["Estado"];
    $fechaPedido = $_POST["FechaPedido"];
    $fechaEntrega = $_POST["FechaEntrega"];
    $idCuponDescuento = isset($_POST["IdCuponDescuento"]) ? $_POST["IdCuponDescuento"] : null;

    $obj = new Conectar();
    $conn = $obj->getConexion();
    $conn->begin_transaction();

    try {
        // Actualizar el pedido
        $sql = "UPDATE pedido SET IdCliente = ?, NumeroPedido = ?, Estado = ?, FechaPedido = ?, FechaEntrega = ?, IdCuponDescuento = ? WHERE IdPedido = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssii", $idCliente, $numeroPedido, $estado, $fechaPedido, $fechaEntrega, $idCuponDescuento, $idPedido);
        $stmt->execute();

        // Borrar detalles existentes
        $sqlDeleteDetalles = "DELETE FROM detallepedido WHERE IdPedido = ?";
        $stmtDeleteDetalles = $conn->prepare($sqlDeleteDetalles);
        $stmtDeleteDetalles->bind_param("i", $idPedido);
        $stmtDeleteDetalles->execute();

        // Insertar nuevos detalles del pedido
        $productos = $_POST['IdProducto'];
        $cantidades = $_POST['Cantidad'];
        $costosUnitarios = $_POST['PrecioUnitario'];
        $descuentos = $_POST['Descuento'];

        for ($i = 0; $i < count($productos); $i++) {
            $idProducto = $productos[$i];
            $cantidad = $cantidades[$i];
            $costoUnitario = $costosUnitarios[$i];
            $descuento = isset($descuentos[$i]) ? $descuentos[$i] : 0;

            // Obtener descuento del cupon
            $descuentoCupon = 0;
            if ($idCuponDescuento) {
                $sqlCupon = "SELECT DescuentoPorcentaje FROM cupondescuento WHERE IdCuponDescuento = ?";
                $stmtCupon = $conn->prepare($sqlCupon);
                $stmtCupon->bind_param("i", $idCuponDescuento);
                $stmtCupon->execute();
                $stmtCupon->bind_result($descuentoCupon);
                $stmtCupon->fetch();
                $stmtCupon->close();
            }

            $descuentoTotal = $descuento + ($costoUnitario * $descuentoCupon);

            $sqlDetalle = "INSERT INTO detallepedido (IdPedido, IdProducto, Cantidad, PrecioUnitario, Descuento) VALUES (?, ?, ?, ?, ?)";
            $stmtDetalle = $conn->prepare($sqlDetalle);
            $stmtDetalle->bind_param("iiidi", $idPedido, $idProducto, $cantidad, $costoUnitario, $descuentoTotal);
            $stmtDetalle->execute();
        }

        $conn->commit();
        header("Location: Pedido.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
