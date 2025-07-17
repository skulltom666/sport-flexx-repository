<?php
// busqueda.php
session_start();
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");

$mensaje = '';
$resultados = [];
if (isset($_GET['q'])) {
    $q = trim($_GET['q']);
    if ($q !== '') {
        $obj = new Conectar();
        $conexion = $obj->getConexion();
        // Búsqueda por nombre o descripción (ajustar según tu modelo de datos)
        $sql = "SELECT * FROM producto WHERE Nombre LIKE CONCAT('%', ?, '%') OR Descripcion LIKE CONCAT('%', ?, '%') LIMIT 20";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $q, $q);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        $stmt->close();
        $conexion->close();
        if (empty($resultados)) {
            $mensaje = 'No se encontraron productos.';
        }
    } else {
        $mensaje = 'Ingrese un término de búsqueda.';
    }
} else {
    $mensaje = 'Realiza una búsqueda.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda</title>
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
<style>
    .offcanvas-body {
    background-color:rgb(175, 206, 229);
    }
    .navbar-custom {    
    background-color: rgb(175, 206, 229);
    }

    body {
    background-color: #e3f2fd;
    }

    footer {
    background-color:rgb(175, 206, 229);
    color: #000000;
    }
</style>
<body>
<?php include_once "navbar.php"; ?>
<div class="container mt-4">
    <h3>Resultados de búsqueda</h3>
    <form class="mb-4" method="get" action="busqueda.php">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Buscar productos..." value="<?= htmlspecialchars(isset($_GET['q']) ? $_GET['q'] : '') ?>" autofocus required>
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <?php if ($mensaje): ?>
        <div class="alert alert-info"> <?= htmlspecialchars($mensaje) ?> </div>
    <?php endif; ?>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach ($resultados as $producto): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="../ImagenProductos/<?= htmlspecialchars($producto['ImagenProducto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['Nombre']) ?>">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title"> <?= htmlspecialchars($producto['Nombre']) ?> </h5>
                        <p class="card-text"> <?= htmlspecialchars($producto['Descripcion']) ?> </p>
                        <p class="precio">S/ <?= number_format($producto['PrecioUnitario'], 2) ?></p>
                        <a href="detalles_producto.php?id=<?= $producto['IdProducto'] ?>" class="btn btn-primary w-100 mt-auto">Ver detalles</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include_once "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
