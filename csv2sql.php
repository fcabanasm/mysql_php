<html>
<head>
<title>CSVaMySql</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>
<body>
<br>
<div class="container">
  <div class="row">
    <h1> SCRIPT CSV a Mysql </h1>
    <p> PHP para importar archivos CSV a MySql</p>
    <img src="BD.png" alt="" />
    </br>
    <div class="col-md-12" style="margin-top:2em">
      <table class='table table-hover table-bordered'>
        <thead>
          <tr>
            <th>Nombre del archivo: </th>
            <th>Columnas</th>
          </tr>
        </thead>
        <tbody>


<?php
  $directorio = opendir("/home/statdata/php_server/csv/");
  #$directorio = opendir("/home/fcabanasm/Escritorio/dev/PHP_SERVER/csv/");
  while ($archivo = readdir($directorio)) {
    if ($archivo != "." && $archivo != "..") {
          echo "<tr><td><a style='font-size: 20px;' href='/csv/$archivo' target='_blank'>".$archivo."</a></td>";

            $file = new SplFileObject("csv/".$archivo);
            echo "<td>".$file->fgets()."</td>";
            $file = null;

          echo "</tr>";
}
      }
?>
    </tbody>
    </table>
    </div>
    <form class="form-horizontal"action="csv2sql.php" method="post">
      <div class="form-group">
            <label for="table" class="control-label ">Columnas</label>
        <div class="">
            <input type="text" class="form-control" name="cols" id="cols" value="@,@,nombres,rut,rut_verificador,@,@,nacionalidad,nacimiento,sexo,civil,direccion,telf1,email,lvl_estudio,estudios,titulo">
        </div>
        @ para ignorar columna
      </div>
      <div class="form-group">
            <label for="csvfile" class="control-label ">Nombre del archivo</label>
        <div class="">
            <input type="name" class="form-control" name="csv" id="csv" value="test.csv">
        </div>
        eg. MYDATA.csv
        </div>
      <div class="col-md-12">
        <div class="col-md-6">
      <div class="form-group">
            <label for="table" class="control-label ">Header</label>
        <div class="">
          <input type="radio" name="header" id="header" value="si" checked="true"> Si<br>
          <input type="radio" name="header" id="header" value="no"> No<br>
        </div>
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
            <label for="table" class="control-label ">Separador</label>
        <div class="">
          <input type="radio" name="separador" id="separador" value="," checked="true"> , (coma)<br>
          <input type="radio" name="separador" id="separador" value=";"> ; (punto y coma)<br>
        </div>
      </div>
      </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="mysql" class="control-label ">Host</label>
    		<div class="">
            <input type="text" class="form-control" name="mysql" id="mysql" placeholder="" value="localhost">
    		</div>
        </div>
    	<div class="form-group">
            <label for="username" class="control-label ">Usuario</label>
    		<div class="">
            <input type="text" class="form-control" name="username" id="username" placeholder="" value="root">
    		</div>
        </div>
    	<div class="form-group">
            <label for="password" class="control-label ">Contraseña</label>
    		<div class="">
            <input type="password" class="form-control" name="password" id="password" placeholder="" value="europa1935">
    		</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
              <label for="db" class="control-label ">Base de datos</label>
      		<div class="">
              <input type="text" class="form-control" name="db" id="db" placeholder="" value="big_data">
      		</div>
          </div>
      	<div class="form-group">
              <label for="table" class="control-label ">Tabla</label>
      		<div class="">
              <input type="name" class="form-control" name="table" id="table" value="personas">
      		</div>
          </div>

      	<div class="form-group">
      	<label for="login" class="control-label "></label>
          <div class="">
          <button type="submit" class="btn btn-primary">Subir</button>
      	</div>
      	</div>
      </div>
    </form>
    </div>
  </div>
</div>
</body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['username'])&&isset($_POST['mysql'])&&isset($_POST['db'])&&isset($_POST['username']))
{
$sqlname=$_POST['mysql'];
$username=$_POST['username'];
$table=$_POST['table'];
if(isset($_POST['password']))
{
$password=$_POST['password'];
}
else
{
$password= '';
}

$db=$_POST['db'];
$file=$_POST['csv'];
$cons= mysqli_connect("$sqlname", "$username","$password","$db") or die(mysql_error());

$result1=mysqli_query($cons,"select count(*) count from $table");
$r1=mysqli_fetch_array($result1);
$count1=(int)$r1['count'];
//If the fields in CSV are not seperated by comma(,)  replace comma(,) in the below query with that  delimiting character
//If each tuple in CSV are not seperated by new line.  replace \n in the below query  the delimiting character which seperates two tuples in csv
// for more information about the query http://dev.mysql.com/doc/refman/5.1/en/load-data.html
$cols=$_POST['cols'];
$header=$_POST['header'];
$separador=$_POST['separador'];

$cols = preg_replace('/\s+/', '', $cols);
$cols = preg_replace('/[;]/', ',', $cols);
$head = '('.$cols.')';
$head = str_ireplace("@","@q",$head);

$sql2 = "LOAD DATA LOCAL INFILE 'csv/".$file. "'
      INTO TABLE `".$table."`
      CHARACTER SET UTF8
      FIELDS TERMINATED by '$separador'
      ENCLOSED BY '\"'".
      ($header == "si" ? '
        IGNORE 1 LINES': '')."
      ".$head."
";
#rut;rut_verificador;nombres;a_paterno;a_materno;direccion;comuna;region;cod_telf;telf1;@;@;@;@;@
#rut
#apellido
#comuna
#email
#nacionalidad
#nacimiento
#sexo
#civil
#direccion
#telf1
#nivel_estudio
#estudios
#titulo

$loaddata = mysqli_query($cons,$sql2);
if (!$loaddata) {
	die('Could not load data from file into table: ' .mysqli_error($cons));
}
$result2=mysqli_query($cons,"select count(*) count from $table");
$r2=mysqli_fetch_array($result2);
$count2=(int)$r2['count'];

$count=$count2-$count1;
if($count>0)
  echo "Success";
  echo "<b> total $count records have been added to the table $table </b> ";
}
else{
echo "Mysql Server address/Host name ,Username , Database name ,Table name , File name are the Mandatory Fields";
}

?>
</html>
