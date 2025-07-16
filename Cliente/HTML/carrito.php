<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto desde POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    header("Location: carrito.php");
    exit();
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $index = $_GET['eliminar'];
    unset($_SESSION['carrito'][$index]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
    header("Location: carrito.php");
    exit();
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

<div class="container mt-5">
    <h2>Carrito de Compras</h2>
    <Br>
    <?php if (empty($_SESSION['carrito'])): ?>
        <p>Tu carrito está vacío.</p>
    <?php else: ?>
        <?php
        $subtotal = 0;
        foreach ($_SESSION['carrito'] as $index => $item):
            $totalItem = $item['precio'] * $item['cantidad'];
            $subtotal += $totalItem;
        ?>
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($item['imagen']) ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($item['titulo']) ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($item['titulo']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($item['descripcion']) ?></p>
                        <p class="card-text">Precio: S/<?= number_format($item['precio'], 2) ?></p>
                        <p class="card-text">Cantidad: <?= $item['cantidad'] ?></p>
                        <a href="carrito.php?eliminar=<?= $index ?>" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <h4>Subtotal: S/<?= number_format($subtotal, 2) ?></h4>
        <h5>Envío: S/10.00</h5>
        <h4>Total: S/<?= number_format($subtotal + 10, 2) ?></h4>
        <Br><Br>
    <?php endif; ?>
</div>

<?php include_once 'footer.php'; ?>
</body>
</html>
