<?php 
    
    include ("./preparedsqls.php");
   
     $date = date('Y-m-d ');
    $ejecuta = new preparedsqls();
   
    
    if(isset($_POST['action'])){
	$action = $_POST['action'];
    } else {
	die("Ninguna accion ha sido a definida");
    }
    //echo $action;
    $ejecuta  = new preparedsqls();

    switch ($action){
        
         case $action === '': 
                $sql1 = ("SELECT * FROM  `agencias` LIMIT 0 , 30");
                $sql= str_replace("''","null", $sql1);
                echo $ejecuta->ejecutar($sql1,$action);
                break;
            
        case $action === 'obtenerAgencias': 
            $ejecuta->obtenerAgencias($action);
        break;
        case $action === 'obtenerCasosGenerales': 
            $ejecuta->obtenerCasosGenerales($action,$_POST['data']);
        break;
     
        case $action === 'procesarCaso': 
                $sql1 = ("insert into categorias(nombre,descripcion) "
                . "values ('".strtoupper($_POST['nombre_cat'])."','$descrip')");
                //return($sql."asdasdsad");
                $sql= str_replace("''","null", $sql1);
                echo $ejecuta->ejecutar($sql,$action);
                break;
         
                break;
	default :
                break;
        
    }
    ?>