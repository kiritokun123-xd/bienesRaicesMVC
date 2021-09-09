<?php

namespace MVC;

class Router{
    
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }
    
    public function comprobarRutas(){
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null;
        }

        if($fn){
            // La URL existe y hay una funcion asociada
            call_user_func($fn, $this);
        }else{
            echo "Página No Encontrada";
        }
    }

    // mUESTRA UNA VISTA
    public function render($view){
        //inicia un almacenamiento en MEMORIA
        ob_start();
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";

    }
}