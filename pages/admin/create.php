<!DOCTYPE html>
<html>
<?php
  include('../pages/includes/head.php');
?>
  <body>
    <?php
      include('../pages/includes/header.php');
    ?>

    <div class="col-2">h</div>
    <div class="col-8 product_table">
      <h3>Create new product</h3>
      <?php
        echo $form;
      ?>
    </div>
    <div class="col-2">h</div>
  </body>
</html>

<script>

    var elements = document.querySelectorAll("select");

    elements[0].setAttribute("name", "platform_id");
    elements[1].setAttribute("name", "brand_id");


</script>
