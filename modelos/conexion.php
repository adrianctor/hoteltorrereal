<?php
class Conexion{
	static public function conectar(){
		// // $link = new PDO("mysql:host=localhost;dbname=torrereal","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        // $link = new PDO("mysql:host=localhost;dbname=domifyap_wp82","domifyap_wp82","R6!j55Spd[",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        // $link -> exec("set names utf8");
		// $link->exec("SET time_zone = '-05:00'");
		// return $link;
		try {
            $link = new PDO(
                "mysql:host=localhost;dbname=domifyap_wp82",
                "domifyap_wp82",
                "R6!j55Spd[",
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
            );
            // Establecer el charset y el timezone
            $link->exec("SET NAMES utf8");
            $link->exec("SET time_zone = '-05:00'");
            
            return $link;
        } catch (PDOException $e) {
            // Manejar el error en caso de que falle la conexión
            die("Error en la conexión: " . $e->getMessage());
        }
	}
}