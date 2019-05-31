<?php 

  function get_title($text) {
    ?>

    <div class="title-default">
     <h5><?php echo"$text"; ?></h5>
      <figure class="title">
        <div class="line left"></div>
        <div class="img_wrap">
          <img src="img/icons/logoTitle.png" alt="Logo">
        </div>
        <div class="line right"></div>
      </figure>
    </div>

    <?php
  }

?>