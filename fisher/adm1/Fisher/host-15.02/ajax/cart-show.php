<?php

  session_start();

  $idItem      = $_REQUEST['id_item'];
  $arrayName   = 'id'.$idItem;
  
  if ( !empty($_REQUEST['count']) ) {
    
    $countItem   = $_REQUEST['count'];

    $_SESSION['products'][$arrayName]['count'] = $countItem;
    $price = $_SESSION['products'][$arrayName]['count'] * $_SESSION['products'][$arrayName]['price'];

    print($price);

  } elseif ( $_REQUEST['delete'] == true ) {

    unset($_SESSION['products'][$arrayName]);
    return true;

  }


?>