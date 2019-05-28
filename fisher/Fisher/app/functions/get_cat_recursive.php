<?php

function get_cat_recursive($id_check, &$array_check, &$array_temp)
{

  foreach ($array_check as $key => $value) {
    
    if ( $id_check == $value['parent_id']) {

      //$array_temp += get_cat_recursive($value['id'], $array_check, $array_temp);
      array_push($array_temp, $value['id']);
      get_cat_recursive($value['id'], $array_check, $array_temp);

    }

  }

}

?>