<?php 

  require('../functions/connect.php');
  require('../functions/cutText.php');
  require('../functions/get_link.php');

  $search = $_REQUEST['search'];

  $search = trim($search); 
  //$search = mysqli_real_escape_string($search);
  $search = htmlspecialchars($search);

  if ( !empty($search) ) {
    
    if ( strlen($search) < 3) {
      $text = 'Слишком короткий запрос';
    } elseif (strlen($query) > 128) {
      $text = 'Слишком длинный запрос';
    } else {

      $query = "SELECT * FROM `product` WHERE 
               `product_name` LIKE '%$search%' OR `description` LIKE '%$search%' OR `label` LIKE '%$search%'";
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
        
        $arrayResult = array ();

        do {
          $query1 = "SELECT * FROM `product` WHERE `id_product` = '$row[id_product]'";
          $name = cutText($row['product_name'], 35);
          
          if ( !file_exists('../img/items/'.$row['link_image']) or empty($row['link_image']) ) {
            $row['link_image']  = 'img/items/template.png';
            $row['name_alt']   =  'Изображение временно отсутствует';
          } else {
            $row['link_image']    = 'img/items/'.$row['link_image'];
            $row['name_alt']   = 'Товар: '.$row['name'];
          }

          $item = '

          <div class="item-cart" data-id="'.$row['id'].'">
            <div class="wrapp">
              <div class="img_wrapp">
                <img src="'.$row['link_image'].'" alt="'.$row['link_image'].'">
              </div>
              <div class="content">
                <div class="name">
                  <span>'.$name.'</span>
                </div>
                <div class="price">
                  <span class="value">'.$row['price'].'</span>
                  <span> руб.</span>
                </div>
                  <a href="?id='. $row['id_product'] .'" class="blue">Подробнее</a>
              </div>
            </div>
          </div>
          
          ';
          array_push($arrayResult, $item);
        } while ( $row = mysqli_fetch_assoc($result) );

      } else {
        $text = 'По вашему запросу ничего не найдено';
      }

    }

  } else {
    $text = 'Задан пустой поисковый запрос';
  }

?>

<form>
  <input type="text" placeholder="Поиск товаров..." value="<?php print($search); ?>">
  <button type="submit" class="search-form-button">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"/></svg>
  </button>
</form>
<div class="current-items">
  <span><?php print($text); ?></span>
</div>
<div class="main">
  <?php 
  
    if ( !empty($arrayResult) ) {
      $i == 0;
      foreach ($arrayResult as $value) {

        $i++;
        if ( $i > 2 ) {
          $i = $num - ($i - 1);
          if ($i == 1) {
            print('И еще '. $i .' товар');
          } elseif ( $i > 1 and $i < 5 ) {
            print('И еще '. $i .' товара');
          } else {
            print('И еще '. $i .' товаров');
          }
          break;
        }

        print($value);

      }
    }

  ?>
</div>
<div class="links">
  <?php get_link('search.php?search='.$search, 'все результаты', 'blue'); ?>
</div>