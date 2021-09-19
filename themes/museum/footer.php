<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package museum
 */

?>

<footer>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6	col-md-6 col-lg-4">
					<div class="logo-text">
					

			
								<?php
								if( has_custom_logo() ){
								// логотип есть выводим его
								echo '<img src="' . get_theme_mod( 'custom_logo1' )
								. '"/>';
								}
								// если нет то выводим название
								else {
								echo 'Мастерская музей';
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
				<div class="col-xs-12 col-sm-6	col-md-6 col-lg-4">
					<div class="row">
							<div class="col-md-6">
							<?php wp_nav_menu ([								 
									'theme_location'  => 'footer_menu',								
										'container'       => 'nav', 
										'container_class' => 'footer-widget', 
										'menu_class'      => 'footer-links', 
										'items_wrap'     => '<ul>%3$s</ul>',
										'echo'            => true
								])?> 
							</div>

							<div class="col-md-6">
									<?php wp_nav_menu ([														
											'theme_location'  => 'footer_menu_second',					
											'container'       => 'nav', 
											'container_class' => 'footer-widget', 
											'menu_class'      => 'footer-links', 
											'items_wrap'     => '<ul>%3$s</ul>',
											'echo'            => true
									])?>											
								</div>
						</div>		
					
				</div>
				<div class="col-xs-12 col-sm-12	col-md-12 col-lg-4">
					<div class="footer-block_wrapp">		
						<?php	get_sidebar('footer');?>			
						<div class="footer-block">
						<?php	get_sidebar('footer2');?>			
							<p class="footer-work-email header-work-email">
								<img  src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/email-i.svg">
								<a href="mailto:<?php echo get_post_meta(193, 'email', true);?>"><?php echo get_post_meta(193, 'email', true);?></a></p>

								<?php	get_sidebar('footer3');?>

						</div>
					</div>
				</div>
			</div>
			<?php	get_sidebar('footer4');?>
			<!-- <div class="footer-bottom">
				<span class="footer-copyright">
                  <?php echo  get_bloginfo( 'name' )  . ' ' . get_bloginfo( 'description' ) . ' &copy; ' . get_the_date('Y.');?>
               </span> 
				<span>Сайт выполнен в учебных целях и не является коммерческим проектом. Название вымышлено. </span>	
			</div> -->

		</div>
	</footer>
<?php wp_footer(); ?>

</body>
</html>
