<!DOCTYPE html>
<?php 
    include 'Tarea.php';
    function crearArchivoJson($codigo){
        $fechaActual = date('d-m-Y');
        $serFeliz=new Tarea(0,"Ser Feliz",$fechaActual,0);
        $planearSemana=new Tarea(1,"Planear Semana",$fechaActual,0);

        $tareasPredefinidas="[".json_encode($serFeliz).",".json_encode($planearSemana)."]";

        $ruta ="json/";
        $file =$ruta.$codigo.".json";
        file_put_contents($file, $tareasPredefinidas);
        ?>
        <div class='alert alert-success'>
            <button class='close' data-dismiss="alert"><span>&times;</span></button>
            <strong>Felicidades!</strong> Se ha creado tu cuenta con exito
        </div>
        <?php
    }
    function buscarArchivoJson($codigo){

        $existe=FALSE;
        $host= $_SERVER["HTTP_HOST"];
        $path  = '../danielmejSW3/json/';
        //obtengo todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        //recorro files para buscar
        foreach($files as $filed){
            // Hago un split(explode) que divide el nombre del archivo en dos nombre.extension nombre-> data[0] && extension->data[1]
            $data = explode(".", $filed);
            // Nombre del archivo
            if(!empty($data[1])){
                $nombreArchivo      = $data[0];
                // Extensión del archivo 
                $extension = $data[1];

                if($extension == 'json' ){
                    if($codigo == $nombreArchivo){
                    $existe=TRUE;
                    break;
                    }
                }
            }
        }        
        return $existe;
    }
    function cargarTareasJson($codigo){
        //Verifico si el archivo existe
        if(buscarArchivoJson($codigo)==FALSE){
            crearArchivoJson($codigo);
        }

        //Se deserealiza el json
        $json = file_get_contents('./json/'.$codigo.'.json');
        $tareas=json_decode($json);
        return $tareas;
    }
    function mostrarTareas($codigo){
        //Cargo las tareas en un array
        $tareas=cargarTareasJson($codigo);       
        

        if($tareas==NULL){
            ?>
            <div class='alert alert-success'>
                <button class='close' data-dismiss="alert"><span>&times;</span></button>
                Lista de tareas vacia
            </div>
            <?php
        }else{
            ?> <center>
                <table id="tablaTareas" class="tarea"> 
                    <tr  align="center">
                        <th>Nombre</td>
                        <th>Creada</td>
                        <th>Estado</td>
                    </tr> <tbody id="listaTareas"><?php
            $i=0;
            
            while($i<count($tareas)){ 
                $var=$tareas[$i]; 
                $estado="pendiente";
                $cbxstate="";
                if(($var->estado)==1){
                    $estado="completado";
                    $cbxstate="checked";
                }
                ?> <tr  id ="fila<?php echo $i ?>"align="center" class="<?php echo $estado?>"> <?php
                    echo '<td>'.$var->nombreTarea.'</td>';
                    echo '<td>'.$var->fechaCreacion.'</td>';
                    
                    ?>
                        <td>
                            <label><input type="checkbox" id="cbox<?php echo $i ?>" onclick="alternarEstado(<?php echo $i.','.$_POST['codigo'] ?>)"<?php echo $cbxstate?>> </label>
                        </td>
                    <?php
                    
                                     

                echo '</tr>' ;
                $i++;          
            }


            ?> </tbody></table> </center><?php
        }
    }  
?>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--Css propios-->
    <link rel="stylesheet" href="css/estilos.css"/> 
    <!-- JQuery -->
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- javaScript-->
    <script src="js/actualizarTareas.js"></script>
    <title>Su lista de tareas</title>    

</head>
<body>
    <div>
        <center>
            <h1>Lista de Tareas por Hacer</h1>
        </center>
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#lista">Lista</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#ayuda">Ayuda</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#acercade">Acerca De</a>
            </li>
            <!-- No funciona el cerrar sesion-->
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="index.html">Cerrar Sesión</a>
            </li>
        </ul>

        <center>
            <h2>Usuario <?php echo $_POST['codigo']?><h2>
        </center>
        

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Formulario para el ingreso-->
        <div id="lista" class="container tab-pane active justify-content-center"><br>
            <div class="col-lg-8 mx-auto">
                
                <center>

                    <input type="text" class="form-control" id="nuevaTarea">
                    <br>
                    <button class="btn btn-secondary" type="submit" onclick="agregarTarea(<?php echo $_POST['codigo'] ?>)">Agregar Tarea</button>
                    
                </center>
                <br>
                <h2>Toda las tareas: </h2>
                <?php 
                    mostrarTareas($_POST['codigo']);                    
                ?>       
            </div>
            
        </div>
        
        <!-- Seccion de Ayuda-->
        <div id="ayuda" class="container tab-pane fade"><br>
        <h3>Ayuda</h3>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>

        <!-- Seccion Acerca De-->
        <div id="acercade" class="container tab-pane fade "><br>
        <h3>Acerca De</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>

    </div>

</body>