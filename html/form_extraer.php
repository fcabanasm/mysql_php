<?php
  $e_status = false;
 ?>
<form class="form-horizontal" action="includes/actions.php" method="post">
<div class="col-md-8">
  <h4>Extraer datos en CSV</h4>
  <div class="form-group row">
    <label for="table" class="col-xs-6 col-form-label">Cantidad de registros</label>
    <div class="col-xs-6">
      <input type="number" class="form-control" name="limit" value="100" min="1" required="true">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-xs-12">
      <h5><b>Campo</b></h5>
      <select id="campo" class="col-xs-6 col-form-group" name="campo[]">
      <?php
        foreach ($campos as &$valor) {
          if ($valor == "email_status") {
            $e_status = true;
          }
          if ($valor == "region_nro") {
            echo "<option value='$valor' selected>$valor</option>";
          }
          else {
            echo "<option value='$valor'>$valor</option>";
          }
        }
      ?>
      </select>
    <div class="col-xs-6">
      <input type="text" class="form-control" name="valor[]" value="13" required="true">
    </div>
    <div class="col-xs-12">
      <div class="input_fields_wrap"></div>
    </div>
    <button class="add_field_button">+</button>
    <div class="col-xs-12">
      <p>
        Ayuda:
      </p>
      <ul>
        <li><b>Contiene string: </b>%string%</li>
        <li><b>Comienza con string: </b>string%</li>
        <li><b>Termina con string: </b>%string</li>
      </ul>
    </div>

    </div>
  </div>

<?php
if ($e_status == true) {
  include "email_status.php";
}
?>

 <input type="hidden" name="table_name" value="<?php echo $tabla; ?>">
 <div class="form-group row">
   <div class="col-xs-8">
   <button type="submit" class="btn btn-primary">2CSV</button>
   </div>
 </div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var optionValues = [];
    var options = "";
    $('#campo option').each(function() {
        options += "<option value='"+$(this).val()+"'>"+$(this).val()+"</option>";
    });
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append("<div><a href='#' class='col-xs-1 remove_field'>X</a><select class='col-xs-5 col-form-group' name='campo[]'>"+options+"</select><div class='col-xs-6'><input type='text' class='form-control' name='valor[]' required></div></div>");
        }
        if (x == max_fields){
          $(".add_field_button").hide();
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
        if (x == max_fields){
          $(".add_field_button").hide();
        }
        else {
          $(".add_field_button").show();
        }
    })
});
</script>
