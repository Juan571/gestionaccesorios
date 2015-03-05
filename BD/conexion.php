<?php
    /**
    * 
    * En este archivo se encuentra la Clase conexion con metodos necesarios para conexion a Base de Datos
    *
    * @author Juan Romero  <jromero@vtelca.gob.ve>
    * @copyright 2014
    * @subpackage BibilioVtelca
    * @version 1
    */
    require_once('parametrosBD.php');
 
    /**
     * Clase Conexion derivada de PDO, contiene metodos  para realizar consultas a BD 
     * los atributos privados se deben definir en parametrosBD.php
     */
    class conexion extends PDO{
        /**
        * @var  string  $host contiene la direccion IP del servidor de la BD , Los atributos de conexion, deben  definirse en el archivo parametrosBD.php
        * @var  array  $opciones utilizada para establecer los atributos de la conexion a la BD
        * @var  PDOStatementObject  Objeto que contiene atributos y metodos resultantes de una consulta preparada de PDO
        */
        private $host = NULL;
        private $SGBD = NULL;
        private $BD = NULL;
        private $usuario = NULL;
        private $contrasena = NULL;
        private $stmt;
        private $conn;
        private $opciones; 
        /**
         * Contructor de la clase Modulos, permite crear una conexion
         *  persistente con la base de inventario o de sigesp, 
         *  de acuerdo al valor del parametro de la funcion
         * @since 1.0
         * @param boolean $sigesp Variable para validar la conexion a sigesp
         */

        public function __construct($sigesp=false){
            if($sigesp){
                 $this->host = host_sigesp;
                 $this->SGBD = SGBD_sigesp;
                 $this->BD = BD_sigesp;
                 $this->usuario = usuario_sigesp;
                 $this->contrasena =  contrasena_sigesp;

            }else{
                 $this->host = host;
                 $this->SGBD = SGBD;
                 $this->usuario = usuario;
                 $this->contrasena = contrasena;
                 $this->BD = BD;
            }
             $opciones = array(PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION);               
             try {   
               
                 $this->conn = new PDO("mysql:host=$this->host;port=3309;dbname=$this->BD",$this->usuario,$this->contrasena);
                $this->conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn ->exec("set names utf8");
                }catch(PDOException $e){
                    echo "ERROR: " . $e->getMessage();
            }
       }
        /**
         * Funcion para Comenzar una transaccion, utilizando PDO
         *  
         * */
        public function beginTransaction(){
            return $this->conn->beginTransaction();
        }
        /**
         * Metodo para deshacer los cambios en una transaccion 
         *  
         * */
        public function rollBack(){
            return $this->conn->rollBack();
        }
        /**
         * Funcion para realizar commit de una transacion
         *  
         * */
        public function commit(){
            return $this->conn->commit();
        }

        /*
        public function desconectar () {
            $this->conn = null ; 
        }
        */
        /**
         * Metodo para obtener la cantidad de registros de una consulta
         * @since 1.0
         * @param string $query Variable que debe contener la sentencia SQL.
         */
        public function ver_num_registros($query){
            $csl = $this->conn->prepare($query);
            if($csl){
                    $csl->execute();
                    //$this->csl;
                    return $csl->rowCount();
            } 
            else{
                return self::get_error();
            }
        }
         /**
         * Funcion para obtener Errores producidos en una consulta
         * @since 1.0
         * @return array 
         */
        public function ver_error(){
            return $this->connection->errorInfo();
        }
          /**
         * Metodo para ejecutar consultas SQL, 
         * @since 1.0
         * @param string $qry debe contener la sentencia SQL.
         * @param integer $param Variable para determinar el tipo de arreglo resultante
           <ul>
              <li> 1 : Arreglo Indexado   </li>
              <li> 2 : Arreglo Asociativo </li>
           </ul>
         * @param boolean $getJSON  opcional para obtener resultado en  formato JSON, 
         *       si se  desean recibir el resultado en formato JSON se recomienda implementar $param=2 en los parametros
         *
         */
        public function query($qry,$param=NULL,$getJSON=false){
            $tipoFetch = 2 ; 
            if(isset($param)){
                                $tipoFetch = $param;
              }                        
            try{
                if($getJSON){
                    $array = array();
                    $res = $this->conn->query($qry, $tipoFetch);
                    foreach ($array as $row => $value) {
                        $array[] = $value;
                    }
                  
                    return json_encode($array);
                }else{
                $res = $this->conn->query($qry, $tipoFetch);
                 /* if($usuario->getTipo_usuario()!=="S"){
                      die(json_encode(array("respuesta"=>"declinado","estado"=>false,"mensaje"=>"No  posee los privilegios Suficientes")));
                    }else{
                        return $res;
                    }
                 */
               // $arr=array("error"=>false,respuesta=>"exito");
                return $res;
                }
            }
            catch(PDOException $e){
                $error = $e->getMessage();
                $codeerror = $e->getCode();
                $respuesta = array("mensaje"=>$error,"error"=>true,"codeerror"=>$codeerror);
                return (json_encode($respuesta));
            }
        }

        /**
         * Funcion para realizar una Consulta Preparada
         * @param string $sql debe contener la sentencia SQL a preparar
         * @return Object Objeto con metodos y atributos de PDO Prepare Statement
         * */
        public function prepare($sql,$options=NULL){
            $this->stmt = $this->conn->prepare($sql);
            return $this->stmt;
        }
         /**
         * Funcion para Ejectuar una Consulta Preparada
         * */
        public function execute(){
            $this->stmt->execute();
        }
        /**
         * Funcion para obtener el ultimo id Insertado en una tabla en la BD
         * @param string $seqname Debe contener nombre de la secuencia (aplicable a postgres)
         * @return string  Cadena que contiene ultimo ID insertado
         * 
         * 
         * */      
        public function lastInsertId($seqname = NULL){
            return $this->conn->lastInsertId($seqname);
        }
    }