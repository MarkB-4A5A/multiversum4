<!DOCTYPE html>
<html>
    <?php
      include('pages/includes/head.php');
    ?>
  <body>
    <section class="row">
      <?php
        include('pages/includes/header.php');
      ?>
      <div class="col-2"></div>
      <div class="col-8 products_container" id="productContent">
        <?php
          echo $products;
        ?>
      </div>
      <div class="col-2"></div>
      <div class="col-2"></div>
      <div class="col-8 pagination">
      <?php echo $pagination ?>
      </div>
      <div class="col-2"></div>
    </section>
    <script src="/javascript/main.js"></script>
  </body>
</html>
