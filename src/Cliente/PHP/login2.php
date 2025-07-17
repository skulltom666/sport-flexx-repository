<?php
session_start();
require_once(__DIR__ . "/../../Admin/PHP/coneccion/conector.php");

// Cargar archivo de registro de usuario solo si se envía btnRegistrar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrar'])) {
    require_once(__DIR__ . "/../../Admin/PHP/Menus/registrarUsuario.php");
}

// Configuración de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Captura de mensajes de error o éxito desde sesión
$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styleLogin2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login - SPORTFLEXX</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="login2.php" autocomplete="off">
                <h1>Registrarse</h1>
                <input type="text" placeholder="Usuario" name="NombreUsuario" id="NombreUsuario" required>
                <input type="email" placeholder="Correo electrónico" name="CorreoElectronico" id="CorreoElectronico" required>
                <input type="password" placeholder="Contraseña" name="Contrasena" id="Contrasena" required>
                <input type="password" name="ConfirmarContrasena" placeholder="Confirmar contraseña" required>
                <input type="text" placeholder="Nombre" name="Nombre" required>
                <input type="text" placeholder="Apellido" name="Apellido" required>
                <label for="gender">Género</label>
                <select id="gender" name="Sexo" required>
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="male">Masculino</option>
                    <option value="female">Femenino</option>
                </select>
                <label for="birthdate">Fecha de nacimiento</label>
                <input type="date" id="birthdate" name="FechaNacimiento" required>
                <input type="tel" placeholder="Número de celular" name="Telefono" required>
                <input type="text" placeholder="DNI" name="Dni" required>
                <input type="text" placeholder="Dirección" name="Direccion" required>
                <button type="submit" name="btnRegistrar">Registrarse</button>
            </form>
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <div class="form-container sign-in">
            <form method="POST" action="../../Admin/PHP/Menus/ControladorUsuario.php">
                <h1>Iniciar sesión</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>O</span>
                <?php if ($mensaje): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
                <?php endif; ?>
                <input type="text" placeholder="Usuario" name="NombreUsuario" required autofocus>
                <input type="password" placeholder="Contraseña" name="Contrasena" required>
                <a href="#">¿Olvidaste tu contraseña?</a>
                <button type="submit" name="btnLogin">Iniciar sesión</button>
            </form>
        </div>

        <!-- Contenedor de Alternancia -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Ingrese a su cuenta para utilizar todas las funciones del sitio</p>
                    <button class="hidden" id="login">Iniciar sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Hola, amigo!</h1>
                    <p>Regístrese con sus datos personales para utilizar todas las funciones del sitio</p>
                    <button class="hidden" id="register">Registrarse</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
