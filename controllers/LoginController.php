<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {

    public static function login(Router $router){

        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            
            $alertas = $auth->validarLogin();
            
            if(empty($alertas)){
                // comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario){

                    // verificar que este confirmado y el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        // autenticar el usuario
                        // creamos una sesion con la informacion que creemos necesaria
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // redireccionamiento segun el cargo
                        if($usuario->admin === '1'){
                            // si es admin se le agrega  la sesion esa bandera
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('location: /admin');
                        } else {
                            header('location: /cita');
                        }
                        
                    }


                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);

    }

    public static function logout(){
        session_start();

        $_SESSION = [];

        header('location: /');

    }
    
    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === '1') {

                    // generar token un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();

                    // enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // alerta
                    Usuario::setAlerta('exito', 'Revisa tu email');


                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // buscar usuario pór el token
        $usuario = Usuario::where('token', $token);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // leer el nuevo passwords

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;

                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado) {
                    header('location: /');
                }
            }
        }

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);

    }

    public static function crear(Router $router){

        $usuario = new Usuario;

        // alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // revisar que alertas este vacio
            if(empty($alertas)){
                // verificar que el usuario no exista en la db
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    
                    // hashear la password
                    $usuario->hashPassword();

                    // generar un token unico
                    $usuario->crearToken();

                    // enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('location: /mensaje');
                    }
                }
            }

        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' =>$alertas
        ]);

    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje',[]);
    }

    public static function confirmar(Router $router){

        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // mostrar error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // modificar el usuario confirmado
            $usuario->confirmado = '1';
            $usuario->token = '';
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
            
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}