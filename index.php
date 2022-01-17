<?php include "common/header.php"; ?>

<?php 
  // Get products
  $products = $app->products();
?>
  <!-- Page Content -->
  <div class="container">

    <div class="row">
      <div class="col-lg-12">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid item-img" src="https://s4.scoopwhoop.com/anj/beard-benefit-9/245410305.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid item-img" src="https://www.telegraph.co.uk/content/dam/news/2019/05/18/TELEMMGLPICT000197621417_trans_NvBQzQNjv4Bq9ZgHWGWfvdgN-PUV7CBULV0zNzLfrznGRYECrXmb1BQ.jpeg?imwidth=1400" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid item-img" src="https://www.donjuanpomade.com/wp-content/uploads/2016/10/don-juan-pomade-beard-and-mustache-2.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">

          <?php foreach ($products as $product): ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 view">
                <div class="clickable"><img class="card-img-top" src="<?php echo $product["image"]; ?>" title="Add to cart" alt="Add to cart"></div>
                <div class="card-body">
                  <h4 class="card-title">
                  <div class="clickable text-primary"><?php echo $product["name"]; ?></div>
                  </h4>
                  <h5>€<?php echo $product["price"]; ?></h5>
                  <p class="card-text"><?php echo $product["description"]; ?></p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
                <div class="overlay clickable" onclick="addProduct(<?php echo $product['id']; ?>, '<?php echo $product['name']?>', <?php echo $product['price']?>)">
                  <div class="overlay-text">Click to add to cart</div>
                </div>
              </div>
            </div>
          <?php endforeach;?>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
  <script>
    const products = {};
    let user = null;

    function addProduct(id, name, price) {
      const cart = document.querySelector('#cart');
      const items = cart.innerHTML;
      cart.innerHTML = Number(items) + 1;
      if (products[id]) {
        products[id].price += price;
        products[id].qty += 1; 
      } else {
        products[id] = {
          name,
          price,
          original_price: price,
          qty: 1,
        }
      }
    }
  </script>
  <?php include "common/footer.php"; ?>