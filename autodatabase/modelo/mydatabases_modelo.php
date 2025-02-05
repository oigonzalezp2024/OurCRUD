<?php
include 'conexion.php';
$conn = conexion();
$accion = $_GET['accion'];

class Mydatabase
{
    function insert(string $database__name): int
    {
        $conn = conexion();
        $sql = "INSERT INTO mydatabases(
        database__name
        )VALUE(
        '$database__name')";
        mysqli_query($conn, $sql);
        return mysqli_insert_id($conn);
    }

    function update(int $id_mydatabase, string $database__name): mysqli_result|bool
    {
        $conn = conexion();
        $sql = "UPDATE mydatabases SET
        database__name = '$database__name'
        WHERE id_mydatabase = '$id_mydatabase'";
        return mysqli_query($conn, $sql);
    }

    function deleteId(int $id_mydatabase): mysqli_result|bool
    {
        $conn = conexion();
        $sql = "DELETE FROM mydatabases
            WHERE id_mydatabase = '$id_mydatabase'";
        return mysqli_query($conn, $sql);
    }

    function selectId(int $id_mydatabase): array|null|false
    {
        $conn = conexion();
        $sql = "SELECT *
        FROM mydatabases
        WHERE id_mydatabase = $id_mydatabase";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    function selectTableId(int $id_mydatabase): mysqli_result|bool
    {
        $conn = conexion();
        $sql = "SELECT
        myt.id_table as id_table,
        myt.table__name as table__name,
        myt.mydatabase_id as mydatabase_id,
        mdb.database__name as database__name
        FROM mytables as myt,
        mydatabases as mdb
        WHERE mdb.id_mydatabase = myt.mydatabase_id
        AND mdb.id_mydatabase = $id_mydatabase";
        return mysqli_query($conn, $sql);
    }

    function selectFieldsTableId(int $table_id): mysqli_result|bool
    {
        $conn = conexion();
        $sql = "SELECT
        myf.field_name field_name,
        myf.field_index_id field_index_id,
        fty.field_type as fty_field_type,
        fsi.field_size as fsi_field_size
        FROM myfields as myf,
        field_types as fty,
        field_sizes as fsi
        WHERE myf.table_id=$table_id
        AND fty.id_field_type = myf.field_type_id
        AND fsi.id_field_size = myf.field_size_id
        ORDER BY myf.field_position";
        return mysqli_query($conn, $sql);
    }

    function selectKeysTable(string $database__name, string $index__name, string $table__name): mysqli_result|bool
    {
        $conn = conexion();
        $sql = "SELECT
        cc.TABLE_SCHEMA cc_table_schema,
        cc.TABLE_NAME cc_table_name,
        cc.COLUMN_NAME cc_column_name,
        aa.INDEX_NAME aa_index_name,
        bb.TABLE_NAME bb_table_name,
        bb.COLUMN_NAME bb_column_name
        FROM INFORMATION_SCHEMA.STATISTICS as aa,
        INFORMATION_SCHEMA.`KEY_COLUMN_USAGE` as bb,
        INFORMATION_SCHEMA.STATISTICS as cc
        WHERE bb.TABLE_SCHEMA = '" . $database__name . "'
        AND aa.TABLE_SCHEMA = bb.TABLE_SCHEMA
        AND aa.INDEX_NAME != 'PRIMARY'
        AND SUBSTRING_INDEX(bb.COLUMN_NAME, 'id_', -1) = SUBSTRING_INDEX(aa.COLUMN_NAME, '_id', 1)
        AND cc.INDEX_NAME = 'PRIMARY'
        AND cc.TABLE_SCHEMA = bb.TABLE_SCHEMA
        AND cc.TABLE_NAME = aa.TABLE_NAME
        AND aa.INDEX_NAME = '" . $index__name . "' 
        AND cc.TABLE_NAME = '" . $table__name . "'";
        return mysqli_query($conn, $sql);
    }

    function createDatabase(string $database__name): mysqli_result|bool
    {
        $conn = conexion();
        $sql = "CREATE DATABASE $database__name;";
        return mysqli_query($conn, $sql);
    }
}

