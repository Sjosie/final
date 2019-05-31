<?php
  //Config  
  $query       = "SELECT * FROM `config`";
  $result      = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  $config = $row;

  //Сессия
  if ( empty($_SESSION['products']) ) {
    $_SESSION['products'] = array ();
  }

  //require('functions/connect.php');
  require('functions/cutText.php');

  $query       = "SELECT * FROM `menu`";
  $result      = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['id']]= $row;
  }
  
  function view_cat ($dataset) {

    $arr = "";
    foreach ($dataset as $menu) {

      if(!empty($menu['childs'])) {
        $elementClass = 'additional-menu_link ';
      } else {
        $elementClass = '';
      }

      if ( $menu['parent_id'] == 0 and empty($menu['childs']) ) {
        $link = '<a href="'.$menu['link'].'">'.$menu["name"].'</a>';
      } else {
        $link = '<a href="category.php?id='.$menu['id'].'">'.$menu["name"].'</a>';
      }

      $arr .= '<li class="'.$elementClass.'">'.$link;
  
      if(!empty($menu['childs'])) {
        $arr .= '<div class="wrapp" data-id="'. $menu['id'] .'"><ul>';
        $arr .= view_cat($menu['childs']);
        $arr .= '</ul></div>';
      }
       $arr .= '</li>';

    }
    return $arr;
}

  function mapTree($dataset) {

  $tree = array();

  foreach ($dataset as $id=>&$node) {

      if (!$node['parent_id']) {
        $tree[$id] = &$node;
      }
      else {
          $dataset[$node['parent_id']]['childs'][$id] = &$node;
      }
  }
      return $tree;
  }

  $data = mapTree($data);
  
  //print_r(view_cat($data));
?>


<section class="top-info">
  <ul>
    <li class="time">
      <div class="wrapp">
        <div class="img_wrapp">
          <img src="img/icons/time.png" alt="Time-icon">
        </div>
        <div class="content">
          <span><?php print($config['work_schedule']); ?></span>
        </div>
      </div>
    </li>
    <li class="email">
      <div class="wrapp">
        <div class="img_wrapp">
          <img src="img/icons/email.png" alt="Email-icon">
        </div>
        <div class="content">
          <a href="mailto:<?php print($config['email']); ?>"><?php print($config['email']); ?></a>
        </div>
      </div>
    </li>
    <li class="phone">
      <div class="wrapp">
        <div class="img_wrapp">
          <img src="img/icons/phone.png" alt="Phone-icon">
        </div>
        <div class="content">
        <a href="tel:<?php 
            $phone = $config['phone'];
            $chars = [' ', '(', ')', '-'];
            $phone = str_replace($chars, '', $phone);
            print($phone);
          ?>">
           <?php print($config['phone']); ?></a> 
        </div>
      </div>
    </li>
    <li class="delivery">
      <div class="wrapp">
        <div class="img_wrapp">
         <img src="img/icons/delivery.png" alt="Delivery-icon">
        </div>
        <div class="content">
          <span><?php print($config['rent']); ?></span>
        </div>
      </div>
    </li>
    <li class="regulation">
      <div class="wrapp">
        <div class="img_wrapp">
          <img src="img/icons/regulation.png" alt="Regulation-icon">
        </div>
        <div class="content">
          <a href="#">Правила проката</a>
        </div>
      </div>
    </li>
  </ul>
</section>
<header class="header">
  <div class="container-header">
      <div class="logo">
        <div class="img_wrapp">
          <img src="<?php print($config['logo_path']); ?>" alt="Logo">
        </div>
        <span class="logo_name"><?php print($config['logo_name']); ?></span>
      </div>
      <nav class="menu">
        <ul class="menu_ul">
          <?php print_r(view_cat($data)); ?>
          <!--<li class="additional-menu_link menu_ul_li">
            <a href="#" class="menu_link">Рыбалка</a>
            <div class="additional-menu">
              <div class="row">
                <div class="col-md-7">
                  <div class="row">
                    <div class="col-md-4 subcategory-block">
                      <span class="title">катушки</span>
                      <ul class="additional-menu-ul">
                        <li><a href="#">Бейткастинговые</a></li>
                        <li><a href="#">Спиннинговые</a></li>
                        <li><a href="#">Спинкастовые</a></li>
                        <li><a href="#">Морские</a></li>
                        <li><a href="#">Нахлыстовые</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-5 banner-menu_wrapp">
                  <div class="banner-menu">
                    <div class="img-wrapp">
                      <img src="img/banners/banner-menu.png" alt="Banner">
                    </div>
                    <div class="content">
                      <div class="text white">
                        <span class="subtitle">Сэкономьте до 25%</span>
                        <span class="main">НА ВСЕХ <br> КАТУШКАХ</span>
                      </div>
                      <?php get_line('white'); ?>
                      <?php get_link('#', 'Подробнее', 'blue'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>-->
        </ul>
      </nav>
      <div class="icons">
        <ul>
          <li>
            <button class="search-button">
              <img src="img/icons/search.png" alt="Search">
            </button>
          </li>
          <li>
            <button class="cart-button">
              <img src="img/icons/cart.svg" alt="Cart">
            </button>
          </li>
        </ul>
      </div>
      <div class="menu-button_wrapp">
        <button class="menu-button">
          <span ></span>
        </button>
      </div>
      
  </div>
  <div class="mini-cart">
    <div class="current-items">
      <span><?php print(count($_SESSION['products'])); ?></span> товара в вашей корзине
    </div>
    <div class="main">
      <?php
        $totalPrice = 0;
        $i = 0;

        if( !empty($_SESSION['products']) ) {
          
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
                <img src="<?php print($value['link_image']); ?>" alt="<?php print($item_alt); ?>">
              </div>
              <div class="content">
                <div class="name">
                  <span><?php print($name); ?></span>
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
              <button data-id="<?php print($value['id']); ?>">&#10006;</button>
            </div>
          </div>
          <?php
          }

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
  </div>
  <div class="search">
    <form>
      <input type="text" placeholder="Поиск товаров...">
      <button type="submit" class="search-form-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"/></svg>
      </button>
    </form>
    <div class="current-items">
      <span>Введите запрос</span>
    </div>
    <div class="main"></div>
    <div class="links">
      <?php get_link('#', 'все результаты', 'blue'); ?>
    </div>
  </div>
</header>
<nav class="mobile-menu">
  <ul>
    <?php print_r(view_cat($data)); ?>
  </ul>
  <?php get_link('cart.php', 'Корзина', 'white');?>
</nav>