<?php

  session_start();

  $productsRent = array_filter($_SESSION['products'], function($k) {
    return $k['type'] == 'rent';
  }, ARRAY_FILTER_USE_BOTH);
  $products = array_filter($_SESSION['products'], function($k) {
    return $k['type'] == 'default';
  }, ARRAY_FILTER_USE_BOTH);

  $totalProducts = 0;

  foreach (array_reverse($products) as $value) {
    $totalProducts = $totalProducts + $value['price']*$value['count'];
  }

  $totalProductsRent = 0;

  foreach (array_reverse($productsRent) as $value) {
    $totalProductsRent = $totalProductsRent + $value['price']*$value['count'];
  }

?>

<table>
  <tr>
    <td>Товары:</td>
    <td><?php print($totalProducts); ?> руб.</td>
  </tr>
  <tr>
    <td>Прокат:</td>
    <td><?php print($totalProductsRent); ?> руб.</td>
  </tr>
  <tr>
    <td>Итого:</td>
    <td><?php print($totalProducts + $totalProductsRent); ?> руб.</td>
  </tr>
</table>