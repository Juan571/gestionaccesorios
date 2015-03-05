<?php

require_once("conexion.php"); 


class preparedsqls{
   
    
    private $tipoDato;
    public $con;
    
    private $aaa;
    private $sesion;
	public function __construct(){
            $this->con = new conexion();		
	}
	
        public function obtenerAgencias($data){
            $sql=("SELECT * FROM  agencias where id = agencia_id");
            
            $result = $this->con->query($sql,2);
            $arr = array();
            foreach ($result as $row => $valor) {
                $arr[]  = $valor;							
            }
            $out = json_encode($arr);
            //$this->desconectarSigesp();
            echo $out;
        }
        public function obtenerCasosGenerales($action,$data){
            $sql=("SELECT * FROM  agencias where agencia_id = $data");            
            $result = $this->con->query($sql,2);
            
            
            
            foreach ($result as $row => $ofc) {
                //$arr[]  = $valor;	
                $html = "
                          <div class='panel panel-info' align='center'>
                          <div style='text-align: left' class='panel-heading'>
                            <strong>Agente Autorizado: ".$ofc['agencia']." </strong> Detalles de la Oficina Comercial 
                        </div>
                        <div class='panel-body'>";
                
               $sql=("SELECT 
                       solicitudes_accesorios.id as id,
                       solicitantes.nombres as nombres,
                       solicitantes.apellidos as apellidos,
                       solicitantes.cedula as cedula,
                       solicitantes.telefono_movil as tlf_movil,
                       solicitantes.telefono_fijo as tlf_fijo,                       
                       case  when solicitantes.correo='' then 'No posee' else solicitantes.correo end AS correo_sol,
                       equipos.factura as nfactura,
                       modelos.modelo as equipo_modelo,
                       colores.color as equipo_color,
                       date(equipos.fecha_compra) as fecha_compra,
                       operadoras.operadora as operadora,
                       tecnologias.tecnologia as tec,
                       equipos.imei as imei,
                       equipos.serial as serial
                       

                        FROM postventa_accesorios.solicitudes_accesorios
                        join equipos on (solicitudes_accesorios.equipo_id = equipos.id)
                        join usuarios on (solicitudes_accesorios.usuario_id= usuarios.id)
                        join agencias on (usuarios.agencia_id = agencias.id)
                        join solicitantes on (equipos.solicitante_id = solicitantes.id)
                        join modelos on (equipos.modelo_id = modelos.id)
                        join colores on (equipos.color_id = colores.id)
                        join operadoras on (equipos.operadora_id = operadoras.id)
                        join tecnologias on (equipos.tecnologia_id = tecnologias.id)

                        where agencias.id = ".$ofc['id'].";");            
                        $casos = $this->con->query($sql,2);
                        $numeroCasos = 0;
                        foreach ($casos as $ncasos => $datosCasos) {
                            $idcaso=$datosCasos['id'];
                            $numeroCasos ++;
                            $html=$html."
                            <div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>
                                <div class='panel panel-danger'>
                                    <div class='panel-heading' role='tab' id='headingOne'>
                                        <h4 style='text-align:left;' class='panel-title'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapse$idcaso' aria-expanded='false' class='collapsed' aria-controls='collapseOne'>
                                                Caso N° $idcaso
                                            </a>
                                        </h4>
                                    </div>
                                    <div id='collapse$idcaso' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne' aria-expanded='false' style='height: 0px;'>
                                       
                                        <div style='text-align: left;' class='panel-body'>
                                            <div class='col-lg-12'>

                                                <h4 style=' text-align: left;'class='page-header' ><strong>Caso N°:</strong>$idcaso</h4>
                                            </div>
                                            <div>
                                                <label style='padding-left: 2%;' >Datos del Cliente</label>
                                                <div class='col-lg-12'>
                                                    <div class='col-lg-3'>                                                        
                                                            <label >Nombre:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['nombres']." ".$datosCasos['apellidos']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3' >
                                                        <label>Cedula:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['cedula']."</p>                                             
                                                    </div>

                                                    <div class='col-lg-3'>
                                                        <label>Telefono:&nbsp;&nbsp; </label><p style='margin-top: -10%;' class='form-control-static'>".$datosCasos['tlf_movil']."<br>".$datosCasos['tlf_fijo']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>Correo:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['correo_sol']."</p>                                             
                                                    </div>
                                                    <div style='margin-top: 2%;margin-bottom: -2%;' class='page-header'></div>
                                                </div>
                                            </div>
                                            <div>
                                                <label style='padding-left: 2%;margin-top: 1%;'>Datos de Factura / Telefono</label>
                                                <div class='col-lg-12'>
                                                    <div class='col-lg-3'>
                                                        <label>N° Factura:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['nfactura']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>Telefono:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['equipo_modelo']."</p>                                             
                                                    </div>

                                                    <div class='col-lg-3'>
                                                        <label>Color:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['equipo_color']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>Fecha Compra:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['fecha_compra']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>Operadora:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['operadora']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>Tecnologia:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['tec']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>Serial:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['serial']."</p>                                             
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label>IMEI:&nbsp;&nbsp; </label><p class='form-control-static'>".$datosCasos['imei']."</p>                                             
                                                    </div>
                                                    <div style='margin-top: 4%;margin-bottom: -2%;' class='page-header'></div>
                                                </div>
                                            </div>
                                            <div>
                                                <label style='padding-left: 2%;margin-top: 1%;'>Accesorios</label>
                                                <div class='col-lg-12'>
                                                    <div class='col-lg-2'>
                                                        <label>Accesorio </label>                                            
                                                    </div>
                                                    <div class='col-lg-2'>
                                                        <label>Descripcion </label>                                         
                                                    </div>
                                                    <div class='col-lg-2'>
                                                        <label>Motivo </label>                                         
                                                    </div>
                                                    <div class='col-lg-2'>
                                                        <label>Aceptar/Rechazar</label>   
                                                    </div>
                                                    <div class='col-lg-4'>
                                                        <label>Observación</label>                                             
                                                    </div>

                                                </div>
                                            </div>";
                            
                                                $sql=("SELECT 
                                                        solicitud_accesorios_id,
                                                        solicitudes_accesorios_inventario.id as id,
                                                        solicitudes_accesorios_inventario.descripcion as descripcion,
                                                        solicitudes_accesorios_inventario.descripcion as apŕobado,
                                                        inventario.producto as producto,
                                                        motivos_reemplazo.motivo as motivo
                                                        FROM postventa_accesorios.solicitudes_accesorios_inventario 
                                                        join motivos_reemplazo on (motivos_reemplazo.id = solicitudes_accesorios_inventario.motivo_id)
                                                        join inventario on (solicitudes_accesorios_inventario.inventario_id = inventario.id)
                                                        where solicitud_accesorios_id = ".$idcaso.";");            
                                                        
                                                $accesorios = $this->con->query($sql,2);
                                                         
                                                        foreach ($accesorios as $nacc => $accesorios) {
                                                             
                                                             $html=$html."<div class='col-lg-12'>
                                                                            <div class='col-lg-2'>
                                                                                ".$accesorios['producto']."                                         
                                                                            </div>
                                                                            <div class='col-lg-2'>
                                                                                ".$accesorios['descripcion']."   
                                                                            </div>
                                                                             <div class='col-lg-2'>
                                                                                ".$accesorios['motivo']."   
                                                                            </div>
                                                                            <div class=' make-switch col-lg-2'>
                                                                            
                                                                                <input data-text=".$accesorios['id']."  class ='btnsw btn$idcaso' type='checkbox' data-off-color='danger' data-on-color='info' data-size='large' data-on-text='' data-off-text='' checked>  
                                                                            </div>
                                                                            <div class='col-lg-4'>
                                                                                <textarea class='txtarea' id=".$accesorios['id']." rows='2' cols='40'></textarea>  
                                                                            </div>
                                                                          </div>
                                                                          ";
                                                            };
                                                            
                                            
                            
                            $html = $html."</div>                       
                                                                    <div class='col-lg-12'>
                                                                        <div class='alert alert-warning' style='margin-left: 2%; margin-right: 2%;'role='alert'>
                                                                          <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                                                          <span class='sr-only'>Error:</span>
                                                                          Verifique los datos para poder procesar el caso, ya que no se podrá deshacer la accion...
                                                                          <a data-text='$idcaso' class='btnprocaso btn btn-info btn-lg'><i class='glyphicon glyphicon-ok'>Procesar</i></a>
                                                                        </div>
                                                                        <div style='margin-top:-1%;margin-bottom: 1%;margin-left: 2%;margin-right: 2%;' class='page-header'></div>
                                                                    </div>
                                                                    <div class='col-lg-12'>
                                                                            <div style='text-align: left;'>
                                                                                <label >DESPACHAR MERCANCIA:</label>
                                                                            </div> 
                                                                            <label >Indique hacia donde se van a despachar los accesorios</label>
                                                                            <div style='display: inline-block;' class='radio'>
                                                                              <label>
                                                                                <input type='radio' name='opciones' id='opciones_1' value='opcion_1' checked>
                                                                               ".$ofc['agencia']."
                                                                              </label>
                                                                            </div>
                                                                            <div style='display: inline-block;' class='radio'>
                                                                              <label>
                                                                                <input type='radio' name='opciones' id='opciones_2' value='opcion_2'>
                                                                                    Oficina Comercial 
                                                                                </label>
                                                                            </div>
                                                                            <div class='alert alert-success' style='margin-left: 2%; margin-right: 2%;'role='alert'>
                                                                              <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                                                              <span class='sr-only'>Error:</span>
                                                                              Verifique los datos para poder despachar los accesorios, ya que no se podrá deshacer la accion...
                                                                              <a class='btn btn-warning btn-lg'><i class='glyphicon glyphicon-shopping-cart'>Despachar</i></a>
                                                                            </div>
                                                                            <div style='margin-top:-1%;margin-bottom: 1%;margin-left: 2%;margin-right: 2%;' class='page-header'></div>

                                                                    </div>
                                                                    
                                                                       
                                                                        
                                    </div>
                                </div>
                            </div>";
                        }
                        
                $html = $html."</div></div>";
                if ($numeroCasos !=0)
                $htmlfinal = $htmlfinal.$html;
            }
            
             $result = array("respuesta"=>trim($htmlfinal),"evento"=>$action);
             $out = json_encode($result);
            
            echo $out;
        }
        
        
        public function ejecutar($sql,$evento){
     			
                        $res= $this->con->query($sql);
                        $respuesta = json_decode($res);
                        
                        if($respuesta->{'error'}){
                            
                            $result = array("respuesta"=>$respuesta,"evento"=>$evento);
                            
                        }   
                        else{
                            $result = array("respuesta"=>"Registrado","evento"=>$evento);
                        }
                        echo json_encode($result);
                        
     		
     		
        }
        public function numerodefilasAfectadas($sql,$evento){
           //$result=false;
     		try{
     			$result = $this->con->prepare($sql);
                        $result->execute();
     			return $result->rowCount();
                }
     		catch(PDOException $e){
     			return($e->getMessage()."\n<br>SQL:".$sql);
     		}
        }
}

?>