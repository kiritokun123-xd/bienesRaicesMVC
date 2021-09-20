<?php
define('TEMPLATES_URL', __DIR__.'/templates');
define('FUNCIONES_URL',__DIR__.'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function estadoAutenticado(){
    session_start();

    if(!$_SESSION['login']){
        header('Location: /');
    }
}

function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    
    echo "</pre>";
    exit;
}

//Escapa / Sanitizar el HTML
function s($html) : string{
    $s= htmlspecialchars($html);
    return $s;
}

//Validar tipo de Contenido
function validarTipoContenido($tipo){
    $tipos = ['propiedad','vendedor'];

    return in_array($tipo,$tipos);
}

// Muestra los mensajes

function mostrarNotificacion($codigo){
    $mensajes = '';

    switch($codigo){
        case 1:
            $mensajes = 'Creado Correctamente';
            break;
        case 2:
            $mensajes = 'Actualizado Correctamente';
            break;
        case 3:
            $mensajes = 'Eliminado Correctamente';
            break;
        default:
            $mensajes = false;
            break;
    }
    return $mensajes;
}

function validarORedireccionar(string $url){
    //VALIDAR LA URL POR ID VALIDO
    $id = $_GET['id'];
    $id =filter_var($id, FILTER_VALIDATE_INT);
    

    if(!$id){
        header("Location: ${url}");
    }
    return $id;
}