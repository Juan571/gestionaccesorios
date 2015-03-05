<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="http://rec.vtelca.gob.ve/img/favicon.ico" />

        <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap/3.1.1/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./dataTables/media/css/jquery.dataTables.css">

        <link rel="stylesheet" type="text/css" href="./JS/jqueryUI/css/blitzer/jquery-ui-1.10.4.custom.css">    
        <script src="http://rec.vtelca.gob.ve/jquery/2.1.1/jquery.min.js"></script>
        <script src="http://rec.vtelca.gob.ve/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="http://rec.vtelca.gob.ve/bootstrap-select/1.6.0/dist/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="./JS/tablas.js"></script>
        <script type="text/javascript" src="./JS/funcionesGestion_Casos.js"></script>

        <script src="http://rec.vtelca.gob.ve/datatables/1.10.2/media/js/jquery.dataTables.min.js"></script>
        <script src="http://rec.vtelca.gob.ve/bootstrap-switch/master/js/bootstrap-switch.min.js"></script>
        <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap-switch/master/css/bootstrap3/bootstrap-switch.min.css">

        <title>Gestion de Casos</title>
        <style>
            header   {
                width: calc(100% - 10px);
                height: 60px;
                background: url(http://rec.vtelca.gob.ve/img/cintillo-i.png) left no-repeat, 
                    url(http://rec.vtelca.gob.ve/img/cintillo-c.png) center no-repeat, 
                    url(http://rec.vtelca.gob.ve/img/cintillo-d.png) right no-repeat;
                background-color: #fff;
                background-size: auto 40px;
                margin: 5px;
            }
            label,p {
                display: inline-block;
            }
            footer {
                width: calc(100% - 10px);
                height: 60px;
                background: url(http://rec.vtelca.gob.ve/img/pie-pagina.png) center no-repeat;
                background-color: #fff;
                background-size: auto 40px;
                margin: 5px;
            }
            .page-header{
                margin-bottom: 0%;
                margin-top: 0%;
            }
            .selectpicker {
                width:100%; 
                height: 34px;
            }
            .row {
                margin-bottom: 10px;
            }
            table {
                border-collapse:collapse;
                width: 100%
            }
            tr{
                border: 1px solid #000;
            }
            #imgTlf {
                width: 100%;
            }

            h1,  h3, h4 {

                text-align: center;
            }
            td, th {
                text-align: center;
            }
            #cvs {
                border: 1px solid #000;
            }
            .panel-heading a:after {
                font-family:'Glyphicons Halflings';
                content:"\e114";
                float: right;
                color: grey;
            }
            .panel-heading a.collapsed:after {
                content:"\e080";
            }
            @media all and (max-width: 800px) {
                #cabecera {
                    background: url(http://rec.vtelca.gob.ve/img/cintillo-i.png) left no-repeat,
                        url(http://rec.vtelca.gob.ve/img/cintillo-c.png) right no-repeat;
                    background-color: #fff;
                    background-size: auto 40px;
                }
            }
            @media all and (max-width: 479px) {
                #cabecera {
                    background: url(http://rec.vtelca.gob.ve/img/cintillo-c.png) center no-repeat;
                    background-color: #fff;
                    background-size: auto 40px;
                }
                h1 {
                    font-size: 3rem;
                }
                h2 {
                    font-size: 2.5rem;
                }
                h3 {
                    font-size: 2rem;
                }
                h4 {
                    font-size: 1.5rem;

                }

            }
        </style>
        <script>
            $(document).ready(function () {
                cargarTablas("obtenerAgencias", "", "#tabla_ofc", null, [0,2,3],"./BD/swtichprepared.php");
                
                // $('.bootstrap-switch-handle-on').attr("text","");
            });
        </script>
    </head>
    <body>
        <div class="container">
            
            <header></header>
            <h1>Gestión de Casos</h1>
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <h4 style='text-align: left'> <strong>Seleccione la Oficina Comercial </strong> Seleccione Oficina Comercial</h4>
                </div>

                <div class='panel-body'>
                    <table id="tabla_ofc" class="display">

                    </table>                          
                </div>
            </div>

            <div style="" class="panel panel-default" align="center">
                <div style="text-align: left" class="panel-heading">
                    <h4 style='text-align: left'> <strong>Agentes autorizados Asociados a la Oficina Comercial</strong> Seleccione el Caso.</h4>
                </div>
                <div id="agentes" class="panel-body">
                    
                    <div id='selccioneOfc' class='alert alert-warning' style='margin-left: 2%; margin-right: 2%;'role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Atención:</span>
                            Seleccione una Oficina Comercial, para obtener los casos..
                    </div>
                    
                </div>
                <div id='sincasos' class='alert alert-success' style='display:none; margin-left: 2%; margin-right: 2%;'role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Atención:</span>
                            Esta Oficina no Tiene Casos Pendientes..
                </div>

            </div>

        </div>


    </body>
</html>
