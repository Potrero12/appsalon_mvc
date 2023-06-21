<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {

    public static function index(Router $router){

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('location: /404');
        }

        // consultar la bd
        $consulta = "SELECT concat(u.nombre, ' ', u.apellido) as 'cliente', ";
        $consulta .= " u.email, u.telefono, c.id, c.hora, s.nombre as 'servicio', s.precio ";
        $consulta .= " FROM citas c ";
        $consulta .= " LEFT OUTER JOIN usuarios u ";
        $consulta .= " ON u.id=c.usuarioId ";
        $consulta .= " LEFT OUTER JOIN citasservicios cs ";
        $consulta .= " ON cs.idCitas=c.id ";
        $consulta .= " LEFT OUTER JOIN servicios s ";
        $consulta .= " ON s.id=cs.idServicio ";
        $consulta .= " WHERE c.fecha='$fecha' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);

    }

}