<?php
    $ruta="json/".$_GET['id'].".json";
    $jsonString = file_get_contents($ruta);
    $data = json_decode($jsonString, true);
    
    foreach ($data as $key => $entry) {
        if ($entry['posicion'] == $_GET['position']) {
            $data[$key]['estado'] = $_GET['status'];
        }
    }

    $newJsonString = json_encode($data);
    file_put_contents($ruta, $newJsonString);
?>