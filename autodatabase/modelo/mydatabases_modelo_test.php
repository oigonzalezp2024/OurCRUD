<?php
include 'conexion.php';
$conn = conexion();
//$id_mydatabase = $_POST['id_mydatabase'];
$content = "";
$content_pri = "";
$content_index = "";
$content_auto = "";
$content_alt = "";
$id_mydatabase = 18;
$sql = "SELECT *
    FROM mydatabases
    WHERE id_mydatabase = $id_mydatabase";
$result = mysqli_query($conn, $sql);
$fila = mysqli_fetch_assoc($result);
$database__name = $fila['database__name'];
$sql = "CREATE DATABASE $database__name;";
echo $sql ."<br>";
$consulta = mysqli_query($conn, $sql);
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
    $datos = $fila['id_table'] . "||" .
        $fila['table__name'] . "||" .
        $fila['mydatabase_id'];
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
    echo $sql . "<br>";
    $consulta = mysqli_query($conn, $sql);
}

foreach ($fields as $field) {
    if ($field[1] == 3) {
        $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
            " ADD PRIMARY KEY " . $field[0] . " (" . $field[0] . ");";
        echo $sql . "<br>";
        $consulta = mysqli_query($conn, $sql);
        $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
            " MODIFY " . $field[0] . " int(11) NOT NULL AUTO_INCREMENT;";
        echo $sql . "<br>";
        $consulta = mysqli_query($conn, $sql);
    }
}

foreach ($fields as $field) {
    if ($field[1] == 2) {
        $sql = "ALTER TABLE " . $database__name . "." . $field[2] .
            " ADD KEY " . $field[0] . " (" . $field[0] . ");";
        echo $sql . "<br>";
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
            if($table_name_temp != $aa_table_name){
                $table_name_temp = $aa_table_name;
                $cont = 1;
            }
            $sql = "ALTER TABLE " . $aa_table_schema . "." . $aa_table_name .
                " ADD CONSTRAINT " . $aa_table_name . "_ibfk_$cont FOREIGN KEY (" . $aa_index_name . ") REFERENCES " . $aa_table_schema . "." . $bb_table_name . " (" . $bb_column_name . ") ON UPDATE CASCADE;";
            echo $sql . "<br>";
            $consulta = mysqli_query($conn, $sql);
            $cont++;
        }
    }
}
