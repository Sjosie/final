<?php

  session_start();

  require('functions/connect.php');
  require('functions/get_line.php');
  require('functions/get_link.php');
  require('functions/get_cat_recursive.php');
  require('functions/deleteGET.php');
  require('functions/cutText.php');

?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Поиск товара</title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="path/to/image.jpg">
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

	<link rel="stylesheet" href="css/catalogue.min.css">

</head>

<body>

	<?php	require('header.php'); ?>

  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 filter">
          <aside>
            <div class="sidebar_block">
              <div class="button-close_wrapp">
                <button class="button-close">
  
                </button>
              </div>
              <div class="categories">
                <div class="title_wrapp">
                  <span class="title">Категории</span>
                  <div class="line"></div>
                </div>
                <div class="content_wrapp">
                  <ul>
                    <?php 

                      if ( !empty($_GET['id']) ) {
                          
                        $category_id = $_GET['id'];

                        $category_id_q = $category_id;
                        $parent_id = $category_array[$category_id_q]['parent_id'];  

                        $parent_array = array();

                        if ( $parent_id == 0) {

                          $parent_array[0] = $category_id_q;

                        } else {

                          while ($parent_id != 0) {
                            $parent_id = $category_array[$category_id_q]['parent_id'];   
                            array_push($parent_array, $category_id_q);
                            $category_id_q = $parent_id;
                          }

                        }                        

                        $parent_array = array_reverse($parent_array);
                        $category_id_q = array_shift($parent_array);

                        foreach ($data as $key => $value) {
                          if ( $key !=  $category_id_q) {
                            unset($data[$key]);
                          }
                        }
                        print_r(view_cat($data));

                      }

                    ?>
                  </ul>
                </div>
              </div>

              <div class="price-range">       
                <div class="title_wrapp">
                  <span class="title">Цена</span>
                  <div class="line"></div>
                </div>
                <div class="price-range-slider">
                  <?php 

                    if ( mb_strtolower(array_shift($data)['name']) == 'прокат' ) {
                      $type = 'rent';
                    } else {
                      $type = 'default';
                    }
                    $categories_array = array();
                    get_cat_recursive($_GET['id'], $category_array, $categories_array);

                    $conditions = "";
                    if ( !empty($categories_array) ) {

                      $conditions .= "`id_category` IN ('".$_GET['id']."'";
                      foreach ($categories_array as $value) {
                        $conditions .= ", '".$value."' ";
                      }
                      $conditions .= ")";

                    } else {
                      $conditions .= "`id_category` = ".$_GET['id']." ";
                    }
                  
                    if ( $type == 'default' ) {
                      $query = "SELECT MAX(price) AS `max_price` FROM `product` WHERE $conditions";
                    } elseif ( $type == 'rent' ) {
                      $query = "SELECT MAX(price) AS `max_price` FROM `product_rent` WHERE $conditions";
                    }

                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $maxPrice = $row['max_price'];

                  ?>
                  <div id="slider-range" class="range-bar" data-left-limit="1" data-right-limit="<?php print($maxPrice); ?>"></div>
                  <p class="range-value">
                    <input type="text" id="amount" readonly>
                  </p>
                  <?php get_link('', 'Показать', 'blue price-range-button', '', 'button') ?>
                </div>
              </div>

              <div class="brands">
                <div class="title_wrapp">
                  <span class="title">Бренд</span>
                  <div class="line"></div>
                </div>
                <div class="content_wrapp">
                  <ul>
                    <li>
                      <div class="wrapp">
                       <ul>
                          
                        {% for post in posts %}
                            {{ rent }}
                        {% endfor %}
                          <!-- <?php 
                            $query  = "SELECT `b`.`id`, `b`.`name`, IFNULL(`p`.`count`, 0) AS `count`, IFNULL(`p_rent`.`count_rent`, 0) AS `count_rent`
                                      FROM `brands` AS `b`
                                      LEFT JOIN (
                                        SELECT `id_brand`, COUNT(*) AS `count`
                                        FROM `product`
                                        GROUP BY `id_brand`
                                      ) AS `p` ON `p`.`id_brand` = `b`.`id`
                                      LEFT JOIN (
                                        SELECT `id_brand`, COUNT(*) AS `count_rent`
                                        FROM `product_rent`
                                        GROUP BY `id_brand`
                                      ) AS `p_rent` ON `p_rent`.`id_brand` = `b`.`id`";

                            $result = mysqli_query($connection, $query);
                          
                            while ($row = mysqli_fetch_assoc($result)) {
                              if ( empty($_GET['id_brand']) ) {
                                $link = $_SERVER["REQUEST_URI"].'&id_brand='.$row['id'];
                              } else {
                                $link = deleteGET( $_SERVER["REQUEST_URI"], 'id_brand' ).'&id_brand='.$row['id'];
                              }
                              ?>
                                <li><a href="<?php print($link); ?>" data-count="<?php print($row['count']+$row['count_rent']); ?>"><?php print($row['name']); ?></a></li>
                              <?php
                            }
                          ?> -->
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </aside>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            
              <div class="link filter-button_wrapp">
                <button class="link_style blue filter-button">Фильтры</button>
              </div>

              <div class="conclusion">

                <div class="conclusion_type">
                  <div class="icon icon_active" data-type="grid">
                    <button>                      
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M176.792,0H59.208C26.561,0,0,26.561,0,59.208v117.584C0,209.439,26.561,236,59.208,236h117.584	C209.439,236,236,209.439,236,176.792V59.208C236,26.561,209.439,0,176.792,0z M196,176.792c0,10.591-8.617,19.208-19.208,19.208	H59.208C48.617,196,40,187.383,40,176.792V59.208C40,48.617,48.617,40,59.208,40h117.584C187.383,40,196,48.617,196,59.208	V176.792z"/>	</g></g><g><g><path d="M452,0H336c-33.084,0-60,26.916-60,60v116c0,33.084,26.916,60,60,60h116c33.084,0,60-26.916,60-60V60	C512,26.916,485.084,0,452,0z M472,176c0,11.028-8.972,20-20,20H336c-11.028,0-20-8.972-20-20V60c0-11.028,8.972-20,20-20h116	c11.028,0,20,8.972,20,20V176z"/></g></g><g><g><path d="M176.792,276H59.208C26.561,276,0,302.561,0,335.208v117.584C0,485.439,26.561,512,59.208,512h117.584	C209.439,512,236,485.439,236,452.792V335.208C236,302.561,209.439,276,176.792,276z M196,452.792	c0,10.591-8.617,19.208-19.208,19.208H59.208C48.617,472,40,463.383,40,452.792V335.208C40,324.617,48.617,316,59.208,316h117.584	c10.591,0,19.208,8.617,19.208,19.208V452.792z"/></g></g><g><g><path d="M452,276H336c-33.084,0-60,26.916-60,60v116c0,33.084,26.916,60,60,60h116c33.084,0,60-26.916,60-60V336	C512,302.916,485.084,276,452,276z M472,452c0,11.028-8.972,20-20,20H336c-11.028,0-20-8.972-20-20V336c0-11.028,8.972-20,20-20	h116c11.028,0,20,8.972,20,20V452z"/></g></g></svg>
                    </button>
                  </div>
                  <div class="icon" data-type="list">
                    <button>
                      <svg viewBox="0 -52 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m0 0h113.292969v113.292969h-113.292969zm0 0"/><path d="m149.296875 0h362.703125v113.292969h-362.703125zm0 0"/><path d="m0 147.007812h113.292969v113.292969h-113.292969zm0 0"/><path d="m149.296875 147.007812h362.703125v113.292969h-362.703125zm0 0"/><path d="m0 294.011719h113.292969v113.296875h-113.292969zm0 0"/><path d="m149.296875 294.011719h362.703125v113.296875h-362.703125zm0 0"/></svg>
                    </button>
                  </div>
                </div>
                
                <div class="sort">

                  <div class="select_wrapp">
                    <span>Сортировать по: </span>
                    <select name="" id="select_sort">
                      <option value="product_name">Имени</option>
                      <option value="price">Цене</option>
                      <option value="date_add">Дате</option>
                    </select>
                  </div>

                  <div class="select_wrapp">
                    <span>Показать</span>
                    <select name="" id="select_show">
                      <option value="15">15</option>
                      <option value="30">30</option>
                    </select>
                  </div>

                </div>

              </div>
            </div>
          </div>
          <div class="row items-row">

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require('footer.php'); ?>
  <script src="js/scripts-catalogue.min.js"></script>
</body>
</html>
