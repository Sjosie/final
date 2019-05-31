<?php
 function deleteGET($url, $name, $amp = true) {
    $url = str_replace("&amp;", "&", $url); // Заменяем сущности на амперсанд, если требуется
    list($url_part, $qs_part) = array_pad(explode("?", $url), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
    parse_str($qs_part, $qs_vars); // Разбиваем строку с запросом на массив с параметрами и их значениями
    unset($qs_vars[$name]); // Удаляем необходимый параметр
    if (count($qs_vars) > 0) { // Если есть параметры
      $url = $url_part."?".http_build_query($qs_vars); // Собираем URL обратно
      if ($amp) $url = str_replace("&", "&amp;", $url); // Заменяем амперсанды обратно на сущности, если требуется
    }
    else $url = $url_part; // Если параметров не осталось, то просто берём всё, что идёт до знака ?
    return $url; // Возвращаем итоговый URL
  }
?>