<?php
/*
Template Name: Галерея
Template Post Type:  page
*/
get_header();
?>

<section class="bread-crumbs">
		<div class="container">		
					<?php if ( function_exists( 'the_breadcrumbs' ) ) the_breadcrumbs(); ?>	
		</div>
	</section>

    <section class="gallery">
      <div class="container">
        <div class="gallery-wrapp">
        <?php		
				global $post;
				// формируем запрос в БД
				$args = array(
					'post_type' => 'event',					
					'type'    => 'poster',
					'posts_per_page' => 6,	
				);
				global $post;
				$query = new WP_Query( $args );
			
				// проверяем, есть ли посты
				if ( $query->have_posts() ) {
					// создаем переменную-счетчик постов
					$cnt = 0;
					// пока есть посты, выводим их
					while ( $query->have_posts() ) {
						$query->the_post();
						// увеличиваем счетчик постов
						$cnt++;
						
						switch ($cnt) {
							// выводи первый пост							
								case '1':
									?>
											<div class="gallery-block">
                  <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >
                    <a href="<?php the_permalink() ?>">
                      Шедевры
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                  </div>
								
									<?php 	
								break;
							// выводи второй пост	
							case '2':
								?>
								
                <div class="gallery-block gallery-block-left">
                  <a href="<?php the_permalink() ?>">
                  Живопись
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                    <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
                    echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >              
              </div>
									
							
								<?php 	
              break;
                  // выводи третий пост							
								case '3':
									?>
											<div class="gallery-block">
                  <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >
                    <a href="<?php the_permalink() ?>">
                      Графика
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                  </div>
								
									<?php 	
								break;
							// выводи четвертый пост	
							case '4':
								?>
								
                <div class="gallery-block gallery-block-left">
                  <a href="<?php the_permalink() ?>">
                      Скульптура
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                    <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
                    echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >              
              </div>
									
							
								<?php 	
              break;
              							// выводи пятый пост							
								case '5':
									?>
											<div class="gallery-block">
                  <img class="gal"  src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >
                    <a href="<?php the_permalink() ?>">
                      Шедевры
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                  </div>
								
									<?php 	
								break;
							// выводи шестойпост	
							case '6':
								?>
								
                <div class="gallery-block gallery-block-left">
                  <a href="<?php the_permalink() ?>">
                  Живопись
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                    <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
                    echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >              
              </div>
									
							
								<?php 	
              break;
              							// выводи седьмой пост							
								case '7':
									?>
											<div class="gallery-block">
                  <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >
                    <a href="<?php the_permalink() ?>">
                      Графика
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                  </div>
								
									<?php 	
								break;
							// выводи восьмой пост	
							case '8':
								?>
								
                <div class="gallery-block gallery-block-left">
                  <a href="<?php the_permalink() ?>">
                  Скульпртура
                      <img src="<?php echo get_template_directory_uri(). '/assets/img/gallery/arrow.svg'?>"/>
                    </a>
                    <img class="gal" src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
                    echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >              
              </div>
									
							
								<?php 	
							break;
						
						}
						?>
						<!-- Вывода постов, функции цикла: the_title() и т.д. -->
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