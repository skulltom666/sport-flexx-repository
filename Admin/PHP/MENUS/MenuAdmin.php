<?php
session_start();
if (!isset($_SESSION['idRol']) || $_SESSION['idRol'] != 1) {
    header("Location: ../../../Cliente/PHP/login2.php");
    exit();
}

require_once(__DIR__ . "/../coneccion/conector.php");
$obj = new Conectar();
$conexion = $obj->getConexion();

$menus = obtenerMenusPorRol(1, $conexion);

function obtenerMenusPorRol($idRol, $conexion) {
    $query = "SELECT MENU.Nombre, MENU.Ruta
              FROM MENU
              INNER JOIN ROLMENU ON MENU.IdMenu = ROLMENU.IdMenu
              WHERE ROLMENU.IdRol = ?";
              
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idRol);
    $stmt->execute();
    $result = $stmt->get_result();
    $menus = [];

    while ($row = $result->fetch_assoc()) {
        $menus[] = $row;
    }
    
    $stmt->close();
    return $menus;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SPORTFLEXX</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../estilos/stylesAdmin.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
include_once "navbar_admin.php";
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4" style="margin-bottom  : 35px">
            <div class="chart-container">
                <canvas id="ventasChart"></canvas>
                <canvas id="categoriasChart"></canvas>
            </div>
        </div>
    </main>
    <?php
include_once "footer_Admin.php";
?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('obtenerDatosGraficos.php')
            .then(response => response.json())
            .then(data => {
                const ventasData = data.ventas.map(item => item.Total);
                const ventasLabels = data.ventas.map(item => item.Fecha);

                const categoriasData = data.categorias.map(item => item.Total);
                const categoriasLabels = data.categorias.map(item => item.Categoria);

                const clientesData = data.clientes.map(item => item.Total);
                const clientesLabels = data.clientes.map(item => item.Sexo);

                const ventasChart = new Chart(document.getElementById('ventasChart'), {
                    type: 'line',
                    data: {
                        labels: ventasLabels,
                        datasets: [{
                            label: 'Ventas Totales',
                            data: ventasData,
                            borderColor: '#17a2b8',
                            fill: false,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Ventas por Fecha'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Fecha'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Ventas'
                                }
                            }
                        }
                    }
                });

                const categoriasChart = new Chart(document.getElementById('categoriasChart'), {
                    type: 'bar',
                    data: {
                        labels: categoriasLabels,
                        datasets: [{
                            label: 'Total de Productos',
                            data: categoriasData,
                            backgroundColor: '#6f42c1'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Productos por Categoría'
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Categoría'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Productos'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
</script>
</body>

</html>