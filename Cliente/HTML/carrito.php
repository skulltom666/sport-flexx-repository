<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Mensajes
$mensaje = '';
$tipoMensaje = '';

// Cambiar cantidad
if (isset($_POST['accion']) && $_POST['accion'] === 'cambiar_cantidad') {
    $index = (int)$_POST['index'];
    $nuevaCantidad = (int)$_POST['cantidad'];
    if ($nuevaCantidad < 1) {
        $mensaje = 'La cantidad mínima es 1.';
        $tipoMensaje = 'danger';
    } elseif (isset($_SESSION['carrito'][$index])) {
        $_SESSION['carrito'][$index]['cantidad'] = $nuevaCantidad;
        $mensaje = 'Cantidad actualizada.';
        $tipoMensaje = 'success';
    }
}

// Agregar producto desde POST
if (isset($_POST['accion']) && $_POST['accion'] === 'agregar_producto') {
    $producto = [
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        'precio' => (float)$_POST['precio'],
        'imagen' => $_POST['imagen'],
        'cantidad' => 1
    ];
    $existe = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['titulo'] === $producto['titulo']) {
            $item['cantidad']++;
            $existe = true;
            break;
        }
    }
    if (!$existe) {
        $_SESSION['carrito'][] = $producto;
    }
    $mensaje = 'Producto agregado al carrito.';
    $tipoMensaje = 'success';
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $index = (int)$_GET['eliminar'];
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
        $mensaje = 'Producto eliminado.';
        $tipoMensaje = 'success';
    }
}

// Vaciar carrito
if (isset($_GET['vaciar'])) {
    $_SESSION['carrito'] = [];
    $mensaje = 'Carrito vaciado.';
    $tipoMensaje = 'success';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../EstilosMenus/EstilosMenu.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js" />
</head>
<body>
<?php include_once 'navbar.php'; ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto"><h2>Carrito de Compras <span class="badge bg-primary"><?= count($_SESSION['carrito']) ?></span></h2></div>
        <div class="col-auto">
            <?php if (!empty($_SESSION['carrito'])): ?>
                <a href="carrito.php?vaciar=1" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que deseas vaciar el carrito?')"><i class="bi bi-trash"></i> Vaciar carrito</a>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <?php if ($mensaje): ?>
        <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($mensaje) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="text-center p-5">
            <i class="bi bi-cart-x display-1 text-secondary"></i>
            <h4 class="mt-3">Tu carrito está vacío.</h4>
            <a href="MenuPrincipalCliente.php" class="btn btn-primary mt-3"><i class="bi bi-arrow-left"></i> Seguir comprando</a>
        </div>
    <?php else: ?>
        <?php
        $subtotal = 0;
        foreach ($_SESSION['carrito'] as $index => $item):
            $totalItem = $item['precio'] * $item['cantidad'];
            $subtotal += $totalItem;
        ?>
        <div class="card mb-4 shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-3 text-center">
                    <img src="<?= htmlspecialchars($item['imagen']) ?>" class="img-fluid rounded-3 p-2" style="max-height:140px;object-fit:contain;" alt="<?= htmlspecialchars($item['titulo']) ?>">
                </div>
                <div class="col-md-5">
                    <div class="card-body">
                        <h5 class="card-title mb-2"><?= htmlspecialchars($item['titulo']) ?></h5>
                        <p class="card-text small text-muted mb-2"><?= htmlspecialchars($item['descripcion']) ?></p>
                        <p class="card-text mb-1"><span class="fw-bold">Precio:</span> S/<?= number_format($item['precio'], 2) ?></p>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <form method="post" class="d-inline-flex align-items-center" style="gap:5px;">
                        <input type="hidden" name="accion" value="cambiar_cantidad">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" name="cantidad" value="<?= $item['cantidad']-1 ?>" class="btn btn-outline-secondary btn-sm" <?= $item['cantidad']<=1 ? 'disabled' : '' ?>><i class="bi bi-dash"></i></button>
                        <input type="text" name="cantidad" value="<?= $item['cantidad'] ?>" class="form-control form-control-sm text-center" style="width:50px;display:inline-block;" min="1" pattern="\d+" readonly>
                        <button type="submit" name="cantidad" value="<?= $item['cantidad']+1 ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-plus"></i></button>
                    </form>
                </div>
                <div class="col-md-2 text-center">
                    <div class="d-grid gap-2">
                        <span class="badge bg-info text-dark mb-2">Total: S/<?= number_format($totalItem, 2) ?></span>
                        <a href="carrito.php?eliminar=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto del carrito?')"><i class="bi bi-trash"></i> Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="row justify-content-end">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3">Resumen de compra</h5>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>S/<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Envío:</span>
                        <span>S/10.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total:</span>
                        <span>S/<?= number_format($subtotal + 10, 2) ?></span>
                    </div>
                    <div class="d-grid mt-4">
                        <form action="pago_nativo.php" method="post" class="d-grid mt-4">
    <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-credit-card"></i> Proceder al pago</button>
</form>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php include_once 'footer.php'; ?>
</body>
</html>
