<?php 

  function get_rating($rating) {
    
    $i = 0;
    $html = '<div class="rating">';
    for ($i=1; $i <= $rating; $i++) { 
      $html .= '
        <span>
          <img src="img/icons/star1.png" alt="Star">
        </span>';
    }
    for ($k=$i; $k <= 5; $k++) { 
      $html .= '
        <span>
          <img src="img/icons/star.png" alt="Star">
        </span>';
    }

    $html .= '</div>';
    print( $html);

  }

?>
