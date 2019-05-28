<?php 

	session_start();

	require('functions/connect.php');
	require('functions/get_link.php');
  require('functions/get_line.php');
  require('functions/deleteGET.php');
  require('functions/cutText.php');

  $count_items = 10;
  if ( empty($_GET['page']) ) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }
  if ( !empty($_GET['cat_id']) ) {

    $category_id = $_GET['cat_id'];
    $conditions = "WHERE `category_id` = ".$category_id;

  } elseif ( !empty($_GET['tag_id']) ) {

    $tag_id = $_GET['tag_id'];
    $query = "SELECT * FROM `post_tag` WHERE `tag_id` = $tag_id";
    $result = mysqli_query($connection, $query);
    if ( mysqli_num_rows($result) == 0 ) {
      $eror = true;
    } else {

      $post_id = array();
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($post_id, $row['post_id']);
      }
      $conditions = "WHERE ";
      for ($i=0; $i < count($post_id); $i++) { 
        if( $i + 1 == count($post_id) ) {
          $conditions .= " `blog`.`id` = ".$post_id[$i]." ";
        } else {
          $conditions .= " `blog`.`id` = ".$post_id[$i]." OR";
        }   
      }

    }

  }

  $left_limit = $page * $count_items - $count_items;

  if ( $_POST['search'] == true and !empty($_POST['request']) ) {
    $search = $_POST['request'];
    $search = trim($search); 
    //$search = mysqli_real_escape_string($search);
    $search = htmlspecialchars($search);
    $querySearch = "SELECT * FROM `blog_posts`
                    WHERE `title` LIKE '%$search%'
                    OR `description` LIKE '%$search%'
                    OR `content` LIKE '%$search%'";
  }

?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Блог</title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="">
	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#252525">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#252525">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#252525">

  <link rel="stylesheet" href="css/blog.min.css">
</head>

<body>

	<?php	require('header.php'); ?>

  <div class="main-blog">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php 
              // LEFT JOIN (
              //   SELECT * FROM `post_tag` GROUP BY `post_id`
              // ) AS `post_tag` ON `post_tag`.`post_id` = `blog`.`id`
              // LEFT JOIN (
              //   SELECT * FROM `tag`
              // ) AS `tag` ON `tag`.`tag_id` = `post_tag`.`tag_id`
              if ( empty($querySearch) and $eror != true ) {
                $query = "SELECT *, (
                          SELECT COUNT(*) FROM `blog_posts` $conditions
                        ) AS `count`
                        FROM `blog_posts` AS `blog`
                        LEFT JOIN (
                          SELECT * FROM `authors`
                        ) AS `author` ON `author`.`id` = `blog`.`author_id`
                        LEFT JOIN (
                          SELECT * FROM `blog_category`
                        ) AS `category` ON `category`.`id` = `blog`.`category_id`
                        $conditions
                        ORDER BY `date` DESC
                        LIMIT $left_limit, $count_items";
                $result = mysqli_query($connection, $query);
              } elseif ( $eror != true ) {
                $result = mysqli_query($connection, $querySearch);
                if ( mysqli_num_rows($result) == 0 ) {
                  print('
                    Статей по такому запросу не найдено!
                  ');
                } 
              } else {
                print('
                  Статей по такому запросу не найдено!
                ');
              }
              

              $link = deleteGET( $_SERVER["REQUEST_URI"], 'page' );
              $link = deleteGET( $link, 'cat_id' );
              
              while ($row = mysqli_fetch_assoc($result)) {
                print_r($row['tag']);

                $count_items_request = $row['count'];

                if ( !file_exists('img/posts/'.$row['link_image']) or empty($row['link_image']) ) {
                  $row['link_image']  = 'img/posts/template.png';
                  $row['name_alt']   =  'Изображение временно отсутствует';
                } else {
                  $row['link_image']    = 'img/posts/'.$row['link_image'];
                  $row['name_alt']   = 'Image';
                }

                $arr = [
                  'Январь',
                  'Февраль',
                  'Март',
                  'Апрель',
                  'Май',
                  'Июнь',
                  'Июль',
                  'Аавгуст',
                  'Сентябрь',
                  'Октябрь',
                  'Ноябрь',
                  'Декабрь'
                ]; 

                $month = date('n', strtotime($row['date']))-1;

                $row['date'] = $arr[$month].' '.date("d, Y", strtotime($row['date']));

                $row['description'] = cutText($row['description'], 400);
                $row['title'] = cutText($row['title'], 60);

                ?>
                <div class="blog-item">
                  <div class="img_wrapp">
                    <a href="post.php?id=<?php print($row['id']); ?>"><img src="<?php print($row['link_image']); ?>" alt="Image"></a>
                  </div>
                  <div class="content">
                    <div class="category">
                      <a href="<?php print($link.'?page=1&cat_id='.$row['category_id']); ?>"><?php print($row['category_name']); ?></a>
                    </div>
                    <div class="title">
                      <a href="post.php?id=<?php print($row['id']); ?>"><?php print($row['title']); ?></a>
                    </div>
                    <div class="line"></div>
                    <div class="descr">
                      <p><?php print($row['description']); ?></p>
                    </div>
                    <div class="info">
                      <div class="date">
                        <img src="img/icons/small-calendar.png" alt="Icon">
                        <span><?php print($row['date']); ?></span>
                      </div>
                      <div class="author">
                        <img src="img/icons/avatar.png" alt="Icon">
                        <span><?php print($row['author_name']); ?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              }

              $count_page = ceil($count_items_request / $count_items);
              $link = deleteGET( $_SERVER["REQUEST_URI"], 'page' );

              if ( !empty($_GET['cat_id']) ) {
                $postfix = '&page=';
              } else {
                $postfix = '?page=';
              }
              
              //Test
              // $page = 5;
              // $count_page = 7;
              //

              if ( $count_page > 3 ) {

                $i = $page - 1;

                if ( $i <= 0 ) {
                  $i = 1;
                  $page_right_limit = 3;
                } else {
                  $page_right_limit = $i + 2;
                }
                
              } else {

                $i = 1;
                $page_right_limit = $count_page;

              }

              if ( $count_page == $page ) {
                $page_right_limit = $page;
                
                $i = $page - 2;
                if ($i <= 0) {
                  $i = 1;
                }
              }

              $pagination = '
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <ul class="pagination">
              ';
              if ( $page - 2 > 0 ) {
                $pagination .= '
                  <li><a href="'.$link.$postfix.'1" class="arrow left">1</a></li>
                ';
              }
              
              

              for ($i; $i <= $page_right_limit; $i++) { 

                if ( $i == $page ) {
                  $pagination .= '
                    <li class="active"><a href="'.$link.$postfix.$i.'">'.$i.'</a></li>
                  ';
                } else {
                  $pagination .= '
                    <li><a href="'.$link.$postfix.$i.'">'.$i.'</a></li>
                  ';
                }    

                if ( $i == $page_right_limit and $i - 1 < $count_page and $count_page != $page ) {
                  $pagination .= '
                    <li><a href="'.$link.$postfix.$count_page.'" class="arrow right">'.$count_page.'</a></li>
                  ';
                }

              }

              

              $pagination .= '
                  </ul>
                </div>
              ';

              print($pagination);
              
              ?>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 filter">
          <?php require('aside-blog.php') ?>
        </div>
      </div>
    </div>
  </div>

  <?php require('footer.php'); ?>

 <script src="js/scripts-blog.min.js"></script>

</body>
</html>