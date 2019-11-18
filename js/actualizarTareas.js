function agregarTarea(codigo){
    if (document.getElementById("nuevaTarea").value == "") {
        window.alert("no se puede ingresar");
      }else{
    var tarea=document.getElementById("nuevaTarea").value;
    console.log(codigo);
    console.log(tarea);

    var posicion=document.getElementById("tablaTareas").rows.length;
    posicion--;

    var f = new Date();
    var fechaString=f.getDate() + '-' + (f.getMonth() +1) + '-' + f.getFullYear();

    var contendor  = $("#listaTareas").html();
    var nuevaFila   = '<tr align="center" class="pendiente" id="fila'+posicion+'" >';
    nuevaFila   += '<td>'+tarea+'</td>';
    nuevaFila  += '<td>'+fechaString+'</td>';
    nuevaFila  += '<td>  <label><input type="checkbox" id="cbox1" onclick="alternarEstado('+posicion+','+codigo+')"> </label></td>';
    nuevaFila   += '</tr>';
    $("#listaTareas").html(contendor+nuevaFila);

    $.ajax({
        type:"get",
        url:"addTarea.php",
        data:{
            id:codigo,
            nombre:tarea
        },
        success:function()
        {
            alert("Tarea agregada");
        }
    })
}
    
}

function alternarEstado(posicion,codigo){   
    var estado;
    var idobject="fila"+posicion;
    var fila = document.getElementById(idobject);
    
    if(fila.classList.contains("completado")){
        fila.classList.remove('completado');
        fila.classList.add('pendiente');
        estado=0;
    }else{
        fila.classList.remove('pendiente');
        fila.classList.add('completado');
        estado=1;
    } 

    setEstadoJson(codigo, posicion, estado);
}	



function setEstadoJson(codigo,posicion,estado){
    $.ajax({
        type:"get",
        url:"setEstado.php",
        data:{
            id:codigo,
            position:posicion,
            status:estado
        },
        success:function()
        {
            if(estado==1){
                alert("Tarea completada");
            }else{
                alert("Tarea pendiente");
            }
        }
    })
}		