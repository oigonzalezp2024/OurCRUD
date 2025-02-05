<?php

function footer() {
    $footer = "<footer class=\"container-fluid text-center\">\n"
          . "    <p>Desarrollado por:</p>\n"
          . "    <p>Óscar Iván González Peña</p>\n"
          . "    <p>2025</p>\n"
          . "</footer>\n";
    return $footer;
}


function archivo_footer($tabla, $contenido) {
    $archivo = fopen("proyecto/vista/$tabla.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}

archivo_footer("footer", footer());
?>

