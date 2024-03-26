<?php

$tmpDir = __DIR__ . "\\..\\..\\tmp\\";
$logs_folder = __DIR__ . "\\..\\..\\logs\\";

date_default_timezone_set('America/Santiago');

function crearDirectorioSiNoExiste($directorio) {
    if (!is_dir($directorio)) {
        if (!mkdir($directorio, 0777, true)) {
            return false;
        }
    }
    return true;
}

function escribirLog($mensaje) {
    $fecha_hora_file = date('d-m-Y');
    $fecha_hora = date('d-m-Y H:i:s');
    global $logs_folder;
    $logs_day_folder = $logs_folder . $fecha_hora_file . "/";
    
    $mensaje = "\n$fecha_hora $mensaje";
    file_put_contents($logs_day_folder . "log_$fecha_hora_file.log", $mensaje, FILE_APPEND);
    echo $mensaje;
}

escribirLog("[DEBUG] tmp folder: $tmpDir");
escribirLog("[DEBUG] logs folder: $logs_folder");

if (!crearDirectorioSiNoExiste($logs_folder)) {
    escribirLog("[ERROR] No se pudo crear el directorio de logs.");
    exit;
}

function limpiarArchivosTemporales($dir) {
    $totalArchivos = 0;
    $totalCarpetas = 0;

    if (!is_dir($dir)) {
        return array(0, 0);
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $fileinfo) {
        if ($fileinfo->isDir()) {
            rmdir($fileinfo->getRealPath());
            $totalCarpetas++;
        } else {
            unlink($fileinfo->getRealPath());
            $totalArchivos++;
        }
    }

    return array($totalArchivos, $totalCarpetas);
}

while (true) {
    $fecha_hora_file = date('d-m-Y');
    $logs_day_folder = $logs_folder . $fecha_hora_file . "/";

    if (!crearDirectorioSiNoExiste($logs_day_folder)) {
        escribirLog("[ERROR] No se pudo crear el directorio de los logs del día.");
        exit;
    }

    list($archivosEliminados, $carpetasEliminadas) = limpiarArchivosTemporales($tmpDir);

    if ($archivosEliminados == 0 && $carpetasEliminadas == 0) {
        escribirLog("[INFO] No hay elementos que limpiar en la carpeta temporal.");
    } else {
        escribirLog("[INFO] Se han eliminado $archivosEliminados archivos y $carpetasEliminadas carpetas de la carpeta temporal.");
    }

    sleep(300);
}
?>