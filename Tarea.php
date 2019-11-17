<?php
class Tarea
{
    public $posicion=null;
    public $nombreTarea = null;
    public $fechaCreacion=null;
    public $estado = 0;

    function __construct(int $posicion,string $nombreTarea, string $fechaCreacion, int $estado){
        $this->posicion=$posicion;
        $this->nombreTarea = $nombreTarea;
        $this->estado = $estado;
        $this->fechaCreacion = $fechaCreacion;
    }
    

    public function getNombreTarea()
    {
        return $this->nombreTarea;
    }

    public function setNombreTarea($NombreTarea)
    {
        return $this->NombreTarea = $NombreTarea;
    }
    
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }
   
    public function setFechaCreacion($fechaCreacion)
    {
        return $this->fechaCreacion = $fechaCreacion;
    }

    public function getEstado()
    {
        return $this->estado;
    }
   
    public function setEstado($estado)
    {
        return $this->estado = $estado;
    } 
}
?>