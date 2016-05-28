<?php

/* Archivo para funciones */


function conectaBaseDatos(){
    $config = parse_ini_file("config.ini", true);

    try{
		$servidor = $config["database"]["servidor"];
		$puerto = $config["database"]["puerto"];
		$basedatos = $config["database"]["basedatos"];
		$usuario = $config["database"]["usuario"];
		$contrasena = $config["database"]["contrasena"];
	
		$conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$basedatos",
							$usuario,
							$contrasena,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		
		$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $conexion;
	}
	catch (PDOException $e){
		die ("No se puede conectar a la base de datos". $e->getMessage());
	}
}

function dameEstado(){
	$resultado = false;
	$consulta = "SELECT * FROM estados";
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}

function dameMunicipio($estado = ''){
	$resultado = false;
	$consulta = "SELECT * FROM municipios";
	
	if($estado != ''){
		$consulta .= " WHERE estado_id = :estado";
	}

    $consulta .= " ORDER BY nombre";
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bindParam('estado',$estado);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}

function dameLocalidad($municipio = ''){
	$resultado = false;
	$consulta = "SELECT * FROM localidades";
	
	if($municipio != ''){
		$consulta .= " WHERE municipio_id = :municipio";
	}

    $consulta .= " ORDER BY nombre";
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bindParam('municipio',$municipio);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}


?>