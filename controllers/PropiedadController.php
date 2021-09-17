<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{
    public static function index(Router $router){
        
        $propiedades = Propiedad::all();
        //MUESTRA MENSAJE CONDICIONAL
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin',[
            //Datos...
            'propiedades' => $propiedades,
            'resultado' => $resultado
        ]);
        
    }
    public static function crear(Router $router){

        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();
         //ARREGLO CON MENSAJES DE ERRORES
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            /*CREA UNA NUEVA INSTANCIA*/
        $propiedad = new Propiedad($_POST['propiedad']);

        //GENERAR UN NOMBRE UNICO
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        //SETEAR LA IMAGEN
        //realiza un RESIZE A LA IMAGEN CON INTERVENTION
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        /*VALIDAR*/
        $errores = $propiedad->validar();

        //REVISAR QUE EL ARREGLO DE ERRORES ESTE VACIO
        if(empty($errores)){
            //crear la carpeta imagenes
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //GUARDA LA IMAGEN EN EL SERVIDOR
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //SUBE A LA BD
            $propiedad->guardar();
        }
        }

        $router->render('propiedades/crear',[
            //Datos...
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router){
        
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);

        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        $router->render('/propiedades/actualizar',[
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]); 
    }
}
