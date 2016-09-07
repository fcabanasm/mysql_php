<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>2CSV</title>
  </head>
  <body>
    <form class="form-horizontal" action="actions.php" method="post">
    <div class="col-md-12">
      <div class="form-group">
        <label for="table" class="control-label ">Registros</label>
        <input type="number" class="form-control" name="limit" value="100" min="1" required="true">
      </div>
      <div class="form-group">
        <label for="table" class="control-label ">Región</label>
        <input type="number" class="form-control" name="region" value="13" min="1" required="true">
      </div>
     <div class="form-group">
       <label for="login" class="control-label "></label>
       <button type="submit" class="btn btn-primary">2CSV</button>
     </div>
     <div class="form-group">
       <label for="Email-Status" class="control-label ">Email Status: </label>
       <label class="radio-inline"><input type="radio" name="email_status" value="one" checked=true>Solo Validos</label>
       <label class="radio-inline"><input type="radio" name="email_status" value="two">Validos y Inciertos</label>
       <label class="radio-inline"><input type="radio" name="email_status" value="three">Cualquiera (incluye invalidos)</label>
     </div>
    </div>
    </form>
    <?php
    $directorio = opendir("/home/fcabanasm/Escritorio/dev/php_server/csv");
    while ($archivo = readdir($directorio)) {
      #echo $archivo;
    }
       ?>
  </body>
</html>
