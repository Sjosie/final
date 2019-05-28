<?php

  function cutText($string, $number) {

    $stringLength = strlen($string);

    if ($stringLength <= $number) {
      return $string;
    }

    $string = substr($string, 0, $number);
    $string = substr($string, 0, strrpos($string, ' '));
    
    return $string."… ";
  }

?>