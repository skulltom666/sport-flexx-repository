<?php
require_once(__DIR__ . "/../coneccion/conector.php");

$obj = new Conectar();
$searchTerm = '';

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];  // Obtén el término de búsqueda del formulario
}

$sql = "SELECT p.IdProducto, p.Nombre, p.Descripcion, p.PrecioUnitario, p.FechaRegistro, p.ImagenProducto, c.Nombre as CategoriaNombre
        FROM producto p
        JOIN categoria c ON p.IdCategoria = c.IdCategoria";

if (!empty($searchTerm)) {
    $sql .= " WHERE p.Nombre LIKE ?";  // Filtra por nombre de producto
    $stmt = $obj->getConexion()->prepare($sql);
    $searchTerm = '%' . $searchTerm . '%';  // Permite búsqueda parcial
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $rsMed = $stmt->get_result();
} else {
    $rsMed = mysqli_query($obj->getConexion(), $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Gestión de Productos - SPORTFLEXX</title>
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
            <h1 class="mt-4">Productos</h1>
            
            <!-- Formulario de búsqueda -->
            <form method="GET" action="Productos.php" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalProducto"
                onclick="clearForm()">Nuevo Producto</button>

            <!-- Modal para Añadir/Editar Producto -->
            <div id="modalProducto" class="modal fade" tabindex="-1" aria-labelledby="modalProductoLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalProductoLabel">Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="product-form" method="post" action="RegistrarProducto.php"
                                enctype="multipart/form-data">
                                <input type="hidden" id="IdProducto" name="IdProducto" value="0">
                                <div class="mb-3">
                                    <label for="product-name">Nombre del Producto:</label>
                                    <input type="text" id="product-name" name="Nombre" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-description">Descripción:</label>
                                    <textarea id="product-description" name="Descripcion" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="product-category">Categoría:</label>
                                    <select id="product-category" name="IdCategoria" class="form-control" required>
                                        <option value="">[Seleccione Categoria]</option>
                                        <?php
                                        $sql_categorias = "SELECT * FROM categoria";
                                        $rs_categorias = mysqli_query($obj->getConexion(), $sql_categorias);
                                        while ($row_categoria = mysqli_fetch_array($rs_categorias)) {
                                            echo "<option value='" . $row_categoria['IdCategoria'] . "'>" . $row_categoria['Nombre'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="product-price">Precio:</label>
                                    <input type="number" id="product-price" name="PrecioUnitario" class="form-control" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-date">Fecha de Registro</label>
                                    <input type="date" id="product-date" name="FechaRegistro" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-images">Imágenes:</label>
                                    <input type="file" id="product-images" name="ImagenProducto" class="form-control" multiple>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Guardar Producto</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Productos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>IdProducto</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Categoria</th>
                                    <th>Precio</th>
                                    <th>FechaRegistro</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($registro = mysqli_fetch_array($rsMed)) { ?>
                                <tr>
                                    <td><?php echo $registro["IdProducto"]; ?></td>
                                    <td><?php echo $registro["Nombre"]; ?></td>
                                    <td><?php echo $registro["Descripcion"]; ?></td>
                                    <td><?php echo $registro["CategoriaNombre"]; ?></td>
                                    <td><?php echo $registro["PrecioUnitario"]; ?></td>
                                    <td><?php echo $registro["FechaRegistro"]; ?></td>
                                    <td><?php echo basename($registro["ImagenProducto"]); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn"
                                            data-id="<?php echo $registro['IdProducto']; ?>" data-bs-toggle="modal"
                                            data-bs-target="#modalProducto">Editar</button>
                                        <form method="POST" action="EliminarProducto.php" style="display:inline;"
                                            class="delete-form">
                                            <input type="hidden" name="product-id"
                                                value="<?php echo $registro['IdProducto']; ?>">
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
                document.getElementById("IdProducto").value = row.cells[0].innerText;
                document.getElementById("product-name").value = row.cells[1].innerText;
                document.getElementById("product-description").value = row.cells[2].innerText;
                document.getElementById("product-category").value = row.cells[3].innerText;
                document.getElementById("product-price").value = row.cells[4].innerText;
                document.getElementById("product-date").value = row.cells[5].innerText;
                document.getElementById("product-images").value = row.cells[6].innerText; // Aquí se mantiene la imagen
            });
        });

        const deleteForms = document.querySelectorAll(".delete-form");
        deleteForms.forEach(form => {
            form.addEventListener("submit", (event) => {
                event.preventDefault();
                const confirmation = confirm("¿Está seguro de que desea eliminar este producto?");
                if (confirmation) {
                    form.submit();
                }
            });
        });

        function clearForm() {
            document.getElementById("IdProducto").value = "0";
            document.getElementById("product-name").value = "";
            document.getElementById("product-description").value = "";
            document.getElementById("product-category").value = "";
            document.getElementById("product-price").value = "";
            document.getElementById("product-date").value = "";
            document.getElementById("product-images").value = "";
        }
    });
</script>
</body>
</html>
