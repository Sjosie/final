<?php

  require('../functions/connect.php');
  require('../functions/get_link.php');
  require('../functions/get_line.php');

  $id = $_REQUEST['id_category_banners'];

  $query       = "SELECT * FROM `menu_banners` WHERE `id_category` = $id";
  $result      = mysqli_query($connection, $query);
  $row         = mysqli_fetch_assoc($result);

  
  
  if ( !empty($row) ) {

    if ( !file_exists('../img/banners/'.$row['link_image']) or empty($row['link_image']) ) {
      $row['link_image'] = 'img/items/template.png';
      $row['name_alt']   =  'Изображение временно отсутствует';
    } else {
      $row['link_image'] = 'img/banners/'.$row['link_image'];
      $row['name_alt']   = 'Banner';
    }

    ?>
    <div class="banner-menu_wrapp">
      <div class="banner-menu">
        <div class="img-wrapp">
          <img src="<?php print($row['link_image']); ?>" alt="<?php print($row['name_alt']); ?>">
        </div>
        <div class="content">
          <div class="text <?php print($row['text_color']); ?>">
            <span class="subtitle"><?php print($row['text']); ?></span>
            <span class="main"><?php print($row['title']); ?></span>
          </div>
          <?php get_line($row['text_color']); ?>
          <?php get_link($row['link'], $row['link_text'], $row['link_color']); ?>
        </div>
      </div>
    </div>
    <?php

  }

?>
