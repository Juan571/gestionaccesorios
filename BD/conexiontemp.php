<?php

    // Territorios
    $terr_host = "192.168.200.91";
    $terr_user = "usr_dev";
    $terr_pass = "*s3l3ct#*";
    $terr_name = "territorios";
    
    // Servidor de Accesorios
    $acc_host="192.168.200.93";
    $acc_user="usr_dev";
    $acc_pass="*s3l3ct#*";
    $acc_name="postventa_accesorios";

    $host_sigesp = '192.168.200.68';
    $port_sigesp = '5432';
    $user_sigesp = 'usr_dev';
    $pass_sigesp = '*s3l3ct#*';
    $name_sigesp = 'db_vtelca_2014';
    
    
    try{
	    //Conexion a Territorios
        $hTerritorios = new PDO("mysql:host=$terr_host;port=3307;dbname=$terr_name",$terr_user,$terr_pass);
        $hTerritorios->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $hTerritorios->exec("set names utf8");
	}catch(PDOException $e){
	    echo "ERROR: " . $e->getMessage();
	}
    
    try{
	    //Conexion a Accesorios
        $hAccesorios = new PDO("mysql:host=$acc_host;port=3309;dbname=$acc_name",$acc_user,$acc_pass);
        $hAccesorios->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $hAccesorios->exec("set names utf8");
	}catch(PDOException $e){
	    echo "ERROR: " . $e->getMessage();
	}