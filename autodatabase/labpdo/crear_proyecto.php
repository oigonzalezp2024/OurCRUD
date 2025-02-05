<?php

// fuente: https://www.php.net/manual/es/function.mkdir.php

function proyecto($host, $user, $password, $base)
{
    crea_capas();
    crea_archivos();
    crea_header($base); // crea_archivos(); // include 'crea_header.php';
    $conn = conexionc($host, $user, $password, $base);
    $sql = "Show tables from $base";
    $consulta = mysqli_query($conn, $sql);
    $x = 1;
    while ($fila = mysqli_fetch_assoc($consulta)) {
        $database = "Tables_in_" . $base;
        $datos[$x] = $fila[$database];
        $x++;
    }
    $n = 1;
    while ($n <= count($datos)) {
        $tabla = $datos[$n];
        if ($n == 1) {
            $inicia = $tabla;
        }
        accion_crear_archivos($base, $tabla);
        $n++;
    }
    sleep(1);
    rename("proyecto", "Error");
    rename("Error", "../proyectos/".$base."_pdo");
    header("Location: ../proyectos/".$base."_pdo/vista/$inicia.php");
}

function crea_capas()
{
    estructura("proyecto");
    estructura("proyecto/bbdd");
    estructura("proyecto/modelo");
    estructura("proyecto/vista");
    estructura("proyecto/vista/componentes");
    estructura("proyecto/controlador");
    estructura("proyecto/utils");
    estructura("proyecto/pdf");
    estructura("proyecto/pdf/formatos");
    estructura("proyecto/model");
    estructura("proyecto/controller");
}

function crea_archivos()
{
    include "copiar_libreria.php";
    include 'crea_modelo.php';
    include 'crea_vista.php';
    include 'crea_vista_id.php';
    include 'crea_controlador.php';
    include 'crea_clase.php';
    include 'crea_clase_id.php';
    include 'crea_librerias.php';
    include 'crea_footer.php';
    include 'crea_header.php'; // --> crea_header($base);
    include 'crea_pdf_clase.php';
    include 'crea_pdf_formato.php';
    include 'crea_model.php';
    include 'crea_controller.php';
}

function accion_crear_archivos($base, $tabla)
{
    crea_modelo($base, $tabla);
    crear_vista($base, $tabla);
    vi_crear_vista($base, $tabla);
    crea_controlador($base, $tabla);
    crea_clase($base, $tabla);
    cl_crea_clase($base, $tabla);
    pdfc_crear_vista($base, $tabla);
    pdff_crear_vista($base, $tabla);
    mo_crear_vista($base, $tabla);
    co_crear_vista($base, $tabla);
}

function estructura($estructura)
{
    if (!mkdir($estructura, 0777, true)) {
        die('Fallo al crear las carpetas...');
    }
}

function conexionc($host, $user, $password, $base)
{
    $conn = mysqli_connect($host, $user, $password, $base);
    return $conn;
}

$base = $_GET['base'];
proyecto('localhost', 'root', '', $base);
