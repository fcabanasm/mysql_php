<?php
  function mysqli_field_name($result, $field_offset){
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
  }

  include_once "key.php";
  if( isset($_POST['limit'])&&isset($_POST['valor'])&&isset($_POST['campo']) ){
    $limit = $_POST['limit'];
    $tabla = $_POST['table_name'];
    $campo[] = $_POST['campo'];
    $valor[] = $_POST['valor'];
    $fcampo = $campo[0][0];
    $fvalor = $valor[0][0];
    if (isset($_POST['email_status'])) {
      $email_status = $_POST['email_status'];
    }
    else {
      $email_status = "three";
    }
    $con= mysqli_connect($host, $username,$password,$db_name) or die(mysql_error());

    //2CSV
    $filename = "$fcampo-$fvalor ($limit regs).csv";
    $fp = fopen('php://output', 'w');
    $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$db_name' AND TABLE_NAME='$tbl_persons'";
    $result = mysqli_query($con,$query);
    if (!$result) {
      die(mysqli_error($con));
    }
    while ($row = $result->fetch_assoc()) {
      $header[] = $row['COLUMN_NAME'];
    }

    header('Content-type: application/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename);
    fputcsv($fp, $header);

    $sql = "select * from $tabla
           where ($fcampo like '$fvalor')"
           .($email_status == "one" ? " AND (email_status = 'Valid')":'')
           .($email_status == "two" ? " AND (email_status = 'Valid' OR email_status = 'Uncertain')":'')
           .(count($campo[0]) > 1 ? " AND (".$campo[0][1]." like '".$valor[0][1]."')":"")
           .(count($campo[0]) > 2 ? " AND (".$campo[0][2]." like '".$valor[0][2]."')":"")
           .(count($campo[0]) > 3 ? " AND (".$campo[0][3]." like '".$valor[0][3]."')":"")
           .(count($campo[0]) > 4 ? " AND (".$campo[0][4]." like '".$valor[0][4]."')":"")
           .(count($campo[0]) > 5 ? " AND (".$campo[0][5]." like '".$valor[0][5]."')":"")
           ." ORDER BY RAND() LIMIT $limit"
    ;//$sql

    $result = mysqli_query($con,$sql);
    if (!$result) {
    	die('ERROR. ' .mysqli_error($con));
    }
    while ($row = $result->fetch_assoc()) {
    	fputcsv($fp, $row);
    }
    fclose($fp);
    exit();

  }
?>
