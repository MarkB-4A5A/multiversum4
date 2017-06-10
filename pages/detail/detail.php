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
      <div class="col-3"></div>
      <div class="col-6 products_container">
    			<input type="hidden" value="<?php echo $this->detailModel->fullUrl[1] ?>">
    			<article class="content_product content_product-detail_page">
    				<?php
    					echo '<main>';
    					echo '<div class="content_image">' . $this->detailModel->showImages() . '</div>';
    					echo '<div class="content_details">';
    					echo '<h2>Specificaties<br> ' . $product[0]['product_name'] . '</h2>';
    					echo '<p> &euro; ' . round($product[0]['price'], 1) . '</p>';
    					echo '<p>' . $product[0]['description'] . '</p>';
    					echo '<p> kleur:' . $product[0]['color'] . '</p>';
    					echo '<p> bedrijfsnaam: ' . $product[0]['brand_name'] . '</p>';
    					echo '<p> refresh-rate: ' . $product[0]['rate'] . '</p>';
    					echo '<p>' . '</p>';
    					echo '<input type="hidden" id="productId" value="' . $product[0]['products_id'] . '">';
    					echo '<input type="hidden" id="productName" value="' . $product[0]['product_name'] . '">';
    					echo '<a value="' . $product[0]['products_id'] . '" class="addToShop" href="javascript:;">Bestellen</a>';
    					echo '</div>';
    					echo '</main>';
    				?>
    			</article>
        </div>
          <div class="col-3"></div>
      </section>
    <script src="/javascript/main.js"></script>
  </body>
</html>
