<?php
session_start();
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");
$obj = new Conectar();
$conexion = $obj->getConexion();

function mostrarProductosMujer($conexion) {
    $query = "SELECT * FROM producto WHERE IdCategoria = 2";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $rutaBaseImagen = "../ImagenProductos/";

    while ($row = $result->fetch_assoc()) {
        $imagenRuta = $rutaBaseImagen . $row['ImagenProducto'];

        if (!file_exists($imagenRuta)) {
            $imagenRuta = "../ImagenProductos/default.png";
        }

        $nombreProducto = (strlen($row['Nombre']) > 25) ? substr($row['Nombre'], 0, 25) . '...' : $row['Nombre'];

        echo '<div class="col">
                <div class="card h-100 product-card">
                    <img src="' . $imagenRuta . '" class="card-img-top" alt="Imagen de ' . $row['Nombre'] . '">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title wbon">' . htmlspecialchars($nombreProducto) . '</h5>
                        <p class="precio">S/ ' . number_format($row['PrecioUnitario'], 2) . '</p>
                        <div class="mt-auto">
                            <a href="detalles_producto.php?id=' . $row['IdProducto'] . '" class="btn btn-primary w-100">Ver detalles</a>
                        </div>
                    </div>
                </div>
              </div>';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUJERES</title>
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
    background-color: #FFC1CC;
    }
    .navbar-custom {
    background-color: #FFC1CC;
    }

    body {
    background-color: #FFE4E9;
    }

    footer {
    background-color: #FFADBC;
    color: #000000;
    }
</style>
<body>
<?php include_once "navbar.php"; ?>

<div class="container mt-5">
    <h3 class="text-left my-2">MUJER</h3>
    <div class="row row-cols-2 row-cols-md-4 g-4 py-5">
        <?php mostrarProductosMujer($conexion); ?>
    </div>
</div>

<?php include_once "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
