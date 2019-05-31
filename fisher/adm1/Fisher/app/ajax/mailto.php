<?php 

  require '../functions/phpmailer/PHPMailerAutoload.php';
  require('../functions/connect.php');

  $query   = "SELECT * FROM `config`";
  $result  = mysqli_query($connection, $query);
  $config  = mysqli_fetch_assoc($result);

  $mail    = new PHPMailer;
  $email   = $_POST['email'];
  $phone   = $_POST['phone'];
  $msg     = 'Сообщение: '.$_POST['msg'];
  if ( empty($_POST['name']) ) {
    $name = 'Неизвестный пользователь';
  } else {
    $name = $_POST['name'];
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
  //$mail->addAddress('test@test.com', 'Имя 2');
  $mail->addCC($config['email_order']);


  $mail->isHTML(true);

  $msgBody = '
    <h3>Новое сообщение!</h3> <br>
    Имя: <span style="color: green">'.$name.'</span> <br>
    Email: <span style="color: green">'.$email.'</span> <br>
    Телефон: <span style="color: green">'.$phone.'</span> <br>
    '.$msg.' <br>
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