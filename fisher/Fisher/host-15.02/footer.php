<?php

?>

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12">
        <div class="logo">
          <div class="wrapp">
            <div class="img_wrapp">
              <img src="<?php print($config['logo_path']); ?>" alt="Logo">
            </div>
            <span class="logo_name"><?php print($config['logo_name']); ?></span>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12">
        <div class="footer-text">
          <p>
            <?php
              $query       = "SELECT * FROM `footer` WHERE `name` = 'footer-text'";
              $result      = mysqli_query($connection, $query);
              $row         = mysqli_fetch_assoc($result);
              print($row['text']);
            ?>
          </p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12">
        <div class="social-icons">
          <div class="wrapp">
            <ul>
              <?php

                $query       = "SELECT * FROM `social_networks`";
                $result      = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                  if ( !file_exists('img/icons/'.$row['link_image']) or empty($row['link_image']) ) {
                    $row['link_image'] = 'img/items/template.png';
                    $row['name_alt']   =  'Изображение временно отсутствует';
                  } else {
                    $row['link_image'] = 'img/icons/'.$row['link_image'];
                    $row['name_alt']   = $row['name'];
                  }
                  ?>
                    <li>
                      <a href="<?php print($row['link']); ?>">
                       <img src="<?php print($row['link_image']); ?>" alt="<?php print($row['name_alt']); ?>">
                      </a>
                    </li>
                  <?php
                }

              ?>
              
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row info">
      <div class="info-item col-xs-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
        <div class="phone">
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
                Позвоните нам: <?php print($config['phone']); ?></a> 
              </div>
          </div>
        </div>
      </div>
      <div class="info-item col-xs-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
        <div class="email">
          <div class="wrapp">
            <div class="img_wrapp">
              <img src="img/icons/email.png" alt="Email-icon">
            </div>
            <div class="content">
              <a href="mailto:<?php print($config['email']); ?>"><?php print($config['email']); ?></a>
            </div>
          </div>
        </div>
      </div>
      <div class="info-item col-xs-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
        <div>
          <div class="wrapp">
            <div class="img_wrapp">
              <img src="img/icons/regulation.png" alt="Regulation-icon">
            </div>
            <div class="content">
              <a href="#">Правила проката</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12">
        <div class="title">
          <h6>Информация</h6>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12 links">
        <ul>
          <?php 
          
          $query = "SELECT * FROM `footer_posts` AS `f`
          LEFT JOIN (
            SELECT `title`, `id`
            FROM `posts`
          ) AS `p` ON `p`.`id` = `f`.`id`";
            $result      = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <li>
                  <a href="?id=<?php print($row['id']); ?>"><?php print($row['title']); ?></a>
                </li>
              <?php
            }

          ?>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12">
        <div class="bottom-info">
          <div class="copyright">
            <span>Copyright ©2019 - All Rights Reserved.</span>
          </div>
          <div class="cards">
            <ul>
              <li><img src="img/icons/card1.png" alt="Icon"></li>
              <li><img src="img/icons/card2.png" alt="Icon"></li>
              <li><img src="img/icons/card3.png" alt="Icon"></li>
            </ul>
          </div>
        </div>
     </div>
    </div>
  </div>
</footer>