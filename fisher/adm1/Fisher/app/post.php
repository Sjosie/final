{% load static %}
{% block content %}
<?php 

	session_start();

	require('functions/connect.php');
	require('functions/get_link.php');
  require('functions/get_line.php');
  require('functions/deleteGET.php');
  require('functions/cutText.php');

  $post_id = $_GET['id'];

  $query = "SELECT * FROM `blog_posts` AS `blog`
            LEFT JOIN (
              SELECT * FROM `authors`
            ) AS `author` ON `author`.`id` = `blog`.`author_id`
            LEFT JOIN (
              SELECT * FROM `blog_category`
            ) AS `category` ON `category`.`id` = `blog`.`category_id`
            LEFT JOIN (
              SELECT * FROM `post_tag`
            ) AS `post_tag` ON `post_tag`.`post_id` = `blog`.`id`
            WHERE `blog`.`id` = $post_id";
  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);

  if ( !file_exists('img/posts/'.$post['link_image']) or empty($post['link_image']) ) {
    $post['link_image']  = 'img/posts/template.png';
    $postName_alt   =  'Изображение временно отсутствует';
  } else {
    $post['link_image']    = 'img/posts/'.$post['link_image'];
    $postName_alt   = 'Изображение к статье: '.$post['product_name'];
  }

  

?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Статья: <?php print($post['title']); ?></title>
	<meta name="description" content="<?php print($post['description']); ?>">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="<?php print($post['link_image']); ?>">
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

  <link rel="stylesheet" href="css/post.min.css">
</head>

<body>

	<?php	require('header.php'); ?>

  <div class="main-post">
    <div class="container">
      <div class="row">
      
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

          <div class="img_wrapp-post">
            <img src="<?php print($post['link_image']); ?>" alt="<?php print($postName_alt); ?>">
          </div>
          <div class="category">
            <a href="<?php print($link.'?page=1&cat_id='.$post['category_id']); ?>"><?php print($post['category_name']); ?></a>
          </div>
          <div class="title">
            <h1><?php print($post['title']); ?></h1>
          </div>
          <div class="line"></div>
          <div class="content-post">
          <?php print($post['content']); ?>
          </div>
          <div class="tags-list">
            <span class="title">TAGS:</span>
            {% for post in posts %}
<div class="post">
    <div class="date">
        {{ post.published_date }}
    </div>
    <h1><a href="{% url 'post_detail' pk=post.pk %}">{{ post.title }}</a></h1>
</div>
{% endfor %}
          </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 filter">
          <?php require('aside-blog.php') ?>
        </div>

      </div>
    </div>
  </div>

  <?php require('footer.php'); ?>

 <script src="js/scripts-post.min.js"></script>
  <script>

  </script>

</body>
</html>

{% endblock %}
