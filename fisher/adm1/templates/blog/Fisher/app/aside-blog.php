<aside>
  <div class="sidebar_block">

    <div class="button-close_wrapp">
      <button class="button-close">

      </button>
    </div>

    <div class="search-blog">
      <div class="title_wrapp">
        <span class="title">Поиск</span>
        <div class="line"></div>
      </div>
      <div class="content_wrapp">
        <form action="blog.php" method="POST">
          <input type="hidden" name="search" value="true">
          <input type="text" name="request" placeholder="Поиск по блогу" required>
          <button type="submit">
            <img src="img/icons/search_dark.png" alt="Icon">
          </button>
        </form>
      </div>
    </div>
    
    <div class="categories">
      <div class="title_wrapp">
        <span class="title">Категории</span>
        <div class="line"></div>
      </div>
      <div class="content_wrapp">
        <ul>
          <?php 

            $query = "SELECT * FROM `blog_category`";
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($result)) {
              ?>
              <li><a href="<?php print('blog.php?page=1&cat_id='.$row['id']); ?>"><?php print($row['category_name']); ?></a></li>
              <?php
            }

          ?>
        </ul>
      </div>
    </div>

    <div class="recent-posts">
      <div class="title_wrapp">
        <span class="title">Последние посты</span>
        <div class="line"></div>
      </div>
      <div class="content_wrapp row">
      <?php 
      $query = "SELECT `id`, `link_image`, `title`, `date` FROM `blog_posts` ORDER BY `date` DESC LiMIT 3 ";
      $result = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($result)) {

        if ( !file_exists('img/posts/'.$row['link_image']) or empty($row['link_image']) ) {
          $row['link_image']  = 'img/posts/template.png';
          $row['name_alt']   =  'Изображение временно отсутствует';
        } else {
          $row['link_image']    = 'img/posts/'.$row['link_image'];
          $row['name_alt']   = 'Image';
        }

        $row['date'] = date("d.m.Y", strtotime($row['date']));
        $row['title'] = cutText($row['title'], 60);
        ?>
        <div class="recent-post-item col-xs-12 col-sm-6 col-md-12 col-lg-12">
          <div class="img_wrapp">
            <a href="post.php?id=<?php print($row['id']); ?>"><img src="<?php print($row['link_image']); ?>" alt="Image"></a>
          </div>
          <div class="content">
            <div class="date"><?php print($row['date']); ?></div>
            <div class="title"><a href="post.php?id=<?php print($row['id']); ?>"><?php print($row['title']); ?></a></div>
          </div>
        </div>
        <?php
      }

      ?>
        
      </div>
    </div>

    <div class="tags">
      <div class="title_wrapp">
        <span class="title">Теги</span>
        <div class="line"></div>
      </div>
      <div class="content_wrapp">
        <?php 
        
        $query = "SELECT * FROM `tag`";
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          print('
            <a href="blog.php?tag_id='.$row['tag_id'].'">'.$row['tag'].'</a>
          ');
        }

        ?>

      </div>
    </div>

  </div>
</aside>