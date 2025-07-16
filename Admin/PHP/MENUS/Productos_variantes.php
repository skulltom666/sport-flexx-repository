<?php
require_once(__DIR__ . "/../coneccion/conector.php");

$obj = new Conectar();
$sql = "SELECT p.IdProducto, p.Nombre, v.IdVariante, v.Talla, v.Stock 
        FROM producto p
        JOIN producto_variantes v ON p.IdProducto = v.IdProducto";
$rsVariante = mysqli_query($obj->getConexion(), $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Gestión de Variantes de Productos - SPORTFLEXX</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../estilos/stylesAdmin.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php
include_once "navbar_admin.php";
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4" style="padding-bottom: 55px">
            <h1 class="mt-4">Variantes de Productos</h1>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalVariante"
                onclick="clearForm()">Nueva Variante</button>

            <div id="modalVariante" class="modal fade" tabindex="-1" aria-labelledby="modalVarianteLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalVarianteLabel">Variante de Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="variant-form" method="post" action="RegistrarVariante.php">
                                <input type="hidden" id="IdVariante" name="IdVariante" value="0">
                                <div class="mb-3">
                                    <label for="variant-product">Producto:</label>
                                    <select id="variant-product" name="IdProducto" class="form-control" required>
                                        <option value="">[Seleccione Producto]</option>
                                        <?php
                                        $sql_productos = "SELECT * FROM producto";
                                        $rs_productos = mysqli_query($obj->getConexion(), $sql_productos);
                                        while ($row_producto = mysqli_fetch_array($rs_productos)) {
                                            echo "<option value='" . $row_producto['IdProducto'] . "'>" . $row_producto['Nombre'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="variant-size">Talla</label>
                                    <select class="form-select" id="variant-size" name="Talla" required>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="variant-stock">Stock:</label>
                                    <input type="number" id="variant-stock" name="Stock" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Guardar Variante</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Variantes de Productos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>IdProducto</th>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($registro = mysqli_fetch_array($rsVariante)) { ?>
                                <tr>
                                    <td><?php echo $registro["IdProducto"]; ?></td>
                                    <td><?php echo $registro["Nombre"]; ?></td>
                                    <td><?php echo $registro["Talla"]; ?></td>
                                    <td><?php echo $registro["Stock"]; ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn"
                                            data-id="<?php echo $registro['IdVariante']; ?>" data-bs-toggle="modal"
                                            data-bs-target="#modalVariante">Editar</button>
                                        <form method="POST" action="EliminarVariante.php" style="display:inline;"
                                            class="delete-form">
                                            <input type="hidden" name="variant-id"
                                                value="<?php echo $registro['IdVariante']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>                
                </div>
            </div>
        </div>
    </main>
<?php
include_once "footer_Admin.php";
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../assets/demo/chart-area-demo.js"></script>
<script src="../assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="../js/datatables-simple-demo.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const editButtons = document.querySelectorAll(".edit-btn");
        
        editButtons.forEach(button => {
            button.addEventListener("click", () => {
                const row = button.closest("tr");
                
                document.getElementById("IdVariante").value = button.getAttribute("data-id");
                document.getElementById("variant-product").value = row.cells[0].innerText;
                document.getElementById("variant-size").value = row.cells[2].innerText; 
                document.getElementById("variant-stock").value = row.cells[3].innerText;
            });
        });

        const deleteForms = document.querySelectorAll(".delete-form");
        deleteForms.forEach(form => {
            form.addEventListener("submit", (event) => {
                event.preventDefault();
                const confirmation = confirm("¿Está seguro de que desea eliminar esta variante?");
                if (confirmation) {
                    form.submit();
                }
            });
        });

        window.clearForm = function () {
            document.getElementById("IdVariante").value = "0";
            document.getElementById("variant-product").value = "";
            document.getElementById("variant-size").value = "";  
            document.getElementById("variant-stock").value = "";
        };
    });
</script>
</body>
</html>
