<?php

$tmpDir = "../../tmp/";
$zipDir = $tmpDir . "zips/";

if (!is_dir($zipDir)) {
    if (!mkdir($zipDir, 0777, true)) {
        echo "No se pudo crear la carpeta 'zips' para almacenar los archivos ZIP.";
        exit;
    }
}

$maxPerRequest = 80;

if (isset($_FILES['images'])) {
    $totalImages = count($_FILES['images']['name']);

    if ($totalImages > $maxPerRequest) {
        echo "Se ha excedido el límite máximo de 80 imágenes permitidas.";
        exit;
    }

    $uniqueFolder = uniqid();
    $tmpDir .= $uniqueFolder . '/';

    if (!mkdir($tmpDir, 0777, true)) {
        echo "No se pudo crear la carpeta para almacenar las imágenes temporales.";
        exit;
    }

    for ($i = 0; $i < $totalImages; $i++) {
        $tmpFilePath = $_FILES['images']['tmp_name'][$i];
        $fileName = $_FILES['images']['name'][$i];

        $fileType = exif_imagetype($tmpFilePath);
        if ($fileType === false) {
            echo "El archivo '$fileName' no es una imagen válida.";
            continue;
        }

        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        $uniqueFileName = basename($fileName, "." . $fileExtension) . '.webp';
        $webpFilePath = $tmpDir . $uniqueFileName;

        switch ($fileType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($tmpFilePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($tmpFilePath);
                break; 
            case IMAGETYPE_TIFF_II:
            case IMAGETYPE_TIFF_MM:
                $sourceImage = imagecreatefromtiff($tmpFilePath);
                break;
            case IMAGETYPE_BMP:
                $sourceImage = imagecreatefrombmp($tmpFilePath);
                break;
            default:
                echo "El tipo de imagen no es compatible.";
                continue;
        }

        imagewebp($sourceImage, $webpFilePath, 90);

        imagedestroy($sourceImage);
    }

    $zipFileName = $zipDir . uniqid() . "_images.zip";

    $zip = new ZipArchive();
    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        $files = glob($tmpDir . "*.webp");
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
    } else {
        echo "No se pudo crear el archivo ZIP.";
        exit;
    }

    header("Location: $zipFileName");
    exit;
} else {
    echo "No se han enviado imágenes.";
    exit;
}
?>