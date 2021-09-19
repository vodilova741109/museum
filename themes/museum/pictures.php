<?php
/*
Template Name: События
Template Post Type:  page
*/
get_header();
?>

<section class="bread-crumbs">
		<div class="container">		
					<?php if ( function_exists( 'the_breadcrumbs' ) ) the_breadcrumbs(); ?>	
		</div>
	</section>

    <section class="pictures">
      <div class="container">
        <div class="row">
        <?php
          global $post;

          $myposts = get_posts([ 
            'numberposts' => 12,
          	'post_type' => 'event',
							'order'       => 'ASC',
							// 'type'    => 'exhibitions',
							// 'posts_per_page' => 9,	
          ]);

          if( $myposts ){
            foreach( $myposts as $post ){
              setup_postdata( $post );
              ?>
               <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="pictures-wrapp_block">
              <a href="<?php the_permalink() ?>">
                <img src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
                  ?>" />
                
              <?php
							$post_id = get_the_ID();
							$posttags =get_terms('painter');
							?>
              <div class="pictures-name">
                <?php the_title()?>
              </a>
              <span><?php the_time('Y г.') ?></span>
              </div>                    
              <span class="pictures-material"><?php echo get_post_meta($post_id, 'tehnika', true);?></span>
              <div class="pictures-autor"><?php	echo get_post_meta($post_id, 'responsible', true);?></div>
            </div>
          </div>
              <?php 
            }
          } else {
            // Постов не найдено
          }

          wp_reset_postdata(); // Сбрасываем $post
          ?>
      
        </div>
      </div>
    </section>

    <?php get_footer('post');