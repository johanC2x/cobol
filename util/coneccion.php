<?php

    class Conexion{
        public function Conectarse() {
            $servidor = "localhost";
            $basededatos = "cobol";
            $usuario = "root";
            $clave = "1234";
            $cn = mysql_connect($servidor, $usuario, $clave) or die("Error  no pudo conectarse");
            mysql_select_db($basededatos, $cn) or die("Error de Selecion de base de datos");
            mysql_query("SET NAMES 'utf8'");
            return $cn; 
        }
    }

?>