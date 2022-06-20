<?php
function carga($nombre_clase){

$clase = explode('\\', $nombre_clase);

$file = "";

if ($clase[0] === 'model') {
    $file = __DIR__. DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $clase[1] . '.php';
} else if ($clase[0] === 'view') {
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $clase[1] . DIRECTORY_SEPARATOR . $clase[2] . '.php';
} else {
    $file = __DIR__. DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $clase[1] . '.php';
}

if ($file != "") {
    // Comprobamos si el fichero existe
    if (file_exists($file)) {
        // Si existe incluimos el fichero
        include $file;
    }
}
}

spl_autoload_register("carga");