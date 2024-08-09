<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Risque&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<!--    <link rel="stylesheet" href="./assets/css/main.css">-->
	<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>-->
	<title>Coca-Cola</title>

    <?php wp_head(); ?>
</head>
<body>

	<!-- START HEADER -->
	<header class="header">
		<div class="container">
            <?php
            if (function_exists('the_custom_logo')) :
                ?>
				<h1>
                    <?php echo the_custom_logo(); ?>
				</h1>
            <?php endif ?>
			<div class="nav-container">
				<nav class="nav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container'      => false,
                        'walker'         => new Custom_Walker_Nav_Menu(), // Використовуємо власний Walker
                        'menu_class'     => '', // Ви можете додати клас CSS, якщо потрібно
                        'items_wrap'     => '<ul>%3$s</ul>',
                        'fallback_cb'    => false, // Ви можете визначити функцію, яка буде показана, якщо меню не визначено
                    ));
                    ?>
				</nav>
				<div class="burger-wrapper">
				</div>
				<div class="nav-burger">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container'      => false,
                        'menu_class'     => '', // Ви можете додати клас CSS, якщо потрібно
                        'items_wrap'     => '<ul>%3$s</ul>',
                        'fallback_cb'    => false, // Ви можете визначити функцію, яка буде показана, якщо меню не визначено
                    ));
                    ?>
				</div>
					<button class="burger-menu">
						<span></span>
					</button>
					<div class="burger-menu-container">
					</div>
			</div>
		</div>
	</header>
	<!-- END HEADER -->