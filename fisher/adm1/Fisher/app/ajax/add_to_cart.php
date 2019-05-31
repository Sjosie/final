<?php

  session_start();

  require('../functions/connect.php');
  require('../functions/cutText.php');
  require('../functions/get_link.php');

  $idItem      = $_REQUEST['id_item'];
  $typeItem    = $_REQUEST['type'];
  $arrayName   = 'id'.$idItem.$typeItem;

  if ( empty($_REQUEST['count']) ) {
    $countItem = 1;
  } else {
    $countItem = $_REQUEST['count'];
  }

  if ( $_REQUEST['delete'] != true ) {

    if ( $typeItem == 'default' ) {
      $query        = "SELECT * FROM `product` WHERE `id_product` = $idItem";
    } elseif ( $typeItem == 'rent' ) {
      $query        = "SELECT * FROM `product_rent` WHERE `id_product_rent` = $idItem";
    }

    $item_q       = mysqli_query($connection, $query);

    $item         = mysqli_fetch_assoc($item_q);
    
    if ( !file_exists('../img/items/'.$item['link_image']) or empty($item['link_image']) ) {
      $item['link_image']  = 'img/items/template.png';
      $item['name_alt']   =  'Изображение временно отсутствует';
    } else {
      $item['link_image']    = 'img/items/'.$item['link_image'];
      $item['name_alt']   = 'Товар: '.$item['name'];
    }

    if ( empty($_SESSION['products'][$arrayName]) ) {
      $array2 = array (
        $arrayName => array (
          'product_name'=> $item['product_name'],
          'link_image'  => $item['link_image'],
          'price'       => $item['price'],
          'name_alt'    => $item['name_alt'],
          'count'       => $countItem,
          'id'          => $idItem,
          'type'        => $typeItem,
        ),
      );
  
      $_SESSION['products'] = array_merge($_SESSION['products'], $array2);
  
    } else {
      $_SESSION['products'][$arrayName]['count'] = $_SESSION['products'][$arrayName]['count'] + $countItem;
    }

  }

  //$_SESSION['products'] = array();exit();

  if ( $_REQUEST['delete'] == true ) {
    unset($_SESSION['products'][$arrayName]);
  }

?>

<div class="current-items">
  <span><?php print(count($_SESSION['products'])); ?></span> товара в вашей корзине
</div>
<div class="main">
  <?php
    $totalPrice = 0;
    $i == 0;
    foreach (array_reverse($_SESSION['products']) as $value) {
      $name = cutText($value['product_name'], 35);
      $totalPrice = $totalPrice + $value['price']*$value['count'];

      $i++;
      if ( $i > 2 ) {
        $i = count($_SESSION['products']) - ($i - 1);
        if ($i == 1) {
          print('И еще '. $i .' товар');
        } elseif ( $i > 1 and $i < 5 ) {
          print('И еще '. $i .' товара');
        } else {
          print('И еще '. $i .' товаров');
        }
        break;
      }
      ?>
      <div class="item-cart" data-id="<?php print($value['id']); ?>">
        <div class="wrapp">
          <div class="img_wrapp">
            <img src="<?php print($value['link_image']); ?>" alt="<?php print($value['name_alt']); ?>">
          </div>
          <div class="content">
            <div class="name">
            <a href="<?php print('item.php?=id='.$value['id'].'&type='.$value['type']); ?>"><?php print($name); ?></a>
            </div>
            <div class="count">
              Кол-во:<span> <?php print($value['count']); ?></span>
            </div>
            <div class="price">
              <span class="value"><?php print($value['price']*$value['count']); ?></span>
              <span> руб.</span>
            </div>
          </div>
        </div>
        <div class="delete">
          <button data-type="<?php print($value['type']); ?>" data-id="<?php print($value['id']); ?>">&#10006;</button>
        </div>
      </div>
      <?php
    }
  ?>
</div>
<div class="total">
  <span class="total-span">Всего:</span>
  <span class="value"><span><?php print($totalPrice); ?></span> руб.</span>
</div>
<div class="links">
  <?php get_link('cart.php', 'Корзина', 'black');
        get_link('cart.php', 'Оформить', 'blue');
  ?>
</div>
