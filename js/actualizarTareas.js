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