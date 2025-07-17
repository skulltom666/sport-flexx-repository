<?php
session_start();

// Simulación de procesamiento de pago nativo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $tarjeta = trim($_POST['tarjeta'] ?? '');
    $exp = trim($_POST['exp'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    $errores = [];
    if (strlen($nombre) < 3) {
        $errores[] = 'Nombre inválido.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Correo electrónico inválido.';
    }
    if (!preg_match('/^\d{16,19}$/', $tarjeta)) {
        $errores[] = 'Número de tarjeta inválido.';
    }
    if (!preg_match('/^\d{2}\/\d{2}$/', $exp)) {
        $errores[] = 'Fecha de vencimiento inválida.';
    }
    if (!preg_match('/^\d{3,4}$/', $cvv)) {
        $errores[] = 'CVV inválido.';
    }

    // Simulación: Si no hay errores, registrar venta y "pago exitoso"; si hay, error
    if (empty($errores)) {
        // --- REGISTRO DE VENTA EN BASE DE DATOS ---
        $carrito = $_SESSION['carrito'] ?? [];
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        $total = $subtotal + 10; // Envío fijo
        $fecha = date('Y-m-d H:i:s');

        $conexion = new mysqli('localhost', 'root', '', 'sportflexx');
        if ($conexion->connect_error) {
            // Si falla la conexión, igual vacía el carrito y muestra éxito (no recomendado en producción)
            unset($_SESSION['carrito']);
            header('Location: pago_exitoso.php');
            exit();
        }

        // Insertar venta
        $stmtVenta = $conexion->prepare("INSERT INTO ventas (fecha, total, nombre_cliente, email_cliente) VALUES (?, ?, ?, ?)");
        $stmtVenta->bind_param('sdss', $fecha, $total, $nombre, $email);
        $stmtVenta->execute();
        $idVenta = $stmtVenta->insert_id;
        $stmtVenta->close();

        // Insertar detalles
        $stmtDetalle = $conexion->prepare("INSERT INTO detalle_ventas (id_venta, producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
        foreach ($carrito as $item) {
            $producto = $item['titulo'];
            $cantidad = $item['cantidad'];
            $precio_unitario = $item['precio'];
            $subtotal_item = $precio_unitario * $cantidad;
            $stmtDetalle->bind_param('isidd', $idVenta, $producto, $cantidad, $precio_unitario, $subtotal_item);
            $stmtDetalle->execute();
        }
        // Detalle para el envío
        $envio = 'Envío';
        $envio_cant = 1;
        $envio_precio = 10.00;
        $envio_sub = 10.00;
        $stmtDetalle->bind_param('isidd', $idVenta, $envio, $envio_cant, $envio_precio, $envio_sub);
        $stmtDetalle->execute();
        $stmtDetalle->close();
        $conexion->close();

        // Vaciar carrito
        unset($_SESSION['carrito']);
        header('Location: pago_exitoso.php');
        exit();
    } else {
        $_SESSION['pago_nativo_errores'] = $errores;
        header('Location: carrito.php#pagoNativoModal');
        exit();
    }
} else {
    header('Location: carrito.php');
    exit();
}
