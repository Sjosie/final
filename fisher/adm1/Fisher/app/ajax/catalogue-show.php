<?php

  require('../functions/connect.php');
  require('../functions/cutText.php');
  require('../functions/get_link.php');
  require('../functions/get_rating.php');
  require('../functions/get_cat_recursive.php');

  $type = $_POST['type'];
  $id_category = $_POST['id_category'];
  if ( !empty($_POST['output_type']) ) {
    $output_type = $_POST['output_type'];
  } else {
    $output_type = 'grid';
  }
  $count_items = $_POST['count_items'];
  $sort = $_POST['sort'];
  $page = $_POST['page'];

  //Test
  // $count_items = 1;

  $left_limit = $page * $count_items - $count_items;

  $query = "SELECT * FROM `menu`";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $menu[$row['id']]= $row;
  }

  $categories_array = array();
  get_cat_recursive($id_category, $menu, $categories_array);
  
  $conditions = "";
  if ( !empty($categories_array) ) {

    $conditions .= "`id_category` IN ('".$id_category."'";
    foreach ($categories_array as $value) {
      $conditions .= ", '".$value."' ";
    }
    $conditions .= ")";

  } else {
    $conditions .= "`id_category` = ".$id_category." ";
  }
  
  if ( !empty($_POST['id_brand']) ) {
    $conditions .= "AND `id_brand` =".$_POST['id_brand']." ";
  }
  if ( !empty($_POST['right_limit']) and !empty($_POST['left_limit']) ) {
    $conditions .= "AND `price` >= ".$_POST['left_limit']." AND `price` <= ".$_POST['right_limit']." ";
  }

  if ( $type == 'default' ) {
    $query = "SELECT *, (
      SELECT COUNT(*)  FROM `product` WHERE $conditions
    ) AS `count` FROM `product` WHERE $conditions ORDER BY `$sort` ASC LIMIT $left_limit, $count_items";
  } elseif ( $type == 'rent' ) {
    $query = "SELECT *, (
      SELECT COUNT(*)  FROM `product_rent` WHERE $conditions
    ) AS `count` FROM `product_rent` WHERE $conditions ORDER BY `$sort` ASC LIMIT $left_limit, $count_items";
  }

  $result = mysqli_query($connection, $query);

  if ( mysqli_num_rows($result) == 0 ) {
    ?>
    <div class="eror_wrapp">
      <h4>Товаров с такими условиями не найдено</h4>
      <?php get_link('index.php', 'Продолжить покупки', 'blue'); ?>
    </div>
    <?php
    exit();
  }

  if ( $output_type == 'grid') {

    while ( $product = mysqli_fetch_assoc($result) ) {

      $count_items_request = $product['count'];

      if ( $type = 'default') {
        $productId = $product['id_product'];
      } elseif ( $type = 'rent' ) {
        $productId = $product['id_product_rent'];
      }

      $product['product_name'] = cutText($product['product_name'], 80);
      
      if ( !file_exists('../img/items/'.$product['link_image']) or empty($product['link_image']) ) {
        $product['link_image']  = 'img/items/template.png';
        $productName_alt   =  'Изображение временно отсутствует';
      } else {
        $product['link_image']    = 'img/items/'.$product['link_image'];
        $productName_alt   = 'Товар: '.$product['product_name'];
      }
      
      ?>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
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
                  <?php get_link('item.php?id='.$productIdLink.'&type='.$productType, 'Подробнее', 'white', 'target="_blank"'); ?>
                </li>
                <li>
                  <?php get_link('', 'В корзину', 'white add-to-cart', 'data-type='.$productType.' data-id='.$productIdLink, 'button'); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>  
      <?php
      
    }

  } elseif ( $output_type == 'list' ) {

    while ( $product = mysqli_fetch_assoc($result) ) {

      $count_items_request = $product['count'];

      if ( $type = 'default') {
        $productId = $product['id_product'];
      } elseif ( $type = 'rent' ) {
        $productId = $product['id_product_rent'];
      }

      $product['product_name'] = cutText($product['product_name'], 80);
      
      if ( !file_exists('../img/items/'.$product['link_image']) or empty($product['link_image']) ) {
        $product['link_image']  = 'img/items/template.png';
        $productName_alt   =  'Изображение временно отсутствует';
      } else {
        $product['link_image']    = 'img/items/'.$product['link_image'];
        $productName_alt   = 'Товар: '.$product['product_name'];
      }
      
      ?>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="wrapp">
          <div class="item-list">
            <div class="img_wrapp"><?php
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
              <img src="<?php print($product['link_image']); ?>" alt="<?php print($productName_alt); ?>">
            </div>
            <div class="content">
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
              <div class="text">
                <p><?php print(cutText($product['description'], 200)); ?></p>                
              </div>
              <div class="hover">
                <ul>
                  <li>
                    <?php get_link('item.php?id='.$productIdLink.'&type='.$productType, 'Подробнее', 'black', 'target="_blank"'); ?>
                  </li>
                  <li>
                    <?php get_link('', 'В корзину', 'blue add-to-cart', 'data-type='.$productType.' data-id='.$productIdLink, 'button'); ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>  
      <?php
      
    }
  }

  $count_page = ceil($count_items_request / $count_items);

  //Test
  // $page = 5;
  // $count_page = 7;
  //

  if ( $count_page > 3 ) {

    $i = $page - 1;

    if ( $i <= 0 ) {
      $i = 1;
      $page_right_limit = 3;
    } else {
      $page_right_limit = $i + 2;
    }
    
  } else {

    $i = 1;
    $page_right_limit = $count_page;

  }

  if ( $count_page == $page ) {
    $page_right_limit = $page;
    
    $i = $page - 2;
    if ($i <= 0) {
      $i = 1;
    }
  }

  $pagination = '
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <ul class="pagination">
        <span>Страница: </span>
  ';
  if ( $page - 2 > 0 ) {
    $pagination .= '
      <li><button class="arrow left" data-page="1">1</button></li>
    ';
  }

  for ($i; $i <= $page_right_limit; $i++) { 

    if ( $i == $page ) {
      $pagination .= '
        <li class="active"><button data-page="'.$i.'">'.$i.'</button></li>
      ';
    } else {
      $pagination .= '
        <li><button data-page="'.$i.'">'.$i.'</button></li>
      ';
    }    

    if ( $i == $page_right_limit and $i - 1 < $count_page and $count_page != $page ) {
      $pagination .= '
        <li><button class="arrow right" data-page="'.$count_page.'">'.$count_page.'</button></li>
      ';
    }

  }

  

  $pagination .= '
      </ul>
    </div>
  ';

  print($pagination);
  
?>
