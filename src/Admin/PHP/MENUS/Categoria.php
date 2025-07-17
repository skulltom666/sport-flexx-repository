<?php
require_once(__DIR__ . "/../coneccion/conector.php");
$obj = new Conectar();
$sql = "SELECT * FROM categoria";
$rsMed = mysqli_query($obj->getConexion(), $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Categoría - SPORTFLEXX</title>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Categorías</h1>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCategoria" onclick="clearForm()">Nueva Categoría</button>
                    <div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCategoriaLabel">Categoría</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="Categoria-form">
                                        <input type="hidden" id="IdCategoria" name="IdCategoria" value="0">
                                        <div class="mb-3">
                                            <label for="categoria-Nombre" class="form-label">Nombre</label>
                                            <input type="text" id="categoria-Nombre" name="Nombre" class="form-control" required>
                                            <div class="invalid-feedback" id="nombre-error"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="categoria-Descripcion" class="form-label">Descripción</label>
                                            <input type="text" id="categoria-Descripcion" name="Descripcion" class="form-control" required>
                                            <div class="invalid-feedback" id="descripcion-error"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Guardar Categoría</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Categorías
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>IdCategoría</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($registro = mysqli_fetch_array($rsMed)) { ?>
                                        <tr>
                                            <td><?php echo $registro["IdCategoria"]; ?></td>
                                            <td><?php echo $registro["Nombre"]; ?></td>
                                            <td><?php echo $registro["Descripcion"]; ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm edit-btn" data-id="<?php echo $registro['IdCategoria']; ?>" data-bs-toggle="modal" data-bs-target="#modalCategoria">Editar</button>
                                                <form method="POST" action="EliminarCategoria.php" style="display:inline;" class="delete-form">
                                                    <input type="hidden" name="Categoria-Id" value="<?php echo $registro['IdCategoria']; ?>">
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
            </main>
<?php
include_once "footer_Admin.php";
?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
        crossorigin="anonymous"></script>
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
            document.getElementById("IdCategoria").value = row.cells[0].innerText.trim();
            document.getElementById("categoria-Nombre").value = row.cells[1].innerText.trim();
            document.getElementById("categoria-Descripcion").value = row.cells[2].innerText.trim();
        });
    });

    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach(form => {
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            const confirmation = confirm("¿Está seguro de que desea eliminar esta Categoría?");
            if (confirmation) {
                const idCategoria = form.querySelector('input[name="Categoria-Id"]').value;

                fetch("EliminarCategoria.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ 'Categoria-Id': idCategoria })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Error al eliminar la categoría.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });

    document.getElementById("Categoria-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const nombre = document.getElementById("categoria-Nombre").value.trim();
        const descripcion = document.getElementById("categoria-Descripcion").value.trim();
        const idCategoria = document.getElementById("IdCategoria").value.trim();

        let valid = true;

        if (nombre === "" || /[^a-zA-Z\s]/.test(nombre)) {
            valid = false;
            document.getElementById("nombre-error").textContent = "El nombre es obligatorio y solo debe contener letras.";
            document.getElementById("categoria-Nombre").classList.add("is-invalid");
        } else {
            document.getElementById("nombre-error").textContent = "";
            document.getElementById("categoria-Nombre").classList.remove("is-invalid");
        }

        if (descripcion === "") {
            valid = false;
            document.getElementById("descripcion-error").textContent = "La descripción es obligatoria.";
            document.getElementById("categoria-Descripcion").classList.add("is-invalid");
        } else {
            document.getElementById("descripcion-error").textContent = "";
            document.getElementById("categoria-Descripcion").classList.remove("is-invalid");
        }

        if (valid) {
            const data = {
                IdCategoria: idCategoria,
                Nombre: nombre,
                Descripcion: descripcion
            };

            fetch("RegistrarCategoria.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Error al guardar la categoría.");
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });

    document.getElementById("categoria-Nombre").addEventListener("input", function() {
        const nombre = this.value.trim();
        if (nombre === "" || /[^a-zA-Z\s]/.test(nombre)) {
            document.getElementById("nombre-error").textContent = "El nombre es obligatorio y solo debe contener letras.";
            this.classList.add("is-invalid");
        } else {
            document.getElementById("nombre-error").textContent = "";
            this.classList.remove("is-invalid");
        }
    });

    document.getElementById("categoria-Descripcion").addEventListener("input", function() {
        const descripcion = this.value.trim();
        if (descripcion === "") {
            document.getElementById("descripcion-error").textContent = "La descripción es obligatoria.";
            this.classList.add("is-invalid");
        } else {
            document.getElementById("descripcion-error").textContent = "";
            this.classList.remove("is-invalid");
        }
    });
});

function clearForm() {
    document.getElementById("IdCategoria").value = "0";
    document.getElementById("categoria-Nombre").value = "";
    document.getElementById("categoria-Descripcion").value = "";
    document.getElementById("nombre-error").textContent = "";
    document.getElementById("descripcion-error").textContent = "";
    document.getElementById("categoria-Nombre").classList.remove("is-invalid");
    document.getElementById("categoria-Descripcion").classList.remove("is-invalid");
}

    </script>
</body>
</html>
