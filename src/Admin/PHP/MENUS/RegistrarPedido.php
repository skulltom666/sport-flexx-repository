<?php
require_once(__DIR__ . "/../coneccion/conector.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPedido = isset($_POST["IdPedido"]) ? $_POST["IdPedido"] : 0;
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
        $sqlCheckCliente = "SELECT COUNT(*) FROM cliente WHERE IdCliente = ?";
        $stmtCheckCliente = $conn->prepare($sqlCheckCliente);
        $stmtCheckCliente->bind_param("i", $idCliente);
        $stmtCheckCliente->execute();
        $stmtCheckCliente->bind_result($clienteExiste);
        $stmtCheckCliente->fetch();
        $stmtCheckCliente->close();

        if ($clienteExiste == 0) {
            throw new Exception("El cliente con ID $idCliente no existe.");
        }

        if ($idPedido > 0) {
            $sql = "UPDATE pedido SET IdCliente = ?, NumeroPedido = ?, Estado = ?, FechaPedido = ?, FechaEntrega = ?, IdCuponDescuento = ? WHERE IdPedido = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssii", $idCliente, $numeroPedido, $estado, $fechaPedido, $fechaEntrega, $idCuponDescuento, $idPedido);
        } else {
            $sql = "INSERT INTO pedido (IdCliente, NumeroPedido, Estado, FechaPedido, FechaEntrega, IdCuponDescuento) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssi", $idCliente, $numeroPedido, $estado, $fechaPedido, $fechaEntrega, $idCuponDescuento);
        }

        if ($stmt->execute()) {
            if ($idPedido == 0) {
                $idPedido = $stmt->insert_id;
            }

            if ($idPedido > 0) {
                $sqlDeleteDetalles = "DELETE FROM detallepedido WHERE IdPedido = ?";
                $stmtDeleteDetalles = $conn->prepare($sqlDeleteDetalles);
                $stmtDeleteDetalles->bind_param("i", $idPedido);
                $stmtDeleteDetalles->execute();
            }

            if (isset($_POST['IdProducto']) && isset($_POST['Cantidad']) && isset($_POST['PrecioUnitario']) && isset($_POST['Descuento'])) {
                $productos = $_POST['IdProducto'];
                $cantidades = $_POST['Cantidad'];
                $costosUnitarios = $_POST['PrecioUnitario'];
                $descuentos = $_POST['Descuento'];

                if (is_array($productos) && is_array($cantidades) && is_array($costosUnitarios) && is_array($descuentos)) {
                    for ($i = 0; $i < count($productos); $i++) {
                        $idProducto = $productos[$i];
                        $cantidad = $cantidades[$i];
                        $costoUnitario = $costosUnitarios[$i];
                        $descuento = isset($descuentos[$i]) ? $descuentos[$i] : 0;

                        $sqlCheckProducto = "SELECT COUNT(*) FROM producto WHERE IdProducto = ?";
                        $stmtCheckProducto = $conn->prepare($sqlCheckProducto);
                        $stmtCheckProducto->bind_param("i", $idProducto);
                        $stmtCheckProducto->execute();
                        $stmtCheckProducto->bind_result($productoExiste);
                        $stmtCheckProducto->fetch();
                        $stmtCheckProducto->close();

                        if ($productoExiste > 0) {
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
                            if (!$stmtDetalle->execute()) {
                                throw new Exception("Error al insertar detalle del pedido: " . $stmtDetalle->error);
                            }
                        } 
                    }
                }
            }

            $conn->commit();
            header("Location: Pedido.php");
            exit();
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>