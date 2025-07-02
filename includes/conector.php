<?php
class Conectar {
    private $server = "localhost";
    private $login = "root";
    private $pass = "admin";
    private $bdatos = "sportflexx";
    private $conexion;

    function __construct() {
        $this->conexion = new mysqli($this->server, $this->login, $this->pass, $this->bdatos);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
        
        $this->conexion->set_charset("utf8mb4");
        
        if ($this->conexion->ping()) {
            
        } else {
            echo "Error de conexión: " . $this->conexion->error;
        }
    }

    function getConexion() {
        return $this->conexion;
    }

    function closeConexion() {
        $this->conexion->close();
    }
}
?>
