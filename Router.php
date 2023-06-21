<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {

        session_start();

        $auth = $_SESSION['login'] ?? null;

        // arreglo de rutas protegidas
        // $rutas_protegidad = [
        //     '/admin', 
        //     '/propiedades/crear',
        //     '/propiedades/crear',
        //     '/propiedades/actualizar',
        //     '/propiedades/actualizar',
        //     '/propiedades/eliminar',
        //     '/vendedores/crear',
        //     '/vendedores/crear',
        //     '/vendedores/actualizar',
        //     '/vendedores/actualizar',
        //     '/vendedores/eliminar'
        // ];
        
        $urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo  === 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
        
        // proteger las rutas
        // if(in_array($urlActual, $rutas_protegidad) && !$auth) {
        //     header('location: /');
            
        // }

        if($fn){
            // la url existe y hay una funcion asociada
            call_user_func($fn, $this);
        } else {
            echo "Pagina no encontrada";
        }

    }

    // mostrar vistas
    public function render($view, $datos = []) {

        // arreglo siempre usar foreach
        foreach($datos as $key => $value){
            $$key = $value;
        }

        ob_start(); //almacenamiento en memoria durante un tiempo
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); //limpia el buffer

        include __DIR__ . "/views/layout.php";

    }

}
