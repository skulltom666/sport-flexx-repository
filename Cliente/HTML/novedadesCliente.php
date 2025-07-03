<?php
session_start();
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");
$obj = new Conectar();
$conexion = $obj->getConexion();

function mostrarProductoNovedades($conexion) {
    $query = "SELECT * FROM producto WHERE IdCategoria = 4";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $rutaBaseImagen = "../ImagenProductos/";

    while ($row = $result->fetch_assoc()) {
        $imagenRuta = $rutaBaseImagen . $row['ImagenProducto'];

        if (!file_exists($imagenRuta)) {
            $imagenRuta = "../ImagenProductos/default.png";
        }

        $nombreProducto = (strlen($row['Nombre']) > 40) ? substr($row['Nombre'], 0, 40) . '...' : $row['Nombre'];

        echo '<div class="col">
                <div class="card h-100 product-card">
                    <img src="' . $imagenRuta . '" class="card-img-top" alt="Imagen de ' . htmlspecialchars($row['Nombre']) . '">
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
  <title>NOVEDADES</title>
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
    background: #FFD200 ;
  }
  .navbar-custom{
    background: #FFD200 ;
  }
  footer{
    background: #FFD200 ;
  }

  .centered-text p {
    font-size: 1.2rem;
    line-height: 1.8;
  }

  .carousel-item img,
  .carousel-item video {
    width: 100%;
    height: auto;
    max-height: 720px;
  }

  .carousel-caption {
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
  }

  .carousel-caption h2 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #ffc107;
  }


  @media (max-width: 768px) {
    .carousel-caption h2 {
      font-size: 0.8rem;
    }

    .carousel-item img,
    .carousel-item video {
      max-height: 400px;
      object-fit: cover;
    }

    .container.mt-5 {
      padding: 0 10px;
    }

    .carousel-caption {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;

    }
  }

  .centered-text {
    text-align: center;
    margin: 40px auto;
    max-width: 80%;
  }

  .centered-text h2 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .centered-text p {
    font-size: 1.2rem;
    line-height: 1.8;
    text-align: justify;
  }

  .conteiner {
    background-color: #66CCFF;
    padding: 50px;
    border-radius: 8px;
    text-align: center;
    
  }

  h1 {
    color: white;
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .driver-name {
    color: white;
    font-size: 2rem;
    font-weight: bold;
  }

  .driver-description {
    color: white;
    font-size: 1.2rem;
    line-height: 1.8;
    text-align: justify;
  }

  .hola{
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
  }

  img {
    width: 350px;
    height: auto;
    border-radius: 8px;
  }

  /* Asegura que sea responsivo en pantallas más pequeñas */
  @media (max-width: 768px) {
    .driver-name {
      font-size: 1.5rem;
    }

    .driver-description {
      font-size: 1rem;
    }

    img {
      margin-bottom: 20px;
    }
  }
</style>
<body>
<?php include_once "navbar.php"; ?>
  <div class="container-fluid p-0">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
          aria-current="true"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <video class="video-fluid w-100" autoplay loop muted>
            <source src="../ImagenMenu/fernandoalonso.mp4" type="video/mp4">
          </video>
          <div class="carousel-caption">
            <h2 class="text-warning">SPORTFLEXX X FERNANDO ALONSO</h2>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../ImagenMenu/AlonsoAston.png" class="d-block w-100" alt="Fernando Alonso"
            style="max-height: 720px">
          <div class="carousel-caption">
            <h2 class="text-warning">SPORTFLEXX X FERNANDO ALONSO</h2>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="centered-text">
    <h2>DESAFÍA LOS LÍMITES</h2>
    <p>
      Sumérgete en el emocionante mundo de nuestra colección exclusiva junto a Fernando Alonso, donde la pasión por la
      velocidad y el estilo se fusionan. Esta nueva línea, inspirada en su icónica etapa con Renault en la F1™, combina
      la elegancia urbana con la funcionalidad deportiva moderna. Cada pieza, diseñada para reflejar el espíritu
      indomable de Alonso, encarna su energía pura y su determinación sin límites. Libera tu espíritu competitivo y haz
      una declaración tanto dentro como fuera de la pista.
    </p>
  </div>

  <div class="conteiner mt-5">
    <h1 class="text-center">SOBRE ÉL</h1>
    <div class="row align-items-center mt-4">
      <div class="col-md-6">
        <img src="https://cdn-5.latimages.com/images/mgl/O1OkA/s4/open-uri20120928-4766-1yhlnzs.jpg"
          class="img-fluid rounded hola" alt="Fernando Alonso">
      </div>
      <div class="col-md-6">
        <h2 class="driver-name">Fernando Alonso</h2>
        <p class="driver-description">
          Fernando Alonso es un ejemplo de longevidad al más alto nivel. El asturiano está en la élite del deporte de
          motor desde hace más de 20 años y su figura aún hoy es más vigente que nunca. A pesar de haber pilotado en
          otras categorías, es en la Fórmula 1 donde ha dejado un increíble legado.
          <br><br>
          El equipo al que se asocia la figura de Alonso en la Fórmula 1 por encima de ningún otro es Renault. El equipo
          francés brindó días de vino y rosas para el piloto asturiano, y es que el binomio Reanult-Alonso fue un
          matrimonio perfecto que cosechó grandes éxitos.
        </p>
      </div>
    </div>
  </div>


  <div class="container mt-5">
    <h3 class="text-left my-2">NOVEDADES</h3>
    <div class="row row-cols-2 row-cols-md-4 g-4 py-5">
      <?php mostrarProductoNovedades($conexion); ?>
    </div>
  </div>

  <?php include_once "footer.php"; ?>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>