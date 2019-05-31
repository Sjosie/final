<?php 

  session_start();

  require '../functions/phpmailer/PHPMailerAutoload.php';
  require('../functions/connect.php');

  $query   = "SELECT * FROM `config`";
  $result  = mysqli_query($connection, $query);
  $config  = mysqli_fetch_assoc($result);

  $mail    = new PHPMailer;
  $email   = $_POST['email'];
  $phone   = $_POST['phone'];
  if ( !empty($_POST['msg']) ) {

    $msg   = $_POST['msg'];
    $msg   = 'Сообщение: '.$msg;

  }

  $productsRent = array_filter($_SESSION['products'], function($k) {
    return $k['type'] == 'rent';
  }, ARRAY_FILTER_USE_BOTH);
  $products = array_filter($_SESSION['products'], function($k) {
    return $k['type'] == 'default';
  }, ARRAY_FILTER_USE_BOTH);

  $order   = '';

  if ( !empty($products) ) {

    $$totalProducts = 0;

    $order .='<span style="color: red">Товары на продажу:</span> <br>';
    $order .= '<ul>';

    foreach ($products as $value) {
      $totalProducts = $totalProducts + $value['price']*$value['count'];
      $order .='
        <li>
        Имя: '.$value['product_name'].' <br>
        Цена: '.$value['price'].' <br>
        Количество:  '.$value['count'].' <br>
        </li>
        <br>
      ';
    }

    $order .= '</ul>';
    $order .= '<span style="padding-left: 40px">Итого: '.$totalProducts.' руб. </span> <br><br>';

  }

  if ( !empty($productsRent) ) {
    
    $totalProductsRent = 0;

    $order .='<span style="color: red">Товары на прокат:</span> <br>';
    $order .= '<ul>';

    foreach ($productsRent as $value) {
      $totalProductsRent = $totalProductsRent + $value['price']*$value['count'];
      $order .='
        <li>
        Имя: '.$value['product_name'].' <br>
        Цена: '.$value['price'].' <br>
        Количество:  '.$value['count'].' <br>
        </li>
        <br>
      ';
    }

    $order .= '</ul>';
    $order .= '<span style="padding-left: 40px">Итого: '.$totalProductsRent.' руб. </span> <br><br>';

  }

  if ( !empty($order) ) {
    $order .= 'Общая сумма заказ: '.($totalProductsRent + $totalProducts).' руб.';
  }

  $mail->isSMTP();

  $mail->Host = $config['email_service_host'];
  $mail->SMTPAuth = true;
  $mail->Username = $config['email_service']; // логин от вашей почты
  $mail->Password = $config['emaiL_service_password']; // пароль от почтового ящика
  $mail->SMTPSecure = 'ssl';
  $mail->Port = $config['email_service_port'];

  $mail->CharSet = 'UTF-8';
  $mail->From = $config['email_service']; // адрес почты, с которой идет отправка
  $mail->FromName = 'Бюро путешествий мистера Финча - сайт'; // имя отправителя
  $mail->addAddress($config['email_order']);
  //$mail->addAddress('vamper.2012@gmail.com', 'Имя 2');
  $mail->addCC($config['email_order']);


  $mail->isHTML(true);

  $msgBody = '
    <h3>Новая заявка</h3> <br>
    Email: <span style="color: green">'.$email.'</span> <br>
    Телефон: <span style="color: green">'.$phone.'</span> <br>
    '.$msg.' <br>
    Заказ: <br>
    <br>
    '.$order.'

  ';

  $mail->Subject = 'Заявка с сайта '.$config['site_name'];
  $mail->Body    = $msgBody;
  $mail->AltBody = 'Это альтернативное письмо';
  //$mail->addAttachment('img/Lighthouse.jpg', 'Картинка Маяк.jpg');
  // $mail->SMTPDebug = 1;

  if( $mail->send() ){
    echo 'Письмо отправлено';
  }else{
    echo 'Письмо не может быть отправлено. ';
    echo 'Ошибка: ' . $mail->ErrorInfo;
  }

?>