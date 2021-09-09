<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;

class PropiedadController{
    public static function index(Router $router){
        $propiedades = Propiedad::all();

        $router->render('propiedades/admin',[
            //Datos...
            'propiedades' => $propiedades
        ]);
        
    }
    public static function crear(){
        echo "crear";
    }
    public static function actualizar(){
        echo "actualizar";
    }
}
