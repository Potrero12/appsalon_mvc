<?php

namespace Model;

class CitasServicio extends ActiveRecord {

    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'idServicio', 'idCitas'];

    public $id;
    public $idServicio;
    public $idCitas;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->idServicio = $args['idServicio'] ?? '';
        $this->idCitas = $args['idCitas'] ?? '';
    }
}
