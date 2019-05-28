<?php 

	session_start();

	require('functions/connect.php');
	require('functions/get_link.php');
	require('functions/get_line.php');
	require('functions/get_title.php');
	require('functions/get_rating.php');
	require('functions/cutText.php');

?>

<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Главная</title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="path/to/image.jpg">
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

	<link rel="stylesheet" href="css/main.min.css">

</head>

<body>

	<?php
		require('header.php');
	?>

	<section id="home">
	<?php 
		
		$query       = "SELECT * FROM `home_main_slider`";
		$result      = mysqli_query($connection, $query);
	
		while ($row = mysqli_fetch_assoc($result)) {

			if ( !file_exists('img/'.$row['link_image']) or empty($row['link_image']) ) {
				$row['link_image']  = 'img/template.jpg';
			} else {
				$row['link_image']    = 'img/'.$row['link_image'];
			}

			?>
			<div class="slide" style="background-image: url(<?php print($row['link_image']); ?>);">
				<div class="content">
					<h2><?php print($row['title']); ?></h2>
					<p><?php print($row['description']); ?></p>
					<?php get_link( $row['link'] , $row['link_name'] , $row['link_color']); ?>
				</div>
			</div>
			<?php
		}
	
	?>
	</section>

	<section class="banners">
		<div class="container-fluid">
			<div class="row">
				<?php 
				
				$query       = "SELECT * FROM `home_banners` LIMIT 3";
				$result      = mysqli_query($connection, $query);

					while ($row = mysqli_fetch_assoc($result)) {

						$image = true;

						if ( !file_exists('img/banners/'.$row['link_image']) or empty($row['link_image']) ) {
							$image = false;
						} else {
							$row['link_image']    = 'img/banners/'.$row['link_image'];
						}
						
						?>
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
								<div class="banner_wrapp">
									<div class="title">
										<h3><?php print($row['title']); ?></h3>
										<span><?php print($row['description']); ?></span>
										<?php get_link( $row['link'] , $row['link_name'] , $row['link_color']); ?>
									</div>
									
										<?php 
										
											if ( $image == true ) {
												?>
													<div class="img_wrapp">
														<img src="<?php print($row['link_image']); ?>" alt="Image">
														</div>
												<?php
											}
										
										?>
									
								</div>
							</div>
						<?php
					}

				?>
			</div>
		</div>
	</section>

	<section class="top-sales sales-block">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php get_title('Лидеры продаж'); ?>
				</div>
				<div id="top-sales-tabs" class="tabs_wrapp">
					<ul class="tabs">
						<?php 
							$query = "SELECT * FROM `top-sales_category` AS `h`
												LEFT JOIN (
													SELECT * FROM `menu`
												) AS `p` ON `p`.`id` = `h`.`id_category`";
							$category_q = mysqli_query($connection, $query);
							$i = 1;

							while ($category = mysqli_fetch_assoc($category_q)) {
								
								$categoryId     = $category['id_category'];
								$categoryName   = $category['name'];

								foreach ($category_array as $key => $value) {
									if ( $categoryId == $value['id']) {
										$categoryIdParent = $value['parent_id'];
									}
								}

								foreach ($category_array as $key => $value) {
									if ( $categoryIdParent == $value['id']) {
										$categoryNameParent = $value['name'];
									}
								}
					
								?>
								<li><a href="#tabs-ts-<?php echo"$i"; ?>" data-id="<?php print($categoryId); ?>"><?php print($categoryNameParent.' - '.$categoryName); ?></a></li>
								<?php
								$i++;
							}

						?>
					</ul>
					<div class="tab-container row" id="tabs-ts-1"></div>
				</div>
			</div>
		</div>
	</section>

	<div class="hot-deals">
		<div class="container" id="hot-deals-slider">
			<?php

				$query         = "SELECT * FROM `home_hot_deals` AS `h`
													LEFT JOIN (
														SELECT * FROM `product`
													) AS `p` ON `p`.`id_product` = `h`.`id_product`";
				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_assoc($result)) {

					if ( !file_exists('img/items/'.$row['link_image']) or empty($row['link_image']) ) {
            $row['link_image']  = 'img/items/template.png';
            $row['name_alt']   =  'Изображение временно отсутствует';
          } else {
            $row['link_image']    = 'img/items/'.$row['link_image'];
            $row['name_alt']   = 'Товар: '.$row['name'];
          }
					
					?>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
								<div class="row content">
									<div class="title">
										<span><?php print($row['product_name']); ?></span>
									</div>
									<?php get_rating($row['rating']); ?>
									<div class="price">
										<span class="price-now"><?php print($row['price']); ?> руб.</span>
										<span class="price-was"><?php print($row['old_price']); ?> руб.</span>
									</div>
									<div class="descr">
										<p><?php print($row['description_banner']); ?></p>
									</div>
									<div class="timer" id="<?php print($row['id_product']); ?>" data-date="<?php print($row['date']); ?>">
										<!--<div class="circle">
											<span class="value date">45</span>
											<span class="unit">Дней</span>
										</div>
										<div class="circle hours">
											<span class="value">24</span>
											<span class="unit">Часа</span>
										</div>
										<div class="circle min">
											<span class="value">00</span>
											<span class="unit">Мин</span>
										</div>
										<div class="circle sec">
											<span class="value">00</span>
											<span class="unit">Сек</span>
										</div>-->
									</div>
									<?php get_link('item.php?id='.$row['id_product'].'&type=default', 'купить сейчас', 'blue'); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
								<div class="img_wrapp">
									<img src="<?php print($row['link_image']); ?>" alt="Image">
								</div>
							</div>
						</div>
					<?php
				}

			?>
			
		</div>
	</div>

	<section class="equipment-rental sales-block">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php get_title('ПРОКАТ ОБОРУДОВАНИЯ'); ?>
				</div>
				<div id="equipment-rental-tabs" class="tabs_wrapp">
					<ul class="tabs">
						<?php 

							$query = "SELECT * FROM `equipment-rental_category` AS `h`
												LEFT JOIN (
													SELECT * FROM `menu`
												) AS `p` ON `p`.`id` = `h`.`id_category`";
							$category_q = mysqli_query($connection, $query);
							$i = 1;

							while ($category = mysqli_fetch_assoc($category_q)) {
								
								$categoryId     = $category['id_category'];
								$categoryName   = $category['name'];
								$categoryId     = $category['id_category'];
								$categoryName   = $category['name'];

								foreach ($category_array as $key => $value) {
									if ( $categoryId == $value['id']) {
										$categoryIdParent = $value['parent_id'];
									}
								}

								foreach ($category_array as $key => $value) {
									if ( $categoryIdParent == $value['id']) {
										$categoryNameParent = $value['name'];
									}
								}

								?>
								<li><a href="#tabs-er-<?php echo"$i"; ?>" data-id="<?php print($categoryId); ?>"><?php print($categoryNameParent.' - '.$categoryName); ?></a></li>
								<?php
								$i++;
							}

						?>
					</ul>
					<div class="tab-container row" id="tabs-er-1"></div>
				</div>
			</div>
		</div>
	</section>

	<section class="services">
		<div class="container">
			<div class="row">
				<?php

					$query = "SELECT * FROM `home_services` LIMIT 15";
					$result = mysqli_query($connection, $query);

					while ( $row = mysqli_fetch_assoc($result) ) {

						if ( !file_exists('img/icons/'.$row['link_image']) or empty($row['link_image']) ) {
							$row['link_image']  = 'img/items/template.png';
							$row['name_alt']   =  'Изображение временно отсутствует';
						} else {
							$row['link_image']    = 'img/icons/'.$row['link_image'];
							$row['name_alt']   = 'Icon';
						}

						?>
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 wrapp">
								<div class="icon">
									<img src="<?php print($row['link_image']); ?>" alt="<?php print($row['name_alt']); ?>">
								</div>
								<div class="content">
									<h6><?php print($row['title']); ?></h6>
									<p><?php print($row['text']); ?></p>
								</div>
							</div>
						<?php
					}

				?>
			</div>
		</div>
	</section>

	<?php require('footer.php'); ?>
	
	<script src="js/scripts.min.js"></script>

</body>
</html>
