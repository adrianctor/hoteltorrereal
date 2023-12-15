<?php
class Conexion{
	static public function conectar(){
		//$link = new PDO("mysql:host=localhost;dbname=id16320587_sistemapos","id16320587_adriantor","B171179179ce4!",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $link = new PDO("mysql:host=localhost;dbname=domifyap_wp82","domifyap_wp82","R6!j55Spd[",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $link -> exec("set names utf8");
		return $link;
	}
}