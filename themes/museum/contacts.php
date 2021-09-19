<?php
/*
Template Name: Контакты
Template Post Type:  page
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
			<div class="block">						
							<p class="footer-work-email header-work-email">								
								Или пишите на Е-mail: <a href="mailto:<?php echo get_post_meta(193, 'email', true);?>"><?php echo get_post_meta(193, 'email', true);?></a></p>
						</div>
			
			   <p class="article-link">					
				</p>

				<div class="article-socials-wrapp">

						<?php
					get_sidebar('main');?>
						
						<?php
						
						endwhile; // End of the loop.			
						?>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>

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