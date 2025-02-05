<?php
//include "./SelectDB.php";

function mo_conexion()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function mo_crear_vista($base, $tabla)
{

    $conn = mo_conexion();

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

    mo_archivo_vista($tabla, mo_pag_web($base, $tabla, $datos, $llave));
}




function mo_archivo_vista($tabla, $contenido)
{
    $archivo = fopen("proyecto/model/Model" . ucfirst(str_replace("_", "", $tabla)) . ".php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}

function mo_pag_web($base, $tabla, $datos, $llave)
{
    $registro = mo_registro($base, $datos);
    $btnMod = "";
    $btnEli = "";
    $abre_conexion = "<?php\n\n";
    $body = mo_body($base, $datos, $registro, $btnMod, $btnEli, $tabla);
    $pag_web = $abre_conexion
        . ""
        . $body
        . "";
    return $pag_web;
}

function mo_registro($base, $datos)
{
    $x = 1;
    $registro = "";
    while ($x <= count($datos)) {
        if (substr($datos[$x], -3) == "_id") {
            $registro .= crearMetodo($base, "id_" . substr($datos[$x], 0, -3));
        }
        $x++;
    }
    return $registro;
}

function mo_body($base, $datos, $registro, $btnMod, $btnEli, $tabla)
{
    //$table = mo_tbody($tabla, $datos, $registro, $btnMod, $btnEli);
    $table = crearMetodo($base, $datos[1]);
    $body = "Class Model"
        . ucfirst(str_replace("_", "", $tabla)) . "{\n"
        . $table . $registro
        . "}\n";
    return $body;
}

function mo_tbody($tabla, $datos, $registro, $btnMod, $btnEli)
{
    $tomar = mo_tomar($datos);
    $listar = "    function " . $datos[1] . "(int \$id)\n    {\n"
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

function mo_tomar($datos)
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
