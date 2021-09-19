<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package museum
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'museum' ); ?></a>

	<header>
		<div class="container">
			<div class="header-top">
				<div class="row">
					<div class="col-xs-10 col-sm-12	col-md-12 col-lg-4">
						<div class="logo-text">			
					
								<?php
								
								if( has_custom_logo() ){
									// логотип есть выводим его
									echo '<img>' . nanima_logo() 
									. '</img>';
									} else {
									echo 'Мастерская-музей';
									}
									?>
						
							<div class="logo-text-wrapp">
							<?php								
								echo '<span>'. get_bloginfo('name') .'</span>'
								.'<h3>' .  get_bloginfo('description') . '</h3>' ;									
								?>
							
							</div>
						</div>
					</div>
					<div class="col-xs-2 col-sm-12	col-md-12 col-lg-8 header-col">
						<nav class="hamburger hamburger3">
							
								
							<?php
								wp_nav_menu( [
								'theme_location'  => 'header_menu',
								'menu'            => 'Верхнее меню', 
								'container'       => 'nav', 
								'container_class' => 'header-nav',       
								'menu_class'      => 'nav-main',       
								'echo'            => true,    
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							
								] );
								?>			
					</div>
				</div>
			</div>
		</div>
	</header>