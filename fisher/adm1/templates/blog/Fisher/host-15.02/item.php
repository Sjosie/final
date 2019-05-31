<?php 

	session_start();

	require('functions/connect.php');
	require('functions/get_link.php');
	require('functions/get_line.php');
	require('functions/get_title.php');
	require('functions/get_rating.php');

  $itemId    = $_GET['id'];
  $itemType  = $_GET['type'];

  if ( $itemType == 'rent' ) {
    $query         = "SELECT * FROM `product_rent` AS `p`
                      LEFT JOIN (
                        SELECT `id`, `name` FROM `menu` 
                      ) AS `m` ON `m`.`id` = `p`.`id_category` WHERE
                      `p`.`id_product_rent` = $itemId";
    $itemType_t = 'Прокат';
  } elseif ( $itemType == 'default' ) {
    $query         = "SELECT * FROM `product` AS `p`
                      LEFT JOIN (
                        SELECT * FROM `menu` 
                      ) AS `m` ON `m`.`id` = `p`.`id_category` WHERE
                      `p`.`id_product` = $itemId";
    $itemType_t = 'Продажа';
  }

  $result    = mysqli_query($connection, $query);
  $item       = mysqli_fetch_assoc($result);

  if ( !file_exists('img/items/'.$item['link_image']) or empty($item['link_image']) ) {
    $item['link_image']  = 'img/items/template.png';
    $itemName_alt   =  'Изображение временно отсутствует';
  } else {
    $item['link_image']    = 'img/items/'.$item['link_image'];
    $itemName_alt   = 'Товар: '.$item['product_name'];
  }


?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Товар: <?php print($item['product_name']); ?></title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="<?php print($item['link_image']); ?>">
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

  <link rel="stylesheet" href="css/item.min.css">
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

  <div class="main-info">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="img_wrapp">
           <img src="<?php print($item['link_image']); ?>" alt="<?php print($itemName_alt); ?>">
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="wrapp">
            <div class="title">
              <span><?php print($item['product_name']); ?></span>
            </div>
            <?php get_rating($item['rating']); ?>
            <div class="price">
              <?php
                if ( $itemType == 'rent' ) {
                  print($item['price'] . ' руб/день');
                  $itemIdLink = $item['id_product_rent'];
                  $itemType   = 'rent';
                } elseif (( $itemType == 'default' )) {
                  print($item['price'] . ' руб.');
                  $itemIdLink = $item['id_product'];
                  $itemType   = 'default';
                }

                if ( $product['sale'] == 'true' ) {
                  print( '<span class="old-price">' . $product['old_price'] . ' руб.</span>');
                }
              ?>
            </div>
            <div class="description">
              <p><?php print($item['description']); ?></p>
            </div>
            <div class="links">
              <div class="input_wrapp">
                <input type="number" placeholder="1">
                <div class="button_wrapp">
                  <button class="plus">
                    <img src="img/icons/down-arrow.png" alt="Arrow">
                  </button>
                  <button class="minus">
                    <img src="img/icons/down-arrow.png" alt="Arrow">
                  </button>
                </div>
              </div>
              <?php get_link($itemId, 'Добавить в корзину', 'blue add-to-cart'); ?>
            </div>
            <div class="info">
              <div>
                <span>Категория: </span> <a href="category.php?id=<?php print($item['id']); ?>"><?php print($item['name']); ?></a>
              </div>
              <div class="type">
                <span>Тип: </span> <a href="#" data-type="<?php print($itemType); ?>"><?php print($itemType_t); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

	<?php
	
	if ( !empty($item['text']) or !empty($item['video_link']) ) {
		?>
		<section class="tabs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="tabs_wrapp" id="item-tabs">
							<ul class="tabs">
								
								<?php
									if ( !empty($item['text']) ) {	
										print('<li><a href="#tabs-item-1" data-id="">Описание</a></li>');
									} 
									if ( !empty($item['video_link']) ) {
										print('<li><a href="#tabs-item-2" data-id="">Видео</a></li>');
									}
								?>
								
							</ul>
						
							<?php
								if ( !empty($item['text']) ) {	
									print('<div class="tab-container" id="tabs-item-1">'.$item['text'].'</div>');
								} 
								if ( !empty($item['video_link']) ) {
									print('<div class="tab-container" id="tabs-item-2">
									<div class="thumb-wrap">
										<iframe width="100%" src="https://www.youtube.com/embed/'.$item['video_link'].'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									</div>
								</div>');
								}
							?>
							
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

	?>

  <section class="sales-block">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <?php get_title('Cопутствующие товары'); ?>
        </div>
      </div>
      <div class="row">
        <?php 
        
        if ( $itemType == 'rent' ) {
          $query     = "SELECT * FROM `product_rent` WHERE `id_category` = ".$item['id']." LIMIT 4";
        } elseif ( $itemType == 'default' ) {
          $query   = "SELECT * FROM `product` WHERE `id_category` = ".$item['id']." LIMIT 4";
        }

        $result  = mysqli_query($connection, $query);

        while ( $product = mysqli_fetch_assoc($result) ) {

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
                      <?php get_link($productIdLink, 'В корзину', 'white add-to-cart'); ?>
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
      </div>
    </div>
  </section>

  <?php require('footer.php'); ?>

 <script src="js/scripts-items.min.js"></script>
  <script>

  </script>

</body>
</html>