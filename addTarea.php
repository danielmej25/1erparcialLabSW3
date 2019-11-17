<?php
    include 'Tarea.php';

    $fechaActual = date('d-m-Y');
    $posicion=0;
    $ruta="json/".$_GET['id'].".json";

    $jsonString = file_get_contents($ruta);
    $data = json_decode($jsonString,TRUE);
    
    
    foreach ($data as $key => $entry) {
        if ($entry['posicion'] > $posicion) {
            $posicion=$entry['posicion'];
        }
    }
    $posicion=$posicion+1;
    //se agrega
    $data[] = ['posicion' => $posicion, 'nombreTarea' => $_GET['nombre'],'fechaCreacion'=>$fechaActual,'estado'=>0];

    $newJsonString = json_encode($data);
    file_put_contents($ruta, $newJsonString);

?>