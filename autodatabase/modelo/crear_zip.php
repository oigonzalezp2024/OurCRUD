<?php

function crearZip(string $database__name, string $origen, string $destino)
{
    if (!file_exists($origen)) {
        throw new Exception("La carpeta no existe.");
    }
    $zip = new ZipArchive();
    if (!$zip->open($destino, ZipArchive::CREATE)) {
        throw new Exception("No se pudo crear el archivo zip.");
    }
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            $origen,
            RecursiveDirectoryIterator::SKIP_DOTS
        ),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($files as $fileinfo) {
        $filePath = $fileinfo->getRealPath();
        $filePath = str_replace("\\", "/", $filePath);
        $origen = str_replace("\\", "/", $origen);
        if($fileinfo->isDir()){
            $origenS = substr($origen, 13);   
            $res = strstr($filePath, $origenS);
            $zip->addEmptyDir($res."/");
        }else{
            $origenS = substr($origen, 13); 
            $res = strstr($filePath, $origenS);
            $zip->addFile("../proyectos/".$res, $res);
        }
    }
    $ori = "../bbdd/".substr($database__name,0, -4).".sql";
    $dess = "$database__name/bbdd/".substr($database__name,0, -4).".sql";
    echo $ori."   ---   " .$dess;
    $zip->addFile($ori, $dess);
    $zip->close(); 
    return true;
}

$database__name = $_GET['base'];
$origen = "../proyectos/$database__name/";
$destino = "../proyectos/$database__name.zip";
if(crearZip($database__name, $origen, $destino)){
    echo "El archivo se ha creado correctamente.";
}else{
    echo "Ha ocurrido un error al crear el archivo zip.";  
}
header("Location: $destino");