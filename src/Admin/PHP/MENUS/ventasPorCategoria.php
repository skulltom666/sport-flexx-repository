<?php
session_start();
if (!isset($_SESSION['idRol']) || $_SESSION['idRol'] != 1) {
    header("Location: ../../../Cliente/PHP/login2.php");
    exit();
}

require_once(__DIR__ . "/../coneccion/conector.php");

$obj = new Conectar();
$sql = "SELECT c.Nombre AS Categoria, SUM(dp.Cantidad * dp.PrecioUnitario) AS TotalVentas
        FROM detallepedido dp
        JOIN producto p ON dp.IdProducto = p.IdProducto
        JOIN categoria c ON p.IdCategoria = c.IdCategoria
        GROUP BY c.Nombre";
$rsVentasCategoria = mysqli_query($obj->getConexion(), $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas por Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../estilos/stylesAdmin.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<?php
include_once "navbar_admin.php";
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Ventas por Categoría</h1>
                    <div class="mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Total Ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($venta = mysqli_fetch_assoc($rsVentasCategoria)) {
                                    echo "<tr>
                                            <td>{$venta['Categoria']}</td>
                                            <td>{$venta['TotalVentas']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
<?php
include_once "footer_Admin.php";
?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>
