<?php

namespace Model;

class AdminCita extends ActiveRecord {

    protected static $tabla = 'citasservicios'; // usar la tabla que tiene mas campos relacionados
    protected static $columnasDB = ['cliente', 'email', 'telefono', 'id', 'hora', 'servicio', 'precio'];

    public $cliente;
    public $email;
    public $telefono;
    public $id;
    public $hora;
    public $servicio;
    public $precio;

    public function __construct($args = []) {
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

}