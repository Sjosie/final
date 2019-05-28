<?php

  function get_link($address, $text, $color = "white", $attr = "", $type = "a") {

    if ($type == "a") {
      ?>
      <div class="link">
        <a href="<?php echo"$address"; ?>" <?php echo"$attr"; ?> class="link_style <?php echo"$color"; ?>">
          <?php echo"$text"; ?>
        </a>
      </div>
      <?php
    } elseif ($type == "button") {
      ?>
      <div class="link">
        <button <?php echo"$attr"; ?> class="link_style <?php echo"$color"; ?>">
          <?php echo"$text"; ?>
        </button>
      </div>
      <?php
    }

  }

?>
