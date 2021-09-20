<?php

namespace Controllers;

use Model\Vendedor;
use MVC\Router;

class VendedorController{
    public static function crear(Router $router){
        $vendedor = new Vendedor();

        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vendedor = new Vendedor($_POST['vendedor']);
    
            //validar que no haya campos vacios
            $errores =  $vendedor->validar();
    
            //No hay errores
            if(empty($errores)){
                //Sube BD
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear',[
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);

    }
    public static function actualizar(Router $router){

        $id = validarORedireccionar('/admin');

        $errores = Vendedor::getErrores();

        $vendedor = Vendedor::find($id);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Asiganr los valores 
            $args = $_POST['vendedor'];
            // Sincronizar objeto en memoria
            $vendedor->sincronizar($args);
            //validar 
            $errores = $vendedor->validar();
            
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }
    public static function eliminar(){
        $vendedor = new Vendedor();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            

            if($id){
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    $propiedad = Vendedor::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}

