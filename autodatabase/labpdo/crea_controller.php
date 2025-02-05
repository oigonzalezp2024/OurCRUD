<?php
//include "./SelectDB.php";

function co_conexion()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function co_crear_vista($base, $tabla)
{

    $conn = co_conexion();

    $sql = "Select COLUMN_NAME, COLUMN_KEY
               FROM information_schema.columns
               WHERE TABLE_SCHEMA='$base'
               AND TABLE_NAME='$tabla'";
    $consulta = mysqli_query($conn, $sql);
    $x = 1;
    while ($fila = mysqli_fetch_assoc($consulta)) {
        if ($fila['COLUMN_KEY'] == "PRI") {
            $llave = $fila['COLUMN_NAME'];
        }
        $datos[$x] = $fila['COLUMN_NAME'];
        $x++;
    }

    co_archivo_vista($tabla, co_pag_web($base, $tabla, $datos, $llave));
}




function co_archivo_vista($tabla, $contenido)
{
    $archivo = fopen("proyecto/controller/Controller" . ucfirst(str_replace("_", "", $tabla)) . ".php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}

function co_pag_web($base, $tabla, $datos, $llave)
{
    $registro = co_registro($base, $datos);
    $btnMod = "";
    $btnEli = "";
    $abre_conexion = "<?php\n\n";
    $body = co_body($base, $datos, $registro, $btnMod, $btnEli, $tabla);
    $pag_web = $abre_conexion
        . ""
        . $body
        . "";
    return $pag_web;
}

function co_registro($base, $datos)
{
    $x = 1;
    $registro = "";
    while ($x <= count($datos)) {
        if (substr($datos[$x], -3) == "_id") {
            $registro .= crearMetodoController($base, "id_" . substr($datos[$x], 0, -3));
        }
        $x++;
    }
    return $registro;
}

function co_body($base, $datos, $registro, $btnMod, $btnEli, $tabla)
{
    //$table = co_tbody($tabla, $datos, $registro, $btnMod, $btnEli);
    $table = crearMetodoController($base, $datos[1]);
    $body = "Class Controller"
        . ucfirst(str_replace("_", "", $tabla)) . "{\n"
        . $table . $registro
        . "}\n";
    return $body;
}

function co_tbody($tabla, $datos, $registro, $btnMod, $btnEli)
{
    $tomar = co_tomar($datos);
    $listar = "    function " . str_replace("_", "", $datos[1]) . "(int \$id)\n    {\n"
        . "        include_once '../../modelo/conexion.php';\n"
        . "        \$conn = conexion();\n"
        . "        \$sql = \"SELECT * FROM $tabla WHERE " . $datos[1] . "=\$id\";\n";
    $tbody = "\n"
        . $listar
        . "        \$result = mysqli_query(\$conn, \$sql);\n"
        . "        WHILE(\$fila = mysqli_fetch_assoc(\$result)){\n"
        . $tomar;
    foreach ($datos as $dato) {
        $tbody .= "            \$$dato = \$fila['$dato'];\n";
    }
    $tbody .= "        }\n";
    $tbody .= "    }\n";
    $tbody .= "" . $btnMod
        . "" . $btnEli . $registro
        . "" . $btnMod
        . "" . $btnEli
        . "";
    return $tbody;
}

function co_tomar($datos)
{
    $x = 1;
    $tomar = "        \$datos = \$fila['" . $datos[$x] . "'] . \"||\" .\n";
    $x++;
    while ($x < count($datos)) {
        $tomar = $tomar . "                  \$fila['" . $datos[$x] . "'] . \"||\" .\n";
        $x++;
    }
    $tomar = $tomar . "                  \$fila['" . $datos[$x] . "'];\n";
    return $tomar;
}
