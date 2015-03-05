function eventosgloblaes(){
     $(document).mousedown(function(){ 
                       window.top.$('.dropdown.open').removeClass('open');
                    });
    $(document).ready(function(){  
                $(document).bind("contextmenu", function(e){  
                    return false;  
                });  
            }); 
    
}
function procesarAccesrios(boton){
     
    alert(boton.attr('class'));
    //$(btnEmpleado).on("click",function () {
}
function selectAgencia(data){
    datos={};
    datos["action"]="obtenerCasosGenerales";
    datos["data"]=data[0];
    ajax(datos);
    
    
    $(".btnsw").bootstrapSwitch('state',false, true);
    $(".btnsw").bootstrapSwitch().on("switchChange.bootstrapSwitch", function (event, state) {
        //alert("Switch pressed");
        if(state){
            document.getElementById($(this).attr("data-text")).disabled = true;
        }
        else{
            document.getElementById($(this).attr("data-text")).disabled = false;        
        }
    });
    $('.bootstrap-switch-handle-on').attr("class", "glyphicon glyphicon-ok-sign bootstrap-switch-handle-on bootstrap-switch-info");
    $('.bootstrap-switch-handle-off').attr("class", "glyphicon glyphicon-remove bootstrap-switch-handle-on bootstrap-switch-danger");
    $('.btnprocaso').on("click",function () {
        idcaso = $(this).attr("data-text");
        ncasos = $($(".btn"+idcaso)).length;
        obsercaso = "";
        observacionesvacio=false;
                var accesorios=[];
                var caso={};
                var h=0;
                caso["action"]='procesarCaso';
                caso["idcaso"]=idcaso;
                
                for (i=0;i< ncasos;i++){
                   //console.log($($(".btn"+idcaso)[i]).bootstrapSwitch('state'));
                   $("#"+$($(".btn"+idcaso)[i]).attr("data-text")).attr( "style","");
                   if ($($(".btn"+idcaso)[i]).bootstrapSwitch('state')){
                        obsercaso = $("#"+$($(".btn"+idcaso)[i]).attr("data-text")).val();    
                        accesorios[i]=[true,$($(".btn"+idcaso)[i]).attr("data-text"),"1"];
                   
                   }
                   else{
                        obsercaso = $("#"+$($(".btn"+idcaso)[i]).attr("data-text")).val(); 
                        if(obsercaso.length<=7){
                            observacionesvacio=true;
                           $("#"+$($(".btn"+idcaso)[i]).attr("data-text")).attr("style",'border-color: red;border-width: 2px;')
                        }
                        accesorios[i]=[false,$($(".btn"+idcaso)[i]).attr("data-text"),obsercaso.replace(/^\s+|\s+$/gm,'')];
                   }
                }
                caso["accesorios"]=accesorios;
                /* for (j=0;j< accesorios.length;j++){
                    console.log(caso["accesorios"][j].length)
                }*/
                if (observacionesvacio){
                    alert("Las Observaciones para el accesorio rechazado debe contener al menos  caracteres, Complete los Campos en rojo.");
                }
                else{
                    if (confirm('¿Esta seguro que desea procesar este caso?, no se prodrá deshacer esta acción..')) {
                        // Save it!
                    } else {
                        // Do nothing!
                    }
                }
        //console.log(accesorios.length);
                                    
    }); 
}


function ajax(datos,tipodato){
    
    
       $.ajax({
        url     : "./BD/swtichprepared.php",
        async   : false,
        data    : datos,
        dataType: "JSON",
        type    :"post",
        error   : function(err,textStatus, jqXHR){///////Ya no debeira funcionar.......
          error= err;
           
          console.log(textStatus);
          console.log(jqXHR);
          console.log(err);
          //alert("Error");
        },
        success:function(resp, textStatus, jqXHR){
                    //console.log(resp) ;
          
                switch (resp.evento) {
                 
                 case "guardar":
                   
                     if (resp.respuesta.error){
                            console.log(resp.respuesta);
                        if (resp.respuesta.codeerror==23505){
                            alert("Ya este registro Existe");
                            break;
                        }
                        alert("Error..");
                        break;
                     }
                     else{
                        //console.log(resp) ;
                        if ($("#tablaEstadosActividades").children().length > 0) {              
                            $("#tablaEstadosActividades").dataTable().fnClearTable();
                            $("#tablaEstadosActividades").dataTable().fnDestroy();
                            $("#tablaEstadosActividades thead > tr >  th").hide();
                        }   
                        cargarTablas("obtenerEstados", "", "#tablaEstadosActividades", null, [0],"./Clases/modelEstadosActividad.php");
                        alert("Registrado Exitosamente..");
                     }
                    
                        break;
                case "obtenerCasosGenerales":
                        $("#agentes").html("")
                        if (resp.respuesta.length==0){
                            console.log(resp.respuesta);
                            $("#sincasos").show();                            
                        }else{
                            $("#sincasos").hide();  
                            $("#agentes").html(resp.respuesta);
                        }
                        
                    
                        break;
                default:
                        break;
                }
                
                if (resp.hasOwnProperty("Materiales")){
                   $.each(resp.Materiales,function(key,val){
                       // console.log(key+"->"+val);
                        $("#tipo_mat").append("<option data-text="+val+" value="+key+">"+val+"</option>");
                   });   
                   $("#tipo_mat").append("<option value=-1 >AGREGAR TIPO</option>");
                }
        }
    });
}  