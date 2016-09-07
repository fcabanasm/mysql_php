<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="form-horizontal" action="anl.php" method="post">
    <div class="col-md-12">
      <div class="form-group">
        <label for="table" class="control-label ">Num: </label>
        <input type="number" class="form-control" name="num" id="num" value="" min="0" required="true">
      </div>
     <div class="form-group">
       <label for="login" class="control-label "></label>
       <button type="submit" class="btn btn-primary">Raiz</button>
     </div>
    </div>
    </form>
  </body>
</html>
<?php
  if( isset($_POST['num']) ){
    $num = $_POST['num'];
    $num = intval($num);
    $n = 0;
    $n1 = 0;
    $cont = 1;
    if ($num == 0) {
      echo $num;
    }
    else {
      $n = ($num/2)+1;
      $n1 = ($n + ($num/$n))/2;
    }
    while ($n1<$n) {
      echo "<br>Iteración: ".$cont."<br>";
      echo "n= ".$n;
      echo "<br>";
      echo" n1= ".$n1;
      echo "<br>";
      $n = $n1;
      $n1 = ($n + ($num/$n))/2;
      $cont+=1;
    }
    echo "<br>Raiz parte entera: ".intval($n);
  }
?>
