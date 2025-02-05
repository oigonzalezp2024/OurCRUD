<?php
//include "./SelectDB.php";

function pdfc_conexion()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function pdfc_crear_vista($base, $tabla)
{

    $conn = pdfc_conexion();

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

    pdfc_archivo_vista($tabla, pdfc_pag_web($base, $tabla, $datos, $llave));
}




function pdfc_archivo_vista($tabla, $contenido)
{
    $archivo = fopen("proyecto/utils/Pdf".ucfirst($tabla).".php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}

function pdfc_pag_web($base, $tabla, $datos, $llave)
{
    $pag_web = "<?php\n" .
    "require('../../librerias/fpdf/fpdf.php');\n" .
    "class Pdf".ucfirst($tabla)." extends FPDF\n" .
    "{\n" .
    "	function LoadData(\$id)\n" .
    "	{\n" .
    "		include \"../../controller/Controller".$tabla.".php\";\n" .
    "		\$controller = new Controller".$tabla."();\n" .
    "		\$data = \$controller->".substr($datos[1], 3)."Id(\$id);\n" .
    "		return \$data;\n" .
    "	}\n\n" .
    "	function BasicTable(\$header, \$data)\n" .
    "	{\n" .
    "		foreach (\$header as \$col)\n" .
    "			\$this->Cell(40, 7, \$col, 1);\n" .
    "		\$this->Ln();\n" .
    "		foreach (\$data as \$row) {\n" .
    "			foreach (\$row as \$col)\n" .
    "				\$this->Cell(40, 6, \$col, 1);\n" .
    "			\$this->Ln();\n" .
    "		}\n" .
    "	}\n\n" .
    "	function ImprovedTable(\$header, \$data)\n" .
    "	{\n" .
    "		\$w = array(40, 35, 45, 40);\n" .
    "		for (\$i = 0; \$i < count(\$header); \$i++)\n" .
    "			\$this->Cell(\$w[\$i], 7, \$header[\$i], 1, 0, 'C');\n" .
    "		\$this->Ln();\n" .
    "		foreach (\$data as \$row) {\n" .
    "			\$this->Cell(\$w[0], 6, \$row[0], 'LR');\n" .
    "			\$this->Cell(\$w[1], 6, \$row[1], 'LR');\n" .
    "			\$this->Cell(\$w[2], 6, number_format(\$row[2]), 'LR', 0, 'R');\n" .
    "			\$this->Cell(\$w[3], 6, number_format(\$row[3]), 'LR', 0, 'R');\n" .
    "			\$this->Ln();\n" .
    "		}\n" .
    "		\$this->Cell(array_sum(\$w), 0, '', 'T');\n" .
    "	}\n\n" .
    "	function FancyTable(\$header, \$data)\n" .
    "	{\n" .
    "		\$this->SetFillColor(255, 0, 0);\n" .
    "		\$this->SetTextColor(255);\n" .
    "		\$this->SetDrawColor(128, 0, 0);\n" .
    "		\$this->SetLineWidth(.3);\n" .
    "		\$this->SetFont('', 'B');\n" .
    "		\$w = array(40, 35, 45, 40);\n" .
    "		for (\$i = 0; \$i < count(\$header); \$i++)\n" .
    "			\$this->Cell(\$w[\$i], 7, \$header[\$i], 1, 0, 'C', true);\n" .
    "		\$this->Ln();\n" .
    "		\$this->SetFillColor(224, 235, 255);\n" .
    "		\$this->SetTextColor(0);\n" .
    "		\$this->SetFont('');\n" .
    "		\$fill = false;\n" .
    "		foreach (\$data as \$row) {\n" .
    "			\$this->Cell(\$w[0], 6, \$row[0], 'LR', 0, 'L', \$fill);\n" .
    "			\$this->Cell(\$w[1], 6, \$row[1], 'LR', 0, 'L', \$fill);\n" .
    "			\$this->Cell(\$w[2], 6, number_format(\$row[2]), 'LR', 0, 'R', \$fill);\n" .
    "			\$this->Cell(\$w[3], 6, number_format(\$row[3]), 'LR', 0, 'R', \$fill);\n" .
    "			\$this->Ln();\n" .
    "			\$fill = !\$fill;\n" .
    "		}\n" .
    "		\$this->Cell(array_sum(\$w), 0, '', 'T');\n" .
    "	}\n" .
    "}\n";
    return $pag_web;
}

function pdfc_registro($base, $datos)
{
    $x = 1;
    $registro = "";
    while ($x <= count($datos)) {
        if (substr($datos[$x], -3) == "_id") {
            $registro .= "            <td>";
            $registro .= crearLista($base, "id_" . substr($datos[$x], 0, -3));
            $registro .= "            </td>";
        } else if (substr($datos[$x], 0, 3) == "id_") {
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
            $registro .= "    <td style=\"background-color: #0088ff; color: #eaeaea;\" colspan=\"2\"><b>" . substr($datos[$x], 3) . "</b></td>\n";
            $registro .= "  </tr>\n";
            foreach ($datos as $option) {
                if (substr($option, 0, 3) !== "id_") {
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

function pdfc_abre_conexion()
{
    $abre_conexion = "<?php\n"
        . "include_once '../../modelo/conexion.php';\n"
        . "\$conn = conexion();\n"
        . "\$id = \$_GET['id'];\n"
        . "?>\n";
    return $abre_conexion;
}

function pdfc_head()
{
    $head = "<head>\n"
        . "    <meta charset=\"UTF-8\">\n"
        . "    <title>arreglos</title>\n"
        . "</head>\n";
    return $head;
}

function pdfc_body($base, $datos, $registro, $btnMod, $btnEli, $tabla)
{

    $table = pdfc_table($base, $tabla, $datos, $registro, $btnMod, $btnEli);
    $body = "<div class=\"row\"><br><br><br><br>\n"
        . "    <div>\n"
        . "<center>\n"
        . "<h2>" . ucfirst(str_replace("_", " ", $tabla)) . "</h2>\n"
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

function pdfc_table($base, $tabla, $datos, $registro, $btnMod, $btnEli)
{

    $thead = pdfc_thead($datos);
    $tbody = pdfc_tbody($tabla, $datos, $registro, $btnMod, $btnEli);
    $table = "    <div class=\"table-responsive\">\n";
    $table .= "    <table class=\"table table-hover table-condensed\">\n"
        . $thead
        . $tbody
        . "    </table>\n";
    $table .= "\n<div>\n";
    return $table;
}

function pdfc_thead($datos)
{
    $crea_thead = pdfc_crea_thead($datos);
    $thead = "    <thead>\n"
        . "        <tr><th></th>\n"
        . $crea_thead
        . "        <th></th></tr>\n"
        . "   </thead>\n";
    return $thead;
}

function pdfc_crea_thead($datos)
{
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

function pdfc_tbody($tabla, $datos, $registro, $btnMod, $btnEli)
{
    $tomar = pdfc_tomar($datos);
    $listar = "    \$sql = \"SELECT * FROM $tabla WHERE " . $datos[1] . "=\$id\";\n";
    $tbody = "    <tbody>\n"
        . "    <?php\n"
        . $listar
        . "    \$result = mysqli_query(\$conn, \$sql);\n"
        . "    WHILE(\$fila = mysqli_fetch_assoc(\$result)){\n"
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

function pdfc_tomar($datos)
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

function pdfc_cierra_conexion()
{
    $cierra_conexion = "<?php\n"
        . "mysqli_close(\$conn);\n"
        . "?>\n";
    return $cierra_conexion;
}
