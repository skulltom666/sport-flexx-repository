<?php
session_start();
require_once(__DIR__ . "/../coneccion/conector.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conectar = new Conectar();
$conexion = $conectar->getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnLogin'])) {
    if (empty($_POST["NombreUsuario"]) || empty($_POST["Contrasena"])) {
        $_SESSION['mensaje'] = "Los campos están vacíos";
        header("Location: ../../../Cliente/PHP/login2.php");
        exit();
    } else {
        $Usuario = $_POST["NombreUsuario"];
        $Contrasena = $_POST["Contrasena"];

        $stmt = $conexion->prepare("SELECT Bloqueado, Intentos, Contrasena, IdRol, IdUsuario FROM usuario WHERE NombreUsuario = ?");
        $stmt->bind_param("s", $Usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($user['Bloqueado'] == 1) {
                $_SESSION['mensaje'] = "Usuario bloqueado. Contacte al administrador.";
                header("Location: ../../../Cliente/PHP/login2.php");
                exit();
            }

            if ($user['Intentos'] == 0) {
                $stmt = $conexion->prepare("UPDATE usuario SET Bloqueado = 1 WHERE NombreUsuario = ?");
                $stmt->bind_param("s", $Usuario);
                $stmt->execute();
                $_SESSION['mensaje'] = "Usuario bloqueado por múltiples intentos fallidos.";
                header("Location: ../../../Cliente/PHP/login2.php");
                exit();
            }

            if (password_verify($Contrasena, $user['Contrasena'])) { 
                $IdRol = $user['IdRol'];
                $IdUsuario = $user['IdUsuario'];

                $_SESSION['IdUsuario'] = $IdUsuario;
                $_SESSION['idRol'] = $IdRol;

                $stmt = $conexion->prepare("UPDATE usuario SET Intentos = 3 WHERE NombreUsuario = ?");
                $stmt->bind_param("s", $Usuario);
                $stmt->execute();

                if ($IdRol == 1) {
                    header("Location: ../../../Admin/PHP/Menus/MenuAdmin.php"); 
                    exit();
                } else if ($IdRol == 2) {
                    header("Location: ../../../Cliente/HTML/MenuPrincipalCliente.php");
                    exit();
                } else {
                    $_SESSION['mensaje'] = 'Rol desconocido.';
                    header("Location: ../../../Cliente/PHP/login2.php");
                    exit();
                }
            } else {
                $stmt = $conexion->prepare("UPDATE usuario SET Intentos = Intentos - 1 WHERE NombreUsuario = ?");
                $stmt->bind_param("s", $Usuario);
                $stmt->execute();

                $stmt = $conexion->prepare("SELECT Intentos FROM usuario WHERE NombreUsuario = ?");
                $stmt->bind_param("s", $Usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                $intentosRestantes = $user['Intentos'];

                if ($intentosRestantes > 0) {
                    $_SESSION['mensaje'] = "Usuario y/o claves incorrectos. Intentos restantes: " . $intentosRestantes;
                } else {
                    $_SESSION['mensaje'] = "Usuario bloqueado por múltiples intentos fallidos.";
                }

                header("Location: ../../../Cliente/PHP/login2.php");
                exit();
            }
        } else {
            $_SESSION['mensaje'] = "Usuario y/o claves incorrectos.";
            header("Location: ../../../Cliente/PHP/login2.php");
            exit();
        }
    }
}
?>