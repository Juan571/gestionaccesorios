
var bPaginate = true ;
var bScrollCollapse= false;
var sScrollY= null;
var searching = true;
var bLengthChange =true;
var bSort = true ;
var iDisplayLength  = 10 ;
var cambiarDiseno = {};

 /*
var cambiarDiseno['tamano'];
var cambiarDiseno['bPaginate'];
var cambiarDiseno['bScrollCollapse'];
var cambiarDiseno['searching'];
var cambiarDiseno['bLengthChange'];
var cambiarDiseno['iDisplayLength'];
*/

function crearTh(datos,tabla){
  var tabla=tabla;
  var classOpc ="indice";
  var indice=null;
          $(tabla).html("<thead><tr class=\"rowtabla\">");
          tabla+=" thead tr";
          $.each(datos,function(k,v){ 
              var th = $("<th>",{
                  css:{
                    "padding-left":"4px",
                    "padding-right":"4px",
                    "padding-bottom":"4px",
                    "padding-top":"4px",
                  },
                  html : v
              });
              if(k===indice){
                $(th).addClass(classOpc);
              }
              $(tabla).append(th);
        //    $(tabla).append("<th style=\"padding-left: 4px;padding-right: 4px;padding-top: 2px;padding-bottom: 2px;\">"+v+"</th>");
          });
          $(tabla).append("<th>Accion</th>");
         }

function cargarTablas(action,data,tabla,cambiarDiseno,columnasvisibles,url,urlIdioma){
  var header=[];
   datos = {
               action          : action, 
               data            : data
          }
  var tabla=tabla;
  if(urlIdioma==null){
    urlIdioma="./";
  }else{
    urlIdioma="../";
  }
 if(url==null){
    dir="./BD/swtichprepared.php";
  }else{
    dir=url;
  }

  $.ajax({
            url:dir,
            data:datos,
            dataType:"json",
            type:"POST",
            async :true,
            error:function(req,err){
              console.log(req);
              $(tabla).hide();
             },
            success: function(resp) {
              var data =[];
              var data2=[];
              var ih=0;
              var op=0;
              var datostr=[];
              if(resp.length==0){
                
                switch (tabla){
                    case "#tablaUsuariosConsultaMorosos":
                         $(".colmorosos").hide();
                    break;
                    
                }

                return 0;
              }
              Keys = Object.keys(resp[0]);
              var cont=0;
              Keys.map(function(v){
                   Keys[cont]=v.charAt(0).toUpperCase()+v.slice(1);
                   cont++;
              })
              cont=0;
              crearTh(Keys,tabla);//Añadir Thead a la Tabla, con los object Key obtenidos

                $.each(resp, function (ix, itemx) {
                 op++;
                 data=[];        
                 $.each(itemx, function (ixx, itemxx) {
                    ih++;
                    data.push(itemxx);
                 });
              data2[ix]=data;//creo el array con el array del tr dentro..
              ih=0;
              });
                  //console.log(data);
                if(cambiarDiseno!=null){
                      sScrollY  = cambiarDiseno['tamano'];
                      bPaginate = cambiarDiseno['bPaginate'];
                      bScrollCollapse = cambiarDiseno['bScrollCollapse'];
                      searching = cambiarDiseno['searching'];
                      bLengthChange = cambiarDiseno['bLengthChange'];
                      iDisplayLength = cambiarDiseno['iDisplayLength'];
                      bJQueryUI: cambiarDiseno['bJQueryUI'];
                      //bSort = cambiarDiseno['bSort'];
                }
                else{
                   bJQueryUI: true,
                   bPaginate = true ;
                   bScrollCollapse= false;
                   sScrollY= "";
                }

              $(tabla).dataTable( {
                "bRetrieve" :true,
                "bJQueryUI": true,
                "iDisplayLength": iDisplayLength ,
                "bSort" :"true",
                "sScrollY": sScrollY,
                "bScrollCollapse": bScrollCollapse,
                "bPaginate":bPaginate,
                "searching": searching,
                "bLengthChange": bLengthChange,
                "data": data2,
                "bJQueryUI":false,
                //"async": false,
                "oLanguage" : {                   
                  "sUrl": urlIdioma +"dataTables/spa_SPA.txt"
                },          
                "aoColumnDefs": [
                    {
                        "aTargets": [-1],
                        "mData": null,
                        "sDefaultContent" :"<button style='padding:3px'class='botonRow  btn btn-primary '>Editar</span></button>",
                        "mRender": function (data, type, full) {
                        }
                  }, 
                  {
                      "targets": columnasvisibles,
                      "visible": false,
                      "searchable": false
                  }  
                ],
                    
                "fnRowCallback":function( nRow, aData, iDisplayIndex, iDisplayIndexFull ){
                          
                             
                          if(tabla==="#tabla_ofc"){
                             var boton = $(nRow).find(".botonRow");
                                 var btnEmpleado = $(nRow).find(".botonRow");
                                 $(btnEmpleado).removeClass("btn-primary").html("<span class='icon-ok'>Ver Detalles</span>");
                                 $(btnEmpleado).addClass(" btn-info");
                                 $(btnEmpleado).off();// Se elimina el Evento anterior 
                                 $(btnEmpleado).on("click",function () {
                                    $(nRow).removeClass("selected");
                                    //alert("VER DETALLES xD");
                                    selectAgencia(aData);
                                 }); 
                                 $(btnEmpleado).parent().attr('style','text-align:center');
                          } 
                },

                "fnDrawCallback": function () {
                     var tabla1 = $(tabla).DataTable();
                     var cadenatabla = tabla + " tbody";
                     $(cadenatabla).on( 'click', 'tr', function () {
                         if ( $(this).hasClass('selected') ) {
                          }
                         else {
                           tabla1.$('tr.selected').removeClass('selected');
                           $(this).addClass('selected');
                          }  
                     }); 
                 }
                //aoColumns..
              });  // datatable 
              }//succes
});//ajax
}
