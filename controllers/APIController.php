<?php

namespace Controllers;

use Model\Cita;
use Model\CitasServicio;
use Model\Servicio;

class APIController {
    public static function index() {

        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() {

        // almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];

        // almacena las citas y los servicios
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio) {
            $args = [
                'idCitas' => $id,
                'idServicio' => $idServicio
            ];
            $citaServicio = new CitasServicio($args);
            $citaServicio->guardar();
        };

        echo json_encode(['resultado' => $resultado]);

    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}