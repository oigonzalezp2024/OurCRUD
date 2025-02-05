<?php

class SelectDB
{
  private $pdo;
  private $schema;
  private $table;
  private $primaryKey;
  private $options;
  private $sql;

  public function __construct(PDO $pdo, $schema, $primaryKey)
  {
    $this->pdo = $pdo;
    $this->schema = $schema;
    $this->primaryKey = $primaryKey;
  }

  public function ejecutarConsulta()
  {
    $sql = "SELECT 
              t.TABLE_NAME,
              c.COLUMN_NAME
            FROM 
              information_schema.KEY_COLUMN_USAGE k
              INNER JOIN information_schema.TABLES t ON k.TABLE_SCHEMA = t.TABLE_SCHEMA AND k.TABLE_NAME = t.TABLE_NAME
              INNER JOIN information_schema.COLUMNS c ON t.TABLE_SCHEMA = c.TABLE_SCHEMA AND t.TABLE_NAME = c.TABLE_NAME
            WHERE 
              k.CONSTRAINT_SCHEMA = :schema 
              AND k.CONSTRAINT_NAME = 'PRIMARY' 
              AND k.COLUMN_NAME = :primaryKey
            ORDER BY 
              c.ORDINAL_POSITION
            LIMIT 3;";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':schema', $this->schema);
    $stmt->bindParam(':primaryKey', $this->primaryKey);
    $stmt->execute();
    $this->options = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $this->table = $row['TABLE_NAME'];
      array_push($this->options, $row['COLUMN_NAME']);
    }
    $this->sql = "SELECT ";
    foreach ($this->options as $option) {
      $this->sql .= $option . ", ";
    }
    $this->sql = substr($this->sql, 0, -2);
    $this->sql .= " FROM $this->table";
    $this->sql .= " ORDER BY $this->primaryKey DESC;";
  }

  public function ejecutarConsultaI()
  {
    $sql = "SELECT 
              t.TABLE_NAME,
              c.COLUMN_NAME
            FROM 
              information_schema.KEY_COLUMN_USAGE k
              INNER JOIN information_schema.TABLES t ON k.TABLE_SCHEMA = t.TABLE_SCHEMA AND k.TABLE_NAME = t.TABLE_NAME
              INNER JOIN information_schema.COLUMNS c ON t.TABLE_SCHEMA = c.TABLE_SCHEMA AND t.TABLE_NAME = c.TABLE_NAME
            WHERE 
              k.CONSTRAINT_SCHEMA = :schema 
              AND k.CONSTRAINT_NAME = 'PRIMARY' 
              AND k.COLUMN_NAME = :primaryKey
            ORDER BY 
              c.ORDINAL_POSITION";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':schema', $this->schema);
    $stmt->bindParam(':primaryKey', $this->primaryKey);
    $stmt->execute();
    $this->options = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $this->table = $row['TABLE_NAME'];
      array_push($this->options, $row['COLUMN_NAME']);
    }
    $this->sql = "SELECT ";
    foreach ($this->options as $option) {
      $this->sql .= $option . ", ";
    }
    $this->sql = substr($this->sql, 0, -2);
    $this->sql .= " FROM $this->table";
    $this->sql .= " WHERE $this->primaryKey = :$this->primaryKey";
    $this->sql .= " ORDER BY $this->primaryKey DESC;";
  }

  public function modelo()
  {
    $sql = $this->sql;
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function crearDesplega()
  {
    $rows = $this->modelo();
?>
    <label for="<?php echo $this->primaryKey; ?>"><?php echo $this->primaryKey; ?></label>
    <select name="<?php echo $this->primaryKey; ?>" id="<?php echo $this->primaryKey; ?>">
      <?php
      foreach ($rows as $row) {
      ?>
        <option value="<?php echo $row[$this->primaryKey]; ?>"><?php echo $row[$this->primaryKey]; ?> - <?php echo $row[$this->options[1]]; ?></option>
      <?php
      }
      ?>
    </select>
<?php
  }

  public function crearDesplegaModificar()
  {
    $rows = $this->modelo();
?>
    <label for="<?php echo $this->primaryKey; ?>u"><?php echo $this->primaryKey; ?></label>
    <select name="<?php echo $this->primaryKey; ?>" id="<?php echo $this->primaryKey; ?>">
      <?php
      foreach ($rows as $row) {
      ?>
        <option value="<?php echo $row[$this->primaryKey]; ?>"><?php echo $row[$this->primaryKey]; ?> - <?php echo $row[$this->options[1]]; ?></option>
      <?php
      }
      ?>
    </select>
<?php
  }

  public function crearCadena($base)
  {
    $option = $this->options[1];
    $dsn = "mysql:host=localhost;dbname=".$base;
    $username = 'root';
    $password = "";
    $str = "<?php\n";
    $str .= "\$pdo = new PDO('$dsn', '$username', '$password');\n";
    $str .= "\$option = '$option';\n";
    $str .= "\$sql = '$this->sql';\n";
    $str .= "\$stmt = \$pdo->prepare(\$sql);\n";
    $str .= "\$stmt->execute();\n";
    $str .= "\$rows = \$stmt->fetchAll(PDO::FETCH_ASSOC);\n";
    $campo = substr($this->primaryKey, 3)."_id";
    $str .= "?>\n";
    $str .= "<label for=\"$campo\">$campo</label>\n";
    $str .= "<select name=\"$campo\" id=\"$campo\" class=\"form-control input-sm\" required=\"\">\n";
    $str .= "<?php\n";
    $str .= "foreach (\$rows as \$row) {\n";
    $str .= "?>\n";
    $str .= "  <option value=\"<?php echo \$row['$this->primaryKey']; ?>\"><?php echo \$row['$this->primaryKey']; ?> - <?php echo \$row['$option']; ?></option>\n";
    $str .= "<?php\n";
    $str .= "}\n";
    $str .= "?>\n";
    $str .= "</select>\n";
    /*
    $archivo = fopen("prueba_$this->table.php", "w+b");
    if ($archivo == false) {
      echo "Error al crear el archivo";
    } else {
      fwrite($archivo, $str);
      fflush($archivo);
    }
    fclose($archivo);    
    */
    return $str;
  }

  public function crearCadenaModificar($base)
  {
    $option = $this->options[1];
    $dsn = "mysql:host=localhost;dbname=".$base;
    $username = 'root';
    $password = "";
    $str = "<?php\n";
    $str .= "\$pdo = new PDO('$dsn', '$username', '$password');\n";
    $str .= "\$option = '$option';\n";
    $str .= "\$sql = '$this->sql';\n";
    $str .= "\$stmt = \$pdo->prepare(\$sql);\n";
    $str .= "\$stmt->execute();\n";
    $str .= "\$rows = \$stmt->fetchAll(PDO::FETCH_ASSOC);\n";
    $campo = substr($this->primaryKey, 3)."_id";
    $str .= "?>\n";
    $str .= "<label for=\"".$campo."u\">$campo</label>\n";
    $str .= "<select name=\"".$campo."u\" id=\"".$campo."u\" class=\"form-control input-sm\" required=\"\">\n";
    $str .= "<?php\n";
    $str .= "foreach (\$rows as \$row) {\n";
    $str .= "?>\n";
    $str .= "  <option value=\"<?php echo \$row['$this->primaryKey']; ?>\"><?php echo \$row['$this->primaryKey']; ?> - <?php echo \$row['$option']; ?></option>\n";
    $str .= "<?php\n";
    $str .= "}\n";
    $str .= "?>\n";
    $str .= "</select>\n";
    /*
    $archivo = fopen("prueba_$this->table.php", "w+b");
    if ($archivo == false) {
      echo "Error al crear el archivo";
    } else {
      fwrite($archivo, $str);
      fflush($archivo);
    }
    fclose($archivo);    
    */
    return $str;
  }

  public function crearCadenaListar($base)
  {
    $dsn = "mysql:host=localhost;dbname=".$base;
    $username = 'root';
    $password = "";
    $str = "<?php\n";
    $str .= "\$pdo = new PDO('$dsn', '$username', '$password');\n";
    $str .= "\$sql = '$this->sql';\n";
    $str .= "\$stmt = \$pdo->prepare(\$sql);\n";
    $str .= "\$stmt->bindParam(\":".$this->options[0]."\", \$".substr($this->options[0], 3)."_id);\n";
    $str .= "\$stmt->execute();\n";
    $str .= "\$rows = \$stmt->fetchAll(PDO::FETCH_ASSOC);\n";
    $campo = substr($this->primaryKey, 3)."_id";
    $str .= "?>\n";
    $str .= "<div class=\"table-responsive\">\n";
    $str .= "<table class=\"table table-hover table-condensed\">\n";
    $str .= "<?php\n";
    $str .= "foreach (\$rows as \$row) {\n";
    foreach ($this->options as $option) {
      if(substr($option,-3)=="_id"){
        $str .= "\$$option = \$row['$option'];\n";
      }
    }
    $str .= "?>\n";
    $str .= "<tr>\n";
    $str .= "<td style=\"background-color: #0088ff; color: #eaeaea;\" colspan=2><b>".substr($this->options[0],3)."</b></td>\n";
    $str .= "</tr>\n";
    foreach ($this->options as $option) {
      if(substr($option,0, 3)!=="id_" && substr($option,-3)!=="_id"){
        $str .= "  <tr>\n";
        $str .= "    <td>$option:</td>\n";
        $str .= "    <td><?php echo \$row['$option']; ?></td>\n";
        $str .= "  </tr>\n";
      }
    }
    $str .= "<?php\n";
    $str .= "}\n";
    $str .= "?>\n";
    $str .= "</table>\n";
    $str .= "</div>\n";
    foreach ($this->options as $option) {
      if(substr($option,-3)=="_id"){
        $str .= crearLista($base, "id_".substr($option, 0, -3));
      }
    }
    return $str;
  }

  public function crearMetodo($base)
  {
    $dsn = "mysql:host=localhost;dbname=".$base;
    $username = 'root';
    $password = "";
    $str = "\n    function ".substr($this->options[0], 3)."Id(int \$".substr($this->options[0], 3)."Id)\n    {\n";
    $str .= "        \$pdo = new PDO('$dsn', '$username', '$password');\n";
    $str .= "        \$sql = '$this->sql';\n";
    $str .= "        \$stmt = \$pdo->prepare(\$sql);\n";
    $str .= "        \$stmt->bindParam(\":".$this->options[0]."\", \$".substr($this->options[0], 3)."Id);\n";
    $str .= "        \$stmt->execute();\n";
    $str .= "        \$rows = \$stmt->fetchAll(PDO::FETCH_ASSOC);\n";
    $str .= "        return \$rows;\n";
    $str .= "    }\n";
    return $str;
  }

  public function crearMetodoController($base)
  {
    $dsn = "mysql:host=localhost;dbname=".$base;
    $username = 'root';
    $password = "";
    $str = "\n    function ".substr($this->options[0], 3)."Id(int \$".substr($this->options[0], 3)."Id)\n".
    "    {\n".
    "        include \"../../model/Model".ucfirst(str_replace("_", "", $this->table)).".php\";\n".
    "        \$model = new Model".ucfirst(str_replace("_", "", $this->table))."();\n".
    "        return \$model->".substr($this->options[0], 3)."Id(\$".substr($this->options[0], 3)."Id);\n".
    "    }\n";
    return $str;
  }
}

