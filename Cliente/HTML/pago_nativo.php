<?php
session_start();
// Obtener resumen del carrito
$carrito = $_SESSION['carrito'] ?? [];
$subtotal = 0;
foreach ($carrito as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}
$total = $subtotal + 10; // Envío fijo
// Mostrar errores si existen
$errores = $_SESSION['pago_nativo_errores'] ?? [];
unset($_SESSION['pago_nativo_errores']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagar pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<body class="bg-light">
<?php include_once "navbar.php"; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0"><i class="bi bi-credit-card"></i> Pago con Tarjeta</h4>
                </div>
                <div class="card-body">
                    <?php if ($errores): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errores as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_pago_nativo.php" method="post" autocomplete="off">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre en la tarjeta</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required maxlength="80">
                        </div>
                        <div class="mb-3">
                            <label for="tarjeta" class="form-label">Número de tarjeta</label>
                            <input type="text" class="form-control" id="tarjeta" name="tarjeta" required maxlength="19" pattern="\d{16,19}">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="exp" class="form-label">Vencimiento</label>
                                <input type="text" class="form-control" id="exp" name="exp" required placeholder="MM/AA" pattern="\d{2}/\d{2}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="password" class="form-control" id="cvv" name="cvv" required maxlength="4" pattern="\d{3,4}">
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total a pagar:</span>
                            <span class="fw-bold">S/<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Pagar ahora</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="carrito.php" class="btn btn-link">&laquo; Volver al carrito</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
