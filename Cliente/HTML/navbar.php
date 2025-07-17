<style>
    .navbar-brand img {
        width: 150px;
        max-width: 100%;
        height: auto;
    }

    .navbar-custom .nav-link {
        color: grey;
        font-weight: 500;
        transition: color 0.2s ease-in-out;
    }
    .navbar-custom .nav-link:hover {
        color: #0d6efd;
    }

    .navbar-custom .fa-user {
        color: #17a2b8;
    }

    .product-card {
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.05);
        z-index: 1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    
</style>
<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-papm6j6Q+z6rJv7WZ6vU5F6vJkF2p1Z8Yjv7w6Z6vJkF2p1Z8Yjv7w6Z6vJkF2p1Z8Yjv7w6Z6vJkF2p1Z8Yjv7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body>
<nav class="navbar navbar-expand-lg sticky-top navbar-custom">
    <div class="container-fluid">
        <!-- Logo y botón de menú -->
        <a href="MenuPrincipalCliente.php" class="navbar-brand text-info fw-semibold fs-4">
            <img src="../ImagenMenu/icono.png" width="350px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Menú lateral -->
        <section class="offcanvas offcanvas-start" id="menuLateral" tabindex="-1">
            <div class="offcanvas-header navbar-custom">
                <a href="MenuPrincipalCliente.php">
                    <img src="../ImagenMenu/icono.png" width="350px" alt="">
                </a>
                <button class="btn-close" type="button" aria-label="close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between px-0 Presentacion">
                <!-- Menú de navegación principal -->
                <ul class="navbar-nav my-2 justify-content-evenly">
                    <li class="nav-item p-3 py-md-1 fas fa-male">
                        <a href="hombreCliente.php" class="nav-link">HOMBRE</a>
                    </li>
                    <li class="nav-item p-3 py-md-1 fas fa-female">
                        <a href="mujerCliente.php" class="nav-link">MUJER</a>
                    </li>
                    <li class="nav-item p-3 py-md-1 fas fa-suitcase">
                        <a href="accesoriosCliente.php" class="nav-link">ACCESORIOS</a>
                    </li>
                    <li class="nav-item p-3 py-md-1 fas fa-gem">
                        <a href="novedadesCliente.php" class="nav-link">NOVEDADES</a>
                    </li>
                    <!-- Iconos de búsqueda y perfil alineados -->
                    <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$carrito_count = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
?>
<div class="d-flex align-items-center justify-content-end gap-2 mt-2">
    <a href="carrito.php" class="btn btn-link position-relative p-0" style="font-size:1.6rem; color:#0d6efd;">
        <i class="fas fa-shopping-cart"></i>
        <?php if ($carrito_count > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.8rem;">
                <?= $carrito_count ?>
            </span>
        <?php endif; ?>
    </a>
    <button id="searchIconBtn" class="btn btn-link p-0" type="button" style="font-size:1.4rem; color:#17a2b8; margin-right: 0.5rem;">
        <i class="fas fa-search"></i>
    </button>
    <div class="nav-item dropdown p-0">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fa-fw"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="MiPerfil.php"><i class="fas fa-cog"></i> Perfil</a>
            <a class="dropdown-item" href="Logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </ul>
    </div>
    <!-- Buscador flotante -->
    <div id="floatingSearch" class="position-absolute top-100 end-0 bg-white p-3 shadow rounded d-none" style="z-index:1050; min-width:300px;">
        <form class="d-flex" role="search" method="get" action="busqueda.php">
            <input class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Buscar" name="q" autofocus required>
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>
                </ul>
            </div>
        </section>
    </div>
</nav>

<script>
// Mostrar/ocultar buscador flotante
const searchIconBtn = document.getElementById('searchIconBtn');
const floatingSearch = document.getElementById('floatingSearch');
let searchOpen = false;
searchIconBtn.addEventListener('click', function(e) {
    floatingSearch.classList.toggle('d-none');
    if (!floatingSearch.classList.contains('d-none')) {
        floatingSearch.querySelector('input').focus();
        searchOpen = true;
    } else {
        searchOpen = false;
    }
});
document.addEventListener('mousedown', function(e) {
    if (searchOpen && !floatingSearch.contains(e.target) && e.target !== searchIconBtn) {
        floatingSearch.classList.add('d-none');
        searchOpen = false;
    }
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && searchOpen) {
        floatingSearch.classList.add('d-none');
        searchOpen = false;
    }
});
</script>