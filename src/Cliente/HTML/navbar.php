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
<body>
<nav class="navbar navbar-expand-lg sticky-top navbar-custom">
    <div class="container-fluid">
        <a href="MenuPrincipalCliente.php" class="navbar-brand text-info fw-semibold fs-4"><img src="../ImagenMenu/icono.png" width=350px alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <span class="navbar-toggler-icon"></span>
        </button>
        <section class="offcanvas offcanvas-start" id="menuLateral" tabindex="-1">
            <div class="offcanvas-header navbar-custom">
                <a href="MenuPrincipalCliente.php"><img src="../ImagenMenu/icono.png" width=350px alt=""></a>
                <button class="btn-close" type="button" aria-label="close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between px-0 Presentacion">
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

                    <li class="nav-item dropdown p-3 py-md-1">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="MiPerfil.php"><i class="fas fa-cog"></i> Perfil</a>
                            <a class="dropdown-item" href="Logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
    </div>
</nav>
