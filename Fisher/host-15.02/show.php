<?php

  require('functions/connect.php');
  require('functions/cutText.php');
  require('functions/get_link.php');
  require('functions/get_rating.php');
 
  $idCategory     = $_REQUEST['id_category'];
  $limit          = 4;

  if ( $_REQUEST['type'] == 'rent' ) {
    $query          = "SELECT * FROM `product_rent` WHERE `id_category` = $idCategory LIMIT $limit";
    $itemType       = 'rent';
  } else {
    $query          = "SELECT * FROM `product` WHERE `id_category` = $idCategory LIMIT $limit";
    $itemType       = 'default';
  }
  $product_q      = mysqli_query($connection, $query);

  while ($product = mysqli_fetch_assoc($product_q)) {

    $productId           = $product['id_product'];

    $product['product_name']        = cutText($product['product_name'], 80);
    

    if ( !file_exists('img/items/'.$product['link_image']) or empty($product['link_image']) ) {
      $product['link_image']  = 'img/items/template.png';
      $productName_alt   =  'Изображение временно отсутствует';
    } else {
      $product['link_image']    = 'img/items/'.$product['link_image'];
      $productName_alt   = 'Товар: '.$product['product_name'];
    }

    ?>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <div class="wrapp">
        <div class="item">
          <?php
            if ( !empty($product['label']) ) {
                $product['label'] = mb_strtolower($product['label']);
                if ($product['label'] == 'новинка') {
                  $productLabelColor = '#66ba16';
                } elseif ($product['label'] == 'акция') {
                  $productLabelColor = '#f94e4e';
                } else {
                  $productLabelColor = '#ccc';
                }
              ?>
              <div class="label" style="background-color: <?php print($productLabelColor); ?>;">
                <span><?php print($product['label']); ?></span>
              </div>
              <?php
            }
          ?>
          <div class="img_wrapp">
            <img src="<?php print($product['link_image']); ?>" alt="<?php print($productName_alt); ?>">
          </div>
          <div class="name"><?php print($product['product_name']); ?></div>
          <?php get_rating($product['rating']); ?>
          <div class="price">
            <?php
            if ( $_REQUEST['type'] == 'rent' ) {
              print($product['price'] . ' руб/день');
              $productIdLink = $product['id_product_rent'];
              $productType   = 'rent';
            } else {
              print($product['price'] . ' руб.');
              $productIdLink = $product['id_product'];
              $productType   = 'default';
            }

            if ( $product['sale'] == 'true' ) {
              print( '<span class="old-price">' . $product['old_price'] . ' руб.</span>');
            }
            ?>
          </div>
          <div class="hover">
            <ul>
              <li>

                <?php get_link('', 'В корзину', 'white add-to-cart', 'data-type='.$itemType.' data-id='.$productIdLink, 'button'); ?>
              </li>
              <li>
                <?php get_link('item.php?id='.$productIdLink.'&type='.$productType, 'Подробнее', 'white', 'target="_blank"'); ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>        
    <?php
  
  }

  ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <?php get_link("#id=$idCategory", 'еще', 'blue'); ?>
    </div>
  <?php

?>