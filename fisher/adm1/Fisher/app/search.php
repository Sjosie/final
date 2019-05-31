<?php 

	session_start();

	require('functions/connect.php');
	require('functions/get_link.php');
  require('functions/get_line.php');
  require('functions/get_rating.php');
  require('functions/cutText.php');
  
  $search = $_GET['search'];
  $type = $_GET['type'];
  if ( $type == 'rent') {
    $type_name = 'Прокат';
    $type_alt = 'default';
    $type_name_alt = 'Продажа';
  } else {
    $type_name = 'Продажа';
    $type_alt = 'rent';
    $type_name_alt = 'Прокат';
  }
  
  $search = trim($search); 
  //$search = mysqli_real_escape_string($search);
  $search = htmlspecialchars($search);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Поиск по запросу: <?php print($search); ?></title>
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

  <link rel="stylesheet" href="css/search.min.css">
</head>

<body>

	<?php	require('header.php'); ?>

  <div class="main-search containing-item">
    <div class="container">
      <div class="row">
        <form action="search.php" method="get">
          <input type="text" name="search" value="<?php print($search); ?>">
          <select name="type">
            <option value="<?php print($type); ?>"><?php print($type_name); ?></option>
            <option value="<?php print($type_alt); ?>"><?php print($type_name_alt); ?></option>
          </select>
          <button type="submit">
            <img src="img/icons/search_dark.png" alt="Icon">
          </button>
        </form>
      </div>
      <div class="row ">
        <?php
        
        if ( !empty($search) ) {
    
          if ( strlen($search) < 3) {
            $text = 'Слишком короткий запрос';
          } elseif (strlen($query) > 128) {
            $text = 'Слишком длинный запрос';
          } else {
      
            if ( $type == 'rent') {
              $query = "SELECT * FROM `product_rent` WHERE 
                     `product_name` LIKE '%$search%' OR `description` LIKE '%$search%' OR `label` LIKE '%$search%'";
            } else {
              $query = "SELECT * FROM `product` WHERE 
                        `product_name` LIKE '%$search%' OR `description` LIKE '%$search%' OR `label` LIKE '%$search%'";
            }
            $result = mysqli_query($connection, $query);
      
            if ( mysqli_affected_rows($connection) > 0 ) {
      
              $row = mysqli_fetch_assoc($result);
              $num = mysqli_num_rows($result);
      
              if ( mysqli_affected_rows($connection) == 1 ) {
                $text = 'Найден ('. $num .') товар';
              } elseif ( 1 < mysqli_affected_rows($connection) and mysqli_affected_rows($connection) < 5 ) {
                $text = 'Найдено ('. $num .') единицы товара';
              } else {
                $text = 'Найдено ('. $num .') товаров';
              }
      
              do {
                $query1 = "SELECT * FROM `product` WHERE `id_product` = '$row[id_product]'";
                $name = cutText($row['product_name'], 35);
                
                if ( !file_exists('img/items/'.$row['link_image']) or empty($row['link_image']) ) {
                  $row['link_image']  = 'img/items/template.png';
                  $row['name_alt']   =  'Изображение временно отсутствует';
                } else {
                  $row['link_image']    = 'img/items/'.$row['link_image'];
                  $row['name_alt']   = 'Товар: '.$row['name'];
                }

                ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                  <div class="wrapp">
                    <div class="item">
                      <?php
                        if ( !empty($row['label']) ) {
                            $row['label'] = mb_strtolower($row['label']);
                            if ($row['label'] == 'новинка') {
                              $productLabelColor = '#66ba16';
                            } elseif ($row['label'] == 'акция') {
                              $productLabelColor = '#f94e4e';
                            } else {
                              $productLabelColor = '#ccc';
                            }
                          ?>
                          <div class="label" style="background-color: <?php print($productLabelColor); ?>;">
                            <span><?php print($row['label']); ?></span>
                          </div>
                          <?php
                        }
                      ?>
                      <div class="img_wrapp">
                        <img src="<?php print($row['link_image']); ?>" alt="<?php print($productName_alt); ?>">
                      </div>
                      <div class="name"><?php print($row['product_name']); ?></div>
                      <?php get_rating($row['rating']); ?>
                      <div class="price">
                        <?php
                        if ( $_REQUEST['type'] == 'rent' ) {
                          print($row['price'] . ' руб/день');
                          $productIdLink = $row['id_product_rent'];
                          $productType   = 'rent';
                        } else {
                          print($row['price'] . ' руб.');
                          $productIdLink = $row['id_product'];
                          $productType   = 'default';
                        }

                        if ( $row['sale'] == 'true' ) {
                          print( '<span class="old-price">' . $row['old_price'] . ' руб.</span>');
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
      
                
              } while ( $row = mysqli_fetch_assoc($result) );
      
            } else {
              $text = 'По вашему запросу ничего не найдено';
            }
      
          }
      
        } else {
          $text = 'Задан пустой поисковый запрос';
        }
        
        $text = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 20px 0">'.$text.'</div>';
        print($text);

        ?>
      </div>
    </div>
  </div>

  <?php require('footer.php'); ?>

 <script src="js/scripts-search.min.js"></script>
  <script>

  </script>

</body>
</html>