<?php
session_start();
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");
$obj = new Conectar();
$conexion = $obj->getConexion();

function mostrarProductos($categoriaId, $conexion) {
    $query = "SELECT * FROM producto WHERE IdCategoria = ? LIMIT 4";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $categoriaId);
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
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPORTFLEXX</title>
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
    background-color: #A3D5FF;
  }

  .navbar-custom {
    background-color: #A3D5FF;
  }

  body {
    background-color: #F0F8FF;
  }

  footer {
    background-color: #81C1FF;
    color: #000000;
  }
  
</style>
<body>
<?php include_once "navbar.php"; ?>
  <div class="container-fluid p-0">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <video class="video-fluid w-100" autoplay loop muted>
            <source src="../ImagenMenu/SPORTFLEXX.mp4" type="video/mp4">
          </video>
          <div class="carousel-caption d-none d-md-block">
            <h2 class="text-warning fw-bold">Bienvenido a Sportflexx</h2>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../ImagenMenu/SPORTFLEXX.png" class="d-block w-100" alt="Nature with sea">
          <div class="carousel-caption d-none d-md-block">
            <h2 class="text-warning fw-bold">Bienvenido a Sportflexx</h2>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 class="text-left my-2">HOMBRES</h3>
        <a href="hombreCliente.php"><h4 class="text-left">ver todo</h4></a>
      </div>
    </div>
    <div class="row row-cols-2 row-cols-md-4 g-4 py-5">
      <?php mostrarProductos(1, $conexion); ?>
    </div>

    <div class="row">
      <div class="col-12">
        <h3 class="text-left my-2">MUJERES</h3>
        <a href="mujerCliente.php"><h4 class="text-left">ver todo</h4></a>
      </div>
    </div>
    <div class="row row-cols-2 row-cols-md-4 g-4 py-5">
      <?php mostrarProductos(2, $conexion); ?>
    </div>

    <div class="row">
      <div class="col-12">
        <h3 class="text-left my-2">ACCESORIOS</h3>
        <a href="AccesoriosCliente.php"><h4 class="text-left">ver todo</h4></a>
      </div>
    </div>
    <div class="row row-cols-2 row-cols-md-4 g-4 py-5">
      <?php mostrarProductos(3, $conexion); ?>
    </div>
  </div>

  <?php include_once "footer.php" ?>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
