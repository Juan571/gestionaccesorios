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
    
        case $action === 'buscarCasosProc': 
            $ejecuta->obtenerCasosProcesados($action);
        break;
        case $action === 'obtenerCasosGenerales': 
            $ejecuta->obtenerCasosGenerales($action,$_POST['data']);
        break;
    
        case $action === 'despacharAcc':
            $idagencia=$_POST['agenciiaid'];    
            $idcaso = $_POST['casoid'];
           
            $sql = ("INSERT INTO seguimientos VALUES (null,now(), 3, $idcaso, 'despachado','$idagencia','0');"); 
            $ejecuta->ejecutar($sql,$action);
            $result = array("respuesta"=>$idcaso,"evento"=>$action);
            
            echo json_encode($result);
            
        break;
     
        case $action === 'procesarCaso': 
                $accesorios=$_POST['accesorios'];    
                $idcaso = $_POST['casoid'];
            
                for ($i=0;$i<count($accesorios);$i++){
                    $id = $accesorios[$i][1];
                    $aprobd = $accesorios[$i][0];
                    $obser = $accesorios[$i][2];
                     
                    $sql = ("INSERT INTO seguimientos VALUES (null,now(), 2, $idcaso, '$obser','0','$id');"); 
                        $ejecuta->ejecutar($sql,$action);
                        
                    if($aprobd=='true'){
                        $sql = ("UPDATE solicitudes_accesorios_inventario SET aprobado=1 WHERE id=$id"); 
                        $ejecuta->ejecutar($sql,$action);
                    }
                    
                }
                $result = array("respuesta"=>$idcaso,"evento"=>$action);
                echo json_encode($result);
            
                
                break;
         
                break;
	default :
                break;
        
    }
    ?>