if ($accion == "insertar") {
    $database__name = $_POST['database__name'];
    $mydatabase = new Mydatabase();
    $res = $mydatabase->insert($database__name);
    if ($res > 0) {
        echo 1;
    } else {
        echo 0;
    }
} elseif ($accion == "modificar") {
    $id_mydatabase = $_POST['id_mydatabase'];
    $database__name = $_POST['database__name'];
    $mydatabase = new Mydatabase();
    echo $mydatabase->update($id_mydatabase, $database__name);
} elseif ($accion == "borrar") {
    $id_mydatabase = $_POST['id_mydatabase'];
    $mydatabase = new Mydatabase();
    echo $mydatabase->deleteId($id_mydatabase);
} elseif ($accion == "descargar") {
    $id_mydatabase = $_GET['database'];
    $content = "";
    $content_pri = "";
    $content_index = "";
    $content_auto = "";
    $content_alt = "";
    $mydatabase = new Mydatabase();
    $fila = $mydatabase->selectId($id_mydatabase);
    $database__name = $fila['database__name'];
    $sql = "CREATE DATABASE $database__name;";
    $content .= $sql;
    $filas = $mydatabase->selectTableId($id_mydatabase);
    $fields = [];
    foreach ($filas as $fila) {
        $table_id = $fila['id_table'];
        $table__name = $fila['table__name'];
        $resulth = $mydatabase->selectFieldsTableId($table_id);
        $cadena = "";
        foreach ($resulth as $filah) {
            $field_name = $filah['field_name'];
            $field_index_id = $filah['field_index_id'];
            $fty_field_type = $filah['fty_field_type'];
            $fsi_field_size = $filah['fsi_field_size'];
            $field_config = $field_name . " " . $fty_field_type . "(" . $fsi_field_size . "),";
            $cadena .= $field_config;
            $field = [$field_name, $field_index_id, $table__name];
            array_push($fields, $field);
        }
        $cadena = substr($cadena, 0, -1);
        $sql = "CREATE TABLE " . $database__name . "." . $table__name . "($cadena);";
        $content .= $sql;
    }

    foreach ($fields as $field) {
        if ($field[1] == 3) {
            $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
                " ADD PRIMARY KEY " . $field[0] . " (" . $field[0] . ");";
            $content .= $sql;
            $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
                " MODIFY " . $field[0] . " int(11) NOT NULL AUTO_INCREMENT;";
            $content .= $sql;
        }
    }

    foreach ($fields as $field) {
        if ($field[1] == 2) {
            $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
                " ADD KEY " . $field[0] . " (" . $field[0] . ");";
            $content .= $sql;
        }
    }

    $cont = 1;
    $table_name_temp = "";
    foreach ($fields as $field) {
        if ($field[1] == 2) {
            $index__name = $field[0];
            $table__name = $field[2];
            $resulthh = $mydatabase->selectKeysTable($database__name, $index__name, $table__name);
            foreach ($resulthh as $filahh) {
                $aa_table_schema = $filahh['cc_table_schema'];
                $aa_table_name = $filahh['cc_table_name'];
                $aa_index_name = $filahh['aa_index_name'];
                $bb_table_name = $filahh['bb_table_name'];
                $bb_column_name = $filahh['bb_column_name'];
                if ($table_name_temp != $aa_table_name) {
                    $table_name_temp = $aa_table_name;
                    $cont = 1;
                }
                $sql = "ALTER TABLE " . $aa_table_schema . "." . $aa_table_name .
                    " ADD CONSTRAINT " . $aa_table_name . "_ibfk_$cont FOREIGN KEY (" . $aa_index_name . ") REFERENCES " . $aa_table_schema . "." . $bb_table_name . " (" . $bb_column_name . ") ON UPDATE CASCADE;";
                $content .= $sql;
                $cont++;
            }
        }
    }

    $content = str_replace("),", "),\n", $content);
    $content = str_replace(";", ";\n\n", $content);
    unlink("../bbdd/" . $database__name . ".sql");
    $myfile = fopen("../bbdd/$database__name.sql", "w") or die("Unable to open file!");
    fwrite($myfile, $content);
    fclose($myfile);
    header("Location: ../bbdd/$database__name.sql");
} elseif ($accion == "crear") {
    $mydatabase = new Mydatabase();
    $id_mydatabase = $_POST['id_mydatabase'];
    $content = "";
    $content_pri = "";
    $content_index = "";
    $content_auto = "";
    $content_alt = "";
    $fila = $mydatabase->selectId($id_mydatabase);
    $database__name = $fila['database__name'];
    $sql = "DROP DATABASE IF EXISTS $database__name;";
    $consulta = mysqli_query($conn, $sql);
    $mydatabase->createDatabase($database__name);
    $sql = "SELECT
    myt.id_table as id_table,
    myt.table__name as table__name,
    myt.mydatabase_id as mydatabase_id,
    mdb.database__name as database__name
    FROM mytables as myt,
    mydatabases as mdb
    WHERE mdb.id_mydatabase = myt.mydatabase_id
    AND mdb.id_mydatabase = $id_mydatabase";
    $result = mysqli_query($conn, $sql);
    $fields = [];
    while ($fila = mysqli_fetch_assoc($result)) {
        $table_id = $fila['id_table'];
        $sql = "SELECT myf.*,
        fty.field_type as fty_field_type,
        fsi.field_size as fsi_field_size
        FROM myfields as myf,
        field_types as fty,
        field_sizes as fsi
        WHERE myf.table_id=$table_id
        AND fty.id_field_type = myf.field_type_id
        AND fsi.id_field_size = myf.field_size_id
        ORDER BY myf.field_position";
        $resulth = mysqli_query($conn, $sql);
        $cadena = "";
        while ($filah = mysqli_fetch_assoc($resulth)) {
            $field_position = $filah['field_position'];
            $field_name = $filah['field_name'];
            $fty_field_type = $filah['fty_field_type'];
            $fsi_field_size = $filah['fsi_field_size'];
            $field_index_id = $filah['field_index_id'];
            $field_config = $field_name . " " . $fty_field_type . "(" . $fsi_field_size . "),";
            $cadena .= $field_config;
            $field = [$field_name, $field_index_id, $fila['table__name']];
            array_push($fields, $field);
        }
        $cadena = substr($cadena, 0, -1);
        $sql = "CREATE TABLE " . $database__name . "." . $fila['table__name'] . "($cadena);";
        $consulta = mysqli_query($conn, $sql);
    }

    foreach ($fields as $field) {
        if ($field[1] == 3) {
            $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
                " ADD PRIMARY KEY " . $field[0] . " (" . $field[0] . ");";
            $consulta = mysqli_query($conn, $sql);
            $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
                " MODIFY " . $field[0] . " int(11) NOT NULL AUTO_INCREMENT;";
            $consulta = mysqli_query($conn, $sql);
        }
    }

    foreach ($fields as $field) {
        if ($field[1] == 2) {
            $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
                " ADD KEY " . $field[0] . " (" . $field[0] . ");";
            $consulta = mysqli_query($conn, $sql);
        }
    }

    $cont = 1;
    $table_name_temp = "";
    foreach ($fields as $field) {
        if ($field[1] == 2) {
            $sql = "SELECT
            cc.TABLE_SCHEMA cc_table_schema,
            cc.TABLE_NAME cc_table_name,
            cc.COLUMN_NAME cc_column_name,
            aa.INDEX_NAME aa_index_name,
            bb.TABLE_NAME bb_table_name,
            bb.COLUMN_NAME bb_column_name
            FROM INFORMATION_SCHEMA.STATISTICS as aa,
            INFORMATION_SCHEMA.`KEY_COLUMN_USAGE` as bb,
            INFORMATION_SCHEMA.STATISTICS as cc
            WHERE bb.TABLE_SCHEMA = '" . $database__name . "'
            AND aa.TABLE_SCHEMA = bb.TABLE_SCHEMA
            AND aa.INDEX_NAME != 'PRIMARY'
            AND SUBSTRING_INDEX(bb.COLUMN_NAME, 'id_', -1) = SUBSTRING_INDEX(aa.COLUMN_NAME, '_id', 1)
            AND cc.INDEX_NAME = 'PRIMARY'
            AND cc.TABLE_SCHEMA = bb.TABLE_SCHEMA
            AND cc.TABLE_NAME = aa.TABLE_NAME
            AND aa.INDEX_NAME = '" . $field[0] . "' 
            AND cc.TABLE_NAME = '" . $field[2] . "'";
            $resulthh = mysqli_query($conn, $sql);
            while ($filahh = mysqli_fetch_assoc($resulthh)) {
                $aa_table_schema = $filahh['cc_table_schema'];
                $aa_table_name = $filahh['cc_table_name'];
                $aa_index_name = $filahh['aa_index_name'];
                $bb_table_name = $filahh['bb_table_name'];
                $bb_column_name = $filahh['bb_column_name'];
                if ($table_name_temp != $aa_table_name) {
                    $table_name_temp = $aa_table_name;
                    $cont = 1;
                }
                $sql = "ALTER TABLE " . $aa_table_schema . "." . $aa_table_name .
                    " ADD CONSTRAINT " . $aa_table_name . "_ibfk_$cont FOREIGN KEY (" . $aa_index_name . ") REFERENCES " . $aa_table_schema . "." . $bb_table_name . " (" . $bb_column_name . ") ON UPDATE CASCADE;";
                $consulta = mysqli_query($conn, $sql);
                $cont++;
            }
        }
    }
    echo $consulta;
}
