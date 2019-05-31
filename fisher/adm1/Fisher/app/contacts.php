<?php

  session_start();

  //For header
  require('functions/connect.php');
  require('functions/get_line.php');
  require('functions/get_link.php');
  require('functions/get_title.php');
  require('functions/cutText.php');

?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Контакты</title>
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

	<link rel="stylesheet" href="css/contacts.min.css">

</head>

<body>

	<?php	require('header.php'); ?>

  <div class="main">
    <div class="container">

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div id="map" class="map_wrapp" data-coordinate="<?php print($config['coordinate']); ?>"></div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
          <div class="info_wrapp">
            <div class="icon_wrapp">
              <img src="img/icons/phone_contacts.png" alt="Icon">
            </div>
            <div class="title">Номер телефона</div>
            <div class="line"></div>
            <div class="value"><?php print($config['phone']); ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
          <div class="info_wrapp">
            <div class="icon_wrapp">
              <img src="img/icons/email_contacts.png" alt="Icon">
            </div>
            <div class="title">Email адрес</div>
            <div class="line"></div>
            <div class="value"><?php print($config['email']); ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
          <div class="info_wrapp">
            <div class="icon_wrapp">
            <img src="img/icons/address_contacts.png" alt="Icon">
            </div>
            <div class="title">Адрес</div>
            <div class="line"></div>
            <div class="value"><?php print_r($config['address']); ?></div>
          </div>
        </div>
      </div>
          
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <?php get_title('Напишите нам'); ?>
        </div>
      </div>
      <form action="contacts.php" class="feedback">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <input name="name" type="text" placeholder="Ваше имя...">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <input name="email" type="text" placeholder="Ваш email..." required>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <input name="phone" type="text" placeholder="Ваш телефон..." required>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-width: 100%;">
            <textarea name="massage" placeholder="Сообщение..." required></textarea>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php get_link('', 'Отправить сообщение', 'blue mailto', 'type="submit"', 'button'); ?>
          </div>
        </div>
      </form>

    </div>
  </div>

	<?php require('footer.php'); ?>

  <script src="https://api-maps.yandex.ru/2.1/?apikey=3b75a14d-ab1a-46c7-9071-ca6a8d540b04&lang=ru_RU" type="text/javascript"></script>

	<script src="js/scripts-contacts.min.js"></script>

</body>
</html>