function crearDesplegable(string $base, string $campo)
{
  $dsn = 'mysql:host=localhost;dbname='.$base;
  $username = 'root';
  $password = '';
  $pdo = new PDO($dsn, $username, $password);
  $selectDB = new SelectDB($pdo, $base, $campo);
  $selectDB->ejecutarConsulta();
  return $selectDB->crearCadena($base);
}

function crearDesplegableModificar(string $base, string $campo)
{
  $dsn = 'mysql:host=localhost;dbname='.$base;
  $username = 'root';
  $password = '';
  $pdo = new PDO($dsn, $username, $password);
  $selectDB = new SelectDB($pdo, $base, $campo);
  $selectDB->ejecutarConsulta();
  return $selectDB->crearCadenaModificar($base);
}

function crearLista(string $base, string $campo)
{
  $dsn = 'mysql:host=localhost;dbname='.$base;
  $username = 'root';
  $password = '';
  $pdo = new PDO($dsn, $username, $password);
  $selectDB = new SelectDB($pdo, $base, $campo);
  $selectDB->ejecutarConsultaI();
  return $selectDB->crearCadenaListar($base);
}

function crearMetodo(string $base, string $campo)
{
  $dsn = 'mysql:host=localhost;dbname='.$base;
  $username = 'root';
  $password = '';
  $pdo = new PDO($dsn, $username, $password);
  $selectDB = new SelectDB($pdo, $base, $campo);
  $selectDB->ejecutarConsultaI();
  return $selectDB->crearMetodo($base);
}

function crearMetodoController(string $base, string $campo)
{
  $dsn = 'mysql:host=localhost;dbname='.$base;
  $username = 'root';
  $password = '';
  $pdo = new PDO($dsn, $username, $password);
  $selectDB = new SelectDB($pdo, $base, $campo);
  $selectDB->ejecutarConsultaI();
  return $selectDB->crearMetodoController($base);
}