<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idVenta = isset($_POST["IdVenta"]) ? $_POST["IdVenta"] : 0;
    $idPedido = $_POST["IdPedido"];
    $idTipoPago = $_POST["IdTipoPago"];
    $fechaVenta = $_POST["FechaVenta"];
    $igv = $_POST["IGV"];

    $obj = new Conectar();
    $conn = $obj->getConexion();

    // Obtener detalles del pedido
    $sqlDetalles = "SELECT SUM(Cantidad * PrecioUnitario) AS subtotal, SUM(Descuento) AS descuento FROM detallepedido WHERE IdPedido = ?";
    $stmtDetalles = $conn->prepare($sqlDetalles);
    $stmtDetalles->bind_param("i", $idPedido);
    $stmtDetalles->execute();
    $stmtDetalles->bind_result($subtotal, $descuento);
    $stmtDetalles->fetch();
    $stmtDetalles->close();

    // Calcular el total con IGV
    $total = ($subtotal - $descuento) * (1 + ($igv / 100));

    if ($idVenta > 0) {
        // Actualizar la venta existente
        $sql = "UPDATE venta SET IdPedido = ?, IdTipoPago = ?, FechaVenta = ?, IGV = ?, Descuento = ?, Total = ? WHERE IdVenta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissddi", $idPedido, $idTipoPago, $fechaVenta, $igv, $descuento, $total, $idVenta);
    } else {
        // Crear una nueva venta
        $sql = "INSERT INTO venta (IdPedido, IdTipoPago, FechaVenta, IGV, Descuento, Total) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissdd", $idPedido, $idTipoPago, $fechaVenta, $igv, $descuento, $total);
    }

    if ($stmt->execute()) {
        header("Location: Ventas.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
