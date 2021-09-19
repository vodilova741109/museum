<?php
/**
 * The template for displaying all single posts event
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package museum
 */

get_header();


?>


<main id="primary" class="site-main">


<section class="bread-crumbs">
		<div class="container">		
					<?php if ( function_exists( 'the_breadcrumbs' ) ) the_breadcrumbs(); ?>			
		</div>
	</section>

	<section class="article">
		<div class="container">


			<h1><?php the_title()?></h1>
			<?php $post_id = get_the_ID();?>
			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
			<div class="article-wrapp">

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<img  src="<?php 
					//должно находится внутри цикла
					if( has_post_thumbnail() ) {
						echo get_the_post_thumbnail_url('', '
						clay-thumb');
					}
					else {
						echo get_template_directory_uri().'/assets/img/img-default.png';
					}
					?>">
				<!-- получаем id поста -->
				<?php

				the_content();
			?>

			   <p class="article-link">					
				</p>

				<div class="article-socials-wrapp">

						<?php
					get_sidebar('main');?>
			
					<div class="article-socials-nav">
						<?php
						the_post_navigation(
							array(
							
								'prev_text' => '<span class="article-arrow-left no-active">
								<svg width="41" height="16" viewBox="0 0 41 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M0.292892 8.70711C-0.0976295 8.31658 -0.0976295 7.68342 0.292892 7.29289L6.65685 0.928932C7.04738 0.538408 7.68054 0.538408 8.07107 0.928932C8.46159 1.31946 8.46159 1.95262 8.07107 2.34315L2.41422 8L8.07107 13.6569C8.46159 14.0474 8.46159 14.6805 8.07107 15.0711C7.68054 15.4616 7.04738 15.4616 6.65685 15.0711L0.292892 8.70711ZM41 9H1V7H41V9Z"
									fill="#A2A2A2" />
								</svg>'
								 . esc_html__( 'Previous', 'museum' ) . '</span>',

								'next_text' =>  '<span class="article-arrow-right">' .esc_html__( 'Next', 'museum' ) 
								.'<svg width="41" height="16" viewBox="0 0 41 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M0.292892 8.70711C-0.0976295 8.31658 -0.0976295 7.68342 0.292892 7.29289L6.65685 0.928932C7.04738 0.538408 7.68054 0.538408 8.07107 0.928932C8.46159 1.31946 8.46159 1.95262 8.07107 2.34315L2.41422 8L8.07107 13.6569C8.46159 14.0474 8.46159 14.6805 8.07107 15.0711C7.68054 15.4616 7.04738 15.4616 6.65685 15.0711L0.292892 8.70711ZM41 9H1V7H41V9Z"
									fill="#A2A2A2" />
								</svg></span>'
							));				
						endwhile; // End of the loop.			
						?>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>
	<!-- счетчик просмотра страницы -->
<!-- для сбора информации просмотра страницы -->
<?php setPostViews(get_the_ID()); ?>
<!-- / для сбора информации просмотра страницы -->
	<section class="popular-news">
		<div class="container">
			<h2>Популярные события</h2>
			<div class="row">


	
<!-- Популярные статьи на bloggood.ru -->

        <?php
            $args = array( 'posts_per_page' => 6, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value_num', 'post_type' => 'event', 'order' => 'DESC' );
            query_posts($args);
            while ( have_posts() ) : the_post();
        ?>

<div class="col-xs-12 col-sm-6	col-md-4 col-lg-4 popular">
					<div class="news-wrapp_block">
					<a href="<?php the_permalink() ?>" >
						<img src="<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>">
						<?php
							$post_id = get_the_ID();
						
							?>
							</a>		
						<span><?php echo get_post_meta($post_id, 'date', true);?></span>
						<h4><?php the_title()?></h4>
					</div>
				</div>
<?php endwhile; wp_reset_query(); ?>

	</div>
</div>
</section>


</main>

<!-- #main -->
	
	
<?php get_footer('post');