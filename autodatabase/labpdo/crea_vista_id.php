<?php
include "./SelectDB.php";

function vi_conexion(){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function vi_crear_vista($base, $tabla){

$conn = vi_conexion();

$sql="Select COLUMN_NAME, COLUMN_KEY
               FROM information_schema.columns
               WHERE TABLE_SCHEMA='$base'
               AND TABLE_NAME='$tabla'";
$consulta = mysqli_query($conn, $sql);
$x = 1;
while($fila = mysqli_fetch_assoc($consulta)){
    if($fila['COLUMN_KEY']=="PRI"){
        $llave = $fila['COLUMN_NAME'];
    }
    $datos[$x] = $fila['COLUMN_NAME'];
    $x++;
}

vi_archivo_vista($tabla, vi_pag_web($base, $tabla, $datos, $llave)); 

}




function vi_archivo_vista($tabla, $contenido) {
    $archivo = fopen("proyecto/vista/componentes/vista_".$tabla."_id.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}

function vi_pag_web($base, $tabla, $datos, $llave){
    $registro = vi_registro($base, $datos);
$btnMod = "                <a target=\"_blank\" href=\"../pdf/formatos/pdff_".$tabla."_id.php\"><i class=\"btn glyphicon glyphicon-download-alt\"></i></a>\n"
        . "                <button class=\"btn glyphicon glyphicon-pencil\"\n"
        . "                               data-toggle=\"modal\"\n"
        . "                               data-target=\"#modalEdicion\"\n"
        . "                               onclick=\"agregaform('<?php echo \$datos; ?>')\">\n"
        . "                </button>\n";
$btnEli = "                <button class=\"btn glyphicon glyphicon-remove\"\n"
        . "                           onclick=\"preguntarSiNo('<?php echo \$fila['" . $llave . "']; ?>')\">\n"
        . "                </button>\n</td>\n";
    $abre_conexion = vi_abre_conexion($tabla, $datos);
    $head = vi_head();
    $body = vi_body($base, $datos, $registro, $btnMod, $btnEli, $tabla);
    $pag_web = $abre_conexion
            . "<!DOCTYPE html>\n"
            . "<html>\n"
            . $head . $body
            . "</html>\n"; 
    return $pag_web;
}

function vi_registro($base, $datos) {
$x = 1;
$registro = "";
while ($x <= count($datos)) {
    if (substr($datos[$x], -3) == "_id") {
        $registro .= "            <td>";
        $registro .= crearLista($base, "id_" . substr($datos[$x], 0, -3));
        $registro .= "            </td>";
    } else if(substr($datos[$x], 0, 3) == "id_"){
        $registro .= "            <td>";
        $registro .= "            <table class=\"table table-hover table-condensed\">\n\n";
        $registro .= "              <tr>\n";
        $registro .= "                  <td style=\"background-color: #0088ff; color: #eaeaea;\" colspan=\"2\"><b>" . $datos[$x] . "</b></td>\n";
        $registro .= "              </tr>\n";
        $registro .= "              <tr>\n";
        $registro .= "                  <td><?php echo \$fila['" . $datos[$x] . "']; ?></td>\n";
        $registro .= "              </tr>\n";
        $registro .= "            </table>\n";
        $registro .= "            </td>";
        /*$registro .= "            <td><?php echo \$fila['" . $datos[$x] . "']; ?></td>\n";*/
        $registro .= "            <td>";
        $registro .= "            <table class=\"table table-hover table-condensed\">\n\n";
        $registro .= "  <tr>\n";
        $registro .= "    <td style=\"background-color: #0088ff; color: #eaeaea;\" colspan=\"2\"><b>".substr($datos[$x], 3)."</b></td>\n";
        $registro .= "  </tr>\n";
        foreach ($datos as $option) {
            if(substr($option,0, 3)!=="id_"){
              $registro .= "  <tr>\n";
              $registro .= "    <td>$option:</td>\n";
              $registro .= "    <td><?php echo \$fila['$option']; ?></td>\n";
              $registro .= "  </tr>\n";
            }
        }
        $registro .= "            </table>";
        $registro .= "            </td>";
    }
$x++;
} 
return $registro;
} 

function vi_abre_conexion($tabla, $datos) {
    $abre_conexion = "<?php\n"
            . "include \"../../controller/Controller".ucfirst(str_replace("_", "", $tabla)).".php\";\n"
            . "\$controller = new Controller".ucfirst(str_replace("_", "", $tabla))."();\n"
            . "\$id = \$_GET['id'];\n"
            . "\$filas = \$controller->".substr($datos[1], 3)."Id(\$id);\n"
            . "?>\n";
    return $abre_conexion;
}

function vi_head() {
    $head = "<head>\n"
            . "    <meta charset=\"UTF-8\">\n"
            . "    <title>arreglos</title>\n"
            . "</head>\n";
    return $head;
}

function vi_body($base, $datos, $registro, $btnMod, $btnEli, $tabla){
    
    $table = vi_table($base, $tabla, $datos, $registro, $btnMod, $btnEli);
    $body = "<div class=\"row\"><br><br><br><br>\n"
            . "    <div>\n"
            . "<center>\n"
            . "<h2>".ucfirst(str_replace("_"," ",$tabla))."</h2>\n"
            . "</center>\n"
            . "<button class=\"btn navbar-left\"\n"
            . "               data-toggle=\"modal\"\n"
            . "               data-target=\"#modalNuevo\">\n"
            . "    <span class=\"glyphicon glyphicon-plus\"></span>\n"
            . "</button></div>\n"
            . $table
            . "</div>\n"
            . "</body>\n";
    return $body;
}

function vi_table($base, $tabla, $datos, $registro, $btnMod, $btnEli){
    
    $thead = vi_thead($datos);
    $tbody = vi_tbody($tabla, $datos, $registro, $btnMod, $btnEli);
    $table = "    <div class=\"table-responsive\">\n";
    $table .= "    <table class=\"table table-hover table-condensed\">\n"
            . $thead
            . $tbody
            ."    </table>\n";
    $table .= "\n<div>\n";
    return $table;
}

function vi_thead($datos) {
    $crea_thead = vi_crea_thead($datos);
    $thead = "    <thead>\n"
            . "        <tr><th></th>\n"
            . $crea_thead
            . "        <th></th></tr>\n"
            . "   </thead>\n";
    return $thead;
}

function vi_crea_thead($datos) {
    $x = 1;
    $crea_thead = "";
    while ($x <= count($datos)) {
        if (substr($datos[$x], -3) !== "_id" && substr($datos[$x], 0, 3) !== "id_") {
            //$crea_thead .= "            <th>" . $datos[$x] . "</th>\n";
            $crea_thead .= "            <th></th>\n";
        } else {
            $crea_thead .= "            <th></th>\n";
        }
        $x++;
    }
    return $crea_thead;
}

function vi_tbody($tabla, $datos, $registro, $btnMod, $btnEli){
    $tomar = vi_tomar($datos);
    $tbody = "    <tbody>\n"
            . "    <?php\n"
            . "    foreach (\$filas as \$fila) {\n"
            . $tomar;
            foreach ($datos as $dato) {
                $tbody .= "        \$$dato = \$fila['$dato'];\n";
            }
    $tbody .= "    ?>\n"
            . "        <tr>\n" 
            . "            <td style=\"text-align:right;\">\n" . $btnMod
            . "            \n" . $btnEli . $registro
            . "            <td>\n" . $btnMod
            . "            \n" . $btnEli
            . "        </tr>\n"
            . "    <?php\n"
            . "    }\n"
            . "    ?>\n"
            . "    </tbody>\n";
    return $tbody;
}

function vi_tomar($datos) {
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
