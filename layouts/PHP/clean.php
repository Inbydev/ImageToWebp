<?php

$tmpDir = "../../tmp/";
$logs_folder = "../../logs/";


if (!is_dir($logs_folder)) {
    if (!mkdir($logs_folder, 0777, true)) {
        $mensaje = "\n$fecha_hora [ERROR] No se pudo crear el directorio de logs.";
        file_put_contents($log_day_folder . "log_$fecha_hora_file.log", $mensaje, FILE_APPEND);
        echo $mensaje;
        exit;
    }
}

date_default_timezone_set('America/Santiago');

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
    $fecha_hora = date('d-m-Y H:i:s');
    $fecha_hora_file = date('d-m-Y');

    $log_day_folder = $logs_folder . date('d-m-Y') . "/";

    if (!is_dir($log_day_folder)) {
        if (!mkdir($log_day_folder, 0777, true)) {
            $mensaje = "\n$fecha_hora [ERROR] No se pudo crear el directorio de logs.";
            file_put_contents($log_day_folder . "log_$fecha_hora_file.log", $mensaje, FILE_APPEND);
            echo $mensaje;
            exit;
        }
    }

    list($archivosEliminados, $carpetasEliminadas) = limpiarArchivosTemporales($tmpDir);

    if ($archivosEliminados == 0 && $carpetasEliminadas == 0) {
        $mensaje = "\n$fecha_hora [INFO] No hay elementos que limpiar en la carpeta temporal.";
    } else {
        $mensaje = "\n$fecha_hora [INFO] Se han eliminado $archivosEliminados archivos y $carpetasEliminadas carpetas de la carpeta temporal.";
    }

    file_put_contents($log_day_folder . "log_$fecha_hora_file.log", $mensaje, FILE_APPEND);

    echo $mensaje;

    sleep(300);
}
?>