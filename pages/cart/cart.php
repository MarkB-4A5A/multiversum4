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
        <div class="col-6 cart_container">
          <header class="cart_header ">Winkelwagentje</header>
          <main id="content" class="cart_main">
            <?php
              echo $content;
            ?>
          </main>
          <footer class="cart_footer">
          <form method="post">
            <input type="submit" name="payment">
          </form>
          totaal: &euro;<span id="totalPrice"></span>
          </footer>
        </div>
      <div class="col-3"></div>
    </section>
    <script src="/javascript/main.js"></script>
    <script>

    </script>
  </body>
</html>
