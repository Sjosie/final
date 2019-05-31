<?php 

  session_start();

  require('functions/connect.php');
  require('functions/get_link.php');
  require('functions/get_line.php');
  require('functions/get_title.php');
  require('functions/get_rating.php');

  $productsRent = array_filter($_SESSION['products'], function($k) {
    return $k['type'] == 'rent';
  }, ARRAY_FILTER_USE_BOTH);
  $products = array_filter($_SESSION['products'], function($k) {
    return $k['type'] == 'default';
  }, ARRAY_FILTER_USE_BOTH);

?>
<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Корзина</title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="">
	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#252525">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#252525">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#252525">

  <link rel="stylesheet" href="css/cart.min.css">
  <style>
    input[type='number'] {
        -moz-appearance:textfield;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
  </style>
</head>

<body>

  <?php	require('header.php'); ?>

  <?php 
  
    if ( !empty($products) or !empty($productsRent) ) {
      ?>
        <section class="products">
        <?php

          if ( !empty($products) ) {
            ?>

              <div class="container some-table default">
                <div class="row">

                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="current-items sometitle">
                      <?php
                        $currentItems = count($products);
                        if ($currentItems == 1) {
                          print('Вы выбрали '. $currentItems .' товар');
                        } elseif ( $currentItems > 1 and $currentItems < 5 ) {
                          print('Вы выбрали '. $currentItems .' товара');
                        } else {
                          print('Вы выбрали '. $currentItems .' товаров');
                        }
                      ?>
                    </span>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table>
                      <thead>
                        <tr>
                          <th class="product th_mobile">Товары</th>
                          <th>Цена</th>
                          <th>кол-во</th>
                          <th>Всего</th>
                          <th class="th_mobile delete">Удалить</th>
                        </tr>
                      </thead>
                      <?php 

                        $totalProducts = 0;

                        foreach (array_reverse($products) as $value) {

                          $totalProducts = $totalProducts + $value['price']*$value['count'];
                          
                          ?>
                          <tr>
                            <td class="td_products td_mobile">
                              <div class="item-cart" data-id="<?php print($value['id']); ?>">
                                <div class="wrapp">
                                  <div class="img_wrapp">
                                    <img src="<?php print($value['link_image']); ?>" alt="<?php print($value['name_alt']); ?>">
                                  </div>
                                  <div class="content">
                                    <div class="name">
                                      <a href="<?php print('item.php?id='.$value['id'].'&type='.$value['type']); ?>"><?php print($name); ?></a>
                                    </div>
                                    <div class="price">
                                      <span class="value"><?php print($value['price']); ?></span>
                                      <span> руб.</span>
                                    </div>
                                    <div class="total-price">
                                      <span>Итого: </span>
                                      <span class="value"><?php print($value['price']*$value['count']); ?></span>
                                      <span> руб.</span>
                                    </div>
                                    <div class="count">
                                      <div class="input_wrapp">
                                        <input type="number" value="<?php print($value['count']); ?>">
                                        <div class="button_wrapp">
                                          <button class="plus">
                                            <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                          </button>
                                          <button class="minus">
                                            <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="price">
                                <span class="value"><?php print($value['price']); ?></span>
                                <span> руб.</span>
                              </div>  
                            </td>
                            <td>
                              <div class="count">
                                <div class="input_wrapp">
                                  <input type="number" value="<?php print($value['count']); ?>">
                                  <div class="button_wrapp">
                                    <button class="plus">
                                      <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                    </button>
                                    <button class="minus">
                                      <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="total-price">
                                <span class="value"><?php print($value['price']*$value['count']); ?></span>
                                <span> руб.</span>
                              </div> 
                            </td>
                            <td class="td_mobile">
                              <div class="delete">
                                <button data-id="<?php print($value['id']); ?>">&#10006;</button>
                              </div>
                            </td>
                          </tr>
                          <?php
                        }

                      ?>
                    </table>
                  </div>
                </div>
              </div>

            <?php
          }

          ?>
          

          <?php
          if ( !empty($productsRent) ) {
            ?>

            <div class="container some-table rent">
              <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <span class="current-items sometitle">
                    <?php
                      $currentItemsRent = count($productsRent);
                      if ($currentItemsRent == 1) {
                        print('Вы выбрали '. $currentItemsRent .' товар на прокат');
                      } elseif ( $currentItemsRent > 1 and $currentItemsRent < 5 ) {
                        print('Вы выбрали '. $currentItemsRent .' товара на прокат');
                      } else {
                        print('Вы выбрали '. $currentItemsRent .' товаров на прокат');
                      }
                    ?>
                  </span>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <table>
                    <thead>
                      <tr>
                        <th class="product th_mobile">Товары (Прокат)</th>
                        <th>Цена</th>
                        <th>кол-во</th>
                        <th>Всего</th>
                        <th class="th_mobile delete">Удалить</th>
                      </tr>
                    </thead>
                    <?php 

                      $totalProductsRent = 0;

                      foreach (array_reverse($productsRent) as $value) {
                        
                        $totalProductsRent = $totalProductsRent + $value['price']*$value['count'];

                        ?>
                        <tr>
                          <td class="td_products td_mobile">
                            <div class="item-cart" data-id="<?php print($value['id']); ?>">
                              <div class="wrapp">
                                <div class="img_wrapp">
                                  <img src="<?php print($value['link_image']); ?>" alt="<?php print($value['name_alt']); ?>">
                                </div>
                                <div class="content">
                                  <div class="name">
                                    <a href="<?php print('item.php?id='.$value['id'].'&type='.$value['type']); ?>"><?php print($name); ?></a>
                                  </div>
                                  <div class="price">
                                    <span class="value"><?php print($value['price']); ?></span>
                                    <span> руб.</span>
                                  </div>
                                  <div class="total-price">
                                    <span>Итого: </span>
                                    <span class="value"><?php print($value['price']*$value['count']); ?></span>
                                    <span> руб.</span>
                                  </div>
                                  <div class="count">
                                    <div class="input_wrapp">
                                      <input type="number" value="<?php print($value['count']); ?>">
                                      <div class="button_wrapp">
                                        <button class="plus">
                                          <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                        </button>
                                        <button class="minus">
                                          <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="price">
                              <span class="value"><?php print($value['price']); ?></span>
                              <span> руб.</span>
                            </div>  
                          </td>
                          <td>
                            <div class="count">
                              <div class="input_wrapp">
                                <input type="number" value="<?php print($value['count']); ?>">
                                <div class="button_wrapp">
                                  <button class="plus">
                                    <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                  </button>
                                  <button class="minus">
                                    <img src="img/icons/down-arrow-dark.png" alt="Arrow">
                                  </button>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="total-price">
                              <span class="value"><?php print($value['price']*$value['count']); ?></span>
                              <span> руб.</span>
                            </div> 
                          </td>
                          <td class="td_mobile">
                            <div class="delete">
                              <button data-id="<?php print($value['id']); ?>">&#10006;</button>
                            </div>
                          </td>
                        </tr>
                        <?php
                      }

                    ?>
                  </table>
                </div>
              </div>
            </div>
            <?php
          }
          ?>

        </section>

        <section class="record">
          <div class="container">
            <div class="row">
              
              <?php
                if ( empty($totalProducts) ) {
                  $totalProducts = 0;
                } 
                if ( empty($totalProductsRent) ) {
                  $totalProductsRent = 0;
                }
              ?>

              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <span class="sometitle">Итого:</span>
                <div class="wrapp">
                  <table>
                    <tr>
                      <td>Товары:</td>
                      <td><?php print($totalProducts); ?> руб.</td>
                    </tr>
                    <tr>
                      <td>Прокат:</td>
                      <td><?php print($totalProductsRent); ?> руб.</td>
                    </tr>
                    <tr>
                      <td>Итого:</td>
                      <td><?php print($totalProducts + $totalProductsRent); ?> руб.</td>
                    </tr>
                  </table>
                </div>
                <?php get_link('index.php', 'Продолжить покупки','black'); ?>
                <?php get_link('#form-popup', 'Оформить заказ', 'blue popup-with-form'); ?>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <span class="sometitle">
                  Как купить или взять на прокат товар:
                </span>
                <div class="text_wrapp">   
                  <p>
                    После выбора товара нажмите оформить заказ, заполните форму и нажмите отправить. В течение * минут вам перезвонят для уточнения заказа. Оплата производится при получении товара.
                  </p>
                </div>
              </div>

            </div>
          </div>
        </section>

        <div id="form-popup" class="white-popup mfp-hide">
          <form action="#">
            <?php get_title('Оформить заказ'); ?>
            <div>
              <input id="email" class="inputbox" type="email" placeholder="Ваше e-mail" required/>
            </div>
            <div>
              <input id="phone" class="inputbox" type="text" placeholder="Ваш телефон" required/>
            </div>
            <div>
              <textarea name="msg" id="msg" class="inputbox" cols="30" rows="10" placeholder="Ваше сообщение. Необязательно..."></textarea>
            </div>
            <div>
              <?php get_link('', 'Отправить','blue mail-to', 'type="submit"', 'button'); ?>
            </div>
          </form>
        </div>

      <?php
    } else {
      ?>
        <section class="stopper">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>
                  Ваша корзина пуста!
                </h2>
                <h6>
                  Выберите товар для соврешния покупки
                </h6>
                <?php get_link('index.php', 'Продолжить покупки', 'blue'); ?>
              </div>
            </div>
          </div>
        </section>
      <?php
    }
  
  ?>
  
  <?php require('footer.php'); ?>

 <script src="js/scripts-cart.min.js"></script>
  <script>

  </script>

</body>
</html>