<?php
session_start();

$conexion = new mysqli('localhost', 'root', '', 'sportflexx');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$producto = null;
$variantes = [];

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    $sql = "SELECT p.Nombre, p.Descripcion, p.PrecioUnitario, p.ImagenProducto, p.IdCategoria 
            FROM producto p 
            WHERE p.IdProducto = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $producto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();

        if ($producto['IdCategoria'] != 3) {
            $sql_variantes = "SELECT Talla, Stock 
                              FROM producto_variantes 
                              WHERE IdProducto = ? 
                              ORDER BY 
                              CASE 
                                  WHEN Talla = 'S' THEN 1
                                  WHEN Talla = 'M' THEN 2
                                  WHEN Talla = 'L' THEN 3
                                  WHEN Talla = 'XL' THEN 4
                                  ELSE 5
                              END";
            $stmt_variantes = $conexion->prepare($sql_variantes);
            $stmt_variantes->bind_param('i', $producto_id);
            $stmt_variantes->execute();
            $resultado_variantes = $stmt_variantes->get_result();

            while ($row = $resultado_variantes->fetch_assoc()) {
                $variantes[] = $row;
            }
        }
    } else {
        echo "No se encontró el producto.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalles del Producto</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../EstilosMenus/EstilosMenu.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js" />

  <style>
    body {
        font-family: Arial, sans-serif;
    }
    .navbar-custom{
        background-color: orange;
    }
    footer{
        background-color: orange;
    }
    .container {
        margin-top: 50px;
        margin-bottom: 50px;
    }
    .product-img {
        max-width: 100%;
        border-radius: 10px;
    }
    .product-details h3 {
        font-size: 24px;
        font-weight: bold;
    }
    .product-details p {
        font-size: 16px;
    }
    .price {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }
    .tallas input[type="radio"] {
        display: none;
    }
    .tallas label {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }
    .tallas input[type="radio"]:checked + label {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }
    .btn-primary {
        background-color: #000;
        border-color: #000;
    }
    .guarantee {
        margin-top: 15px;
    }
    .shipping {
        margin-top: 10px;
    }
    .accordion-item {
        margin-top: 10px;
    }
  </style>
</head>
<body>

<?php include_once "navbar.php"; ?>

        <div class="container">

        <div class="row">
            <div class="col-md-6">
            <?php if ($producto): ?>
                <img src="http://localhost/SPORTFLEXX/Cliente/ImagenProductos/<?php echo $producto['ImagenProducto']; ?>" 
                    class="img-fluid product-img" 
                    alt="<?php echo htmlspecialchars($producto['Nombre']); ?>" 
                    style="width: 450px; max-height: 100%; object-fit: cover; border-radius: 10px;">
            <?php else: ?>
                <p>No hay imagen disponible</p>
            <?php endif; ?>
        </div>
        
        <div class="col-md-6 product-details">
            <?php if ($producto): ?>
                <h3><?php echo htmlspecialchars($producto['Nombre']); ?></h3>
                <p class="price">S/ <?php echo number_format($producto['PrecioUnitario'], 2); ?></p>

                <?php if (!empty($variantes)): ?>
                    <div class="tallas mb-3">
                        <h5>TALLA</h5>
                        <?php foreach ($variantes as $variante): ?>
                            <input type="radio" name="talla" id="talla-<?php echo htmlspecialchars($variante['Talla']); ?>" value="<?php echo htmlspecialchars($variante['Talla']); ?>" required>
                            <label for="talla-<?php echo htmlspecialchars($variante['Talla']); ?>"><?php echo htmlspecialchars($variante['Talla']); ?></label>
                        <?php endforeach; ?>
                    </div>

                    <h5>STOCK</h5>
                    <p id="stock-info">Seleccione una talla para ver el stock</p>

                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#sizeGuideModal">
                        Ver guía de tallas
                    </button>

                    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sizeGuideModalLabel">Guía de Tallas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Guía de Tallas para Camisetas</h6>
                                <table class="table table-bordered mb-4">
                                    <thead>
                                        <tr>
                                            <th>Talla</th>
                                            <th>Medida del Pecho (cm)</th>
                                            <th>Medida de la Cintura (cm)</th>
                                            <th>Medida de Cadera (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>S</td>
                                            <td>86-90</td>
                                            <td>66-70</td>
                                            <td>92-96</td>
                                        </tr>
                                        <tr>
                                            <td>M</td>
                                            <td>90-94</td>
                                            <td>70-74</td>
                                            <td>96-100</td>
                                        </tr>
                                        <tr>
                                            <td>L</td>
                                            <td>94-98</td>
                                            <td>74-78</td>
                                            <td>100-104</td>
                                        </tr>
                                        <tr>
                                            <td>XL</td>
                                            <td>98-102</td>
                                            <td>78-82</td>
                                            <td>104-108</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h6>Guía de Tallas para Shorts y Pantalones</h6>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Talla</th>
                                            <th>Medida de la Cintura (cm)</th>
                                            <th>Medida de Cadera (cm)</th>
                                            <th>Largo de Pierna (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>S</td>
                                            <td>66-70</td>
                                            <td>92-96</td>
                                            <td>70</td>
                                        </tr>
                                        <tr>
                                            <td>M</td>
                                            <td>70-74</td>
                                            <td>96-100</td>
                                            <td>72</td>
                                        </tr>
                                        <tr>
                                            <td>L</td>
                                            <td>74-78</td>
                                            <td>100-104</td>
                                            <td>74</td>
                                        </tr>
                                        <tr>
                                            <td>XL</td>
                                            <td>78-82</td>
                                            <td>104-108</td>
                                            <td>76</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php else: ?>
                    <h5>STOCK</h5>
                    <p id="stock-info">
                        <?php
                        $sql_stock = "SELECT SUM(Stock) as StockTotal FROM producto_variantes WHERE IdProducto = ?";
                        $stmt_stock = $conexion->prepare($sql_stock);
                        $stmt_stock->bind_param('i', $producto_id);
                        $stmt_stock->execute();
                        $resultado_stock = $stmt_stock->get_result();
                        if ($resultado_stock->num_rows > 0) {
                            $stock_total = $resultado_stock->fetch_assoc()['StockTotal'];
                            echo $stock_total . "";
                        } else {
                            echo "Sin stock disponible";
                        }
                        ?>
                    </p>
                <?php endif; ?>

                <div class="guarantee">
                    <i class="fas fa-check-circle"></i> 10 días de garantía.
                </div>

                <div class="shipping">
                    <i class="fas fa-shipping-fast"></i> Envío gratis al comprar 2 o más productos.
                </div>

                <div class="accordion" id="productDetailsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                Descripción
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <?php echo nl2br(htmlspecialchars($producto['Descripcion'])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Tiempo de entrega
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                El tiempo de entrega estimado es de 2-3 días hábiles.
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>No se encontró el producto.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h3 class="mb-4 text-center">Productos Relacionados</h3>
    <div class="row">
        <?php
        $sql_relacionados = "SELECT p.IdProducto, p.Nombre, p.PrecioUnitario, p.ImagenProducto 
                             FROM producto p 
                             WHERE p.IdCategoria = ? AND p.IdProducto != ? 
                             LIMIT 4"; 
        $stmt_relacionados = $conexion->prepare($sql_relacionados);
        $stmt_relacionados->bind_param('ii', $producto['IdCategoria'], $producto_id);
        $stmt_relacionados->execute();
        $resultado_relacionados = $stmt_relacionados->get_result();

        while ($producto_relacionado = $resultado_relacionados->fetch_assoc()):
            $nombreProducto = (strlen($producto_relacionado['Nombre']) > 25) ? substr($producto_relacionado['Nombre'], 0, 20) . '...' : $producto_relacionado['Nombre'];
        ?>
            <div class="col-6 col-md-3" style="margin-top: 20px">
                <div class="card product-card h-100 text-center border-0">
                    <img src="http://localhost/SPORTFLEXX/Cliente/ImagenProductos/<?php echo $producto_relacionado['ImagenProducto']; ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($nombreProducto); ?>">
                    <div class="card-body">
                        <h6 class="card-title wbon"><?php echo htmlspecialchars($nombreProducto); ?></h6>
                        <p class="precio">S/ <?php echo number_format($producto_relacionado['PrecioUnitario'], 2); ?></p>
                        <a href="detalles_producto.php?id=<?php echo $producto_relacionado['IdProducto']; ?>" class="btn btn-primary btn-block w-100">Ver detalles</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include_once "footer.php"; ?>

<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function actualizarStock() {
        var idProducto = <?php echo $producto_id; ?>;
        var tallaSeleccionada = document.querySelector('input[name="talla"]:checked').value;

        if (idProducto && tallaSeleccionada) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../../Admin/PHP/Menus/ObtenerStock.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("stock-info").textContent = xhr.responseText;
                }
            };
            xhr.send("IdProducto=" + idProducto + "&Talla=" + tallaSeleccionada);
        }
    }

    document.querySelectorAll('input[name="talla"]').forEach(function(radio) {
        radio.addEventListener('change', actualizarStock);
    });
</script>

</body>
</html>
