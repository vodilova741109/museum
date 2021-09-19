<?php
/*
Template Name: Главная
Template Post Type:  page
*/
get_header();
?>

	<section class="hero">
		<div class="slider-wrapp">
			<div class="swiper-container section-slider">
				<div class="swiper-wrapper">
					<?php		
						$args = array(
							'post_type' => 'event',
							'order'       => 'DESC',
					
						);
						global $post;
						$query = new WP_Query( $args );
					
					
						$post_num = 0;
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();				

					?>
					<?php $post_num++; ?>
						<div class="swiper-slide" data-num="<?= $post_num; ?>">
							
							<img src="	<?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url();
									}
									else {
										echo get_template_directory_uri().'/assets/img/img-default.png';
									}
									?>" >
						
							<h1>
							<?php 
									$post_id = get_the_ID();
									// $posttags =get_terms('painter');
							  echo get_post_meta($post_id, 'date', true);?> <br>
								<?php	echo get_post_meta($post_id, 'responsible', true);?>
								<!-- <?php 
											if ($posttags) {
												echo $posttags[0]->name . '';
											}
											?>
								</h1> -->

							<a href="<?php the_permalink() ?>" class="slider-btn">Купить билет</a>								
				
						</div>									
						<?php 
							}
						} else {
							// Постов не найдено
						}
						wp_reset_postdata(); // Сбрасываем $post
						?>		
			
				</div>
				<div class="swiper-button_arrows">
					<div class="swiper-button-prev"></div>
					<div class="swiper-button_arrows_num">
						<span class="swiper-num-area">1/</span>
						<!-- объявляем переменную в котороую передаем кол-во опубликованных постов-->
						<?php $published_posts = wp_count_posts('event')->publish;?>
						<!-- выводим кол-во в спан -->
						<span><?php echo $published_posts  ; ?></span>
					</div>
					<div class="swiper-button-next"></div>
				</div>

			</div>
		</div>
	</section>

	<section class="poster">
		<div class="container">
			<h2>Афиша</h2>
			<div class="news-wrapp">
				<div class="product-tabs tabs">
					<div class="info">
						<div class="info-header tabs__nav">
							<a class="tabs__link tabs__link_active info-header-tab active " href="#content-1">Текущие</a>
							<a class="tabs__link info-header-tab" href="#content-2">Будущие</a>
							<a class="tabs__link info-header-tab" href="#content-3">Предыдущие</a>	
						</div>
							<div class="tabs__content">
								<div class="info-tabcontent fade tabs__pane tabs__pane_show" id="content-1 ">
									<div class="grid-container">
														<?php		
											global $post;
											// формируем запрос в БД
											$args = array(
												'post_type' => 'event',					
												'orderby' => 'date',															
												'order' => 'ASC',
												'period'    => 'tekushhij',
												// 'posts_per_page' => 7,	
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
															<div class="s">
																<div class="poster-wrapp_block">
																	<img  src="	<?php 
																			//должно находится внутри цикла
																			if( has_post_thumbnail() ) {
																				echo get_the_post_thumbnail_url();
																			}
																			else {
																				echo get_template_directory_uri().'/assets/img/img-default.png';
																			}
																			?>">
																			<!-- получаем id поста -->
																			<?php $post_id = get_the_ID();?>
																	<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																	
																	<h4><?php echo get_the_title()?></h4>
																</div>
															</div>									
															<?php 
															break;
														// выводи второй пост
															case '2':
																?>
															<div class="e">
															<div class="poster-wrapp_block">
																	<img  src="	<?php 
																			//должно находится внутри цикла
																			if( has_post_thumbnail() ) {
																				echo get_the_post_thumbnail_url();
																			}
																			else {
																				echo get_template_directory_uri().'/assets/img/img-default.png';
																			}
																			?>">
																		<!-- получаем id поста -->
																		<?php $post_id = get_the_ID();?>
																	<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																	<h4><?php echo get_the_title()?></h4>
																</div>
															</div>
															
																<?php 	
															break;
														// выводи  третий пост	
															case '3':
																?>
															<div class="er">
															<div class="poster-wrapp_block">
																	<img  src="	<?php 
																			//должно находится внутри цикла
																			if( has_post_thumbnail() ) {
																				echo get_the_post_thumbnail_url();
																			}
																			else {
																				echo get_template_directory_uri().'/assets/img/img-default.png';
																			}
																			?>">
																	<!-- получаем id поста -->
																	<?php $post_id = get_the_ID();?>
																	<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																	<h4><?php echo get_the_title()?></h4>
																</div>
															</div>
																	
																<?php

															break;	
																// выводи четвертый пост	
																case '4':
																	?>
																<div class="t">
																<div class="poster-wrapp_block">
																		<img  src="	<?php 
																				//должно находится внутри цикла
																				if( has_post_thumbnail() ) {
																					echo get_the_post_thumbnail_url();
																				}
																				else {
																					echo get_template_directory_uri().'/assets/img/img-default.png';
																				}
																				?>">
																			<!-- получаем id поста -->
																			<?php $post_id = get_the_ID();?>
																	<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																		<h4><?php echo get_the_title()?></h4>
																	</div>
																</div>
																		
																	<?php
								
																break;	
																	// выводи пятый пост	
															case '5':
																?>
															<div class="d">
															<div class="poster-wrapp_block">
																	<img  src="	<?php 
																			//должно находится внутри цикла
																			if( has_post_thumbnail() ) {
																				echo get_the_post_thumbnail_url();
																			}
																			else {
																				echo get_template_directory_uri().'/assets/img/img-default.png';
																			}
																			?>">
																<!-- получаем id поста -->
																<?php $post_id = get_the_ID();?>
																	<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																	<h4><?php echo get_the_title()?></h4>
																</div>
															</div>
																	
																<?php

															break;	
																// выводи шестой пост
																case '6':
																	?>
																<div class="g">
																<div class="poster-wrapp_block">
																		<img  src="	<?php 
																				//должно находится внутри цикла
																				if( has_post_thumbnail() ) {
																					echo get_the_post_thumbnail_url();
																				}
																				else {
																					echo get_template_directory_uri().'/assets/img/img-default.png';
																				}
																				?>">
																			<!-- получаем id поста -->
																			<?php $post_id = get_the_ID();?>
																	<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																		<h4><?php echo get_the_title()?></h4>
																	</div>
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
								<div class="info-tabcontent fade tabs__pane" id="content-2">
										<div class="grid-container">
																<?php		
													global $post;
													// формируем запрос в БД
													$args = array(
														'post_type' => 'event',					
															'orderby' => 'date',															
															'order' => 'ASC',
															'period'    => 'budushhij',
														// 'posts_per_page' => 7,	
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
																	<div class="s">
																		<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																					<!-- получаем id поста -->
																					<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>									
																	<?php 
																	break;
																// выводи второй пост
																	case '2':
																		?>
																	<div class="e">
																	<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																				<!-- получаем id поста -->
																				<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>
																	
																		<?php 	
																	break;
																// выводи  третий пост	
																	case '3':
																		?>
																	<div class="er">
																	<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																			<!-- получаем id поста -->
																			<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>
																			
																		<?php

																	break;	
																		// выводи четвертый пост	
																		case '4':
																			?>
																		<div class="t">
																		<div class="poster-wrapp_block">
																				<img  src="	<?php 
																						//должно находится внутри цикла
																						if( has_post_thumbnail() ) {
																							echo get_the_post_thumbnail_url();
																						}
																						else {
																							echo get_template_directory_uri().'/assets/img/img-default.png';
																						}
																						?>">
																					<!-- получаем id поста -->
																					<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																				<h4><?php echo get_the_title()?></h4>
																			</div>
																		</div>
																				
																			<?php
										
																		break;	
																			// выводи пятый пост	
																	case '5':
																		?>
																	<div class="d">
																	<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																		<!-- получаем id поста -->
																		<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>
																			
																		<?php

																	break;	
																		// выводи шестой пост
																		case '6':
																			?>
																		<div class="g">
																		<div class="poster-wrapp_block">
																				<img  src="	<?php 
																						//должно находится внутри цикла
																						if( has_post_thumbnail() ) {
																							echo get_the_post_thumbnail_url();
																						}
																						else {
																							echo get_template_directory_uri().'/assets/img/img-default.png';
																						}
																						?>">
																					<!-- получаем id поста -->
																					<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																				<h4><?php echo get_the_title()?></h4>
																			</div>
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
								<div class="info-tabcontent fade tabs__pane" id="content-3">
										<div class="grid-container">
																<?php		
													global $post;
													// формируем запрос в БД
													$args = array(
														'post_type' => 'event',					
															'orderby' => 'date',															
															'order' => 'ASC',
															'period'    => 'predydushhij',
								
														
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
																	<div class="s">
																		<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																					<!-- получаем id поста -->
																					<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>									
																	<?php 
																	break;
																// выводи второй пост
																	case '2':
																		?>
																	<div class="e">
																	<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																				<!-- получаем id поста -->
																				<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>
																	
																		<?php 	
																	break;
																// выводи  третий пост	
																	case '3':
																		?>
																	<div class="er">
																	<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																			<!-- получаем id поста -->
																			<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>
																			
																		<?php

																	break;	
																		// выводи четвертый пост	
																		case '4':
																			?>
																		<div class="t">
																		<div class="poster-wrapp_block">
																				<img  src="	<?php 
																						//должно находится внутри цикла
																						if( has_post_thumbnail() ) {
																							echo get_the_post_thumbnail_url();
																						}
																						else {
																							echo get_template_directory_uri().'/assets/img/img-default.png';
																						}
																						?>">
																					<!-- получаем id поста -->
																					<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																				<h4><?php echo get_the_title()?></h4>
																			</div>
																		</div>
																				
																			<?php
										
																		break;	
																			// выводи пятый пост	
																	case '5':
																		?>
																	<div class="d">
																	<div class="poster-wrapp_block">
																			<img  src="	<?php 
																					//должно находится внутри цикла
																					if( has_post_thumbnail() ) {
																						echo get_the_post_thumbnail_url();
																					}
																					else {
																						echo get_template_directory_uri().'/assets/img/img-default.png';
																					}
																					?>">
																		<!-- получаем id поста -->
																		<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																			<h4><?php echo get_the_title()?></h4>
																		</div>
																	</div>
																			
																		<?php

																	break;	
																		// выводи шестой пост
																		case '6':
																			?>
																		<div class="g">
																		<div class="poster-wrapp_block">
																				<img  src="	<?php 
																						//должно находится внутри цикла
																						if( has_post_thumbnail() ) {
																							echo get_the_post_thumbnail_url();
																						}
																						else {
																							echo get_template_directory_uri().'/assets/img/img-default.png';
																						}
																						?>">
																					<!-- получаем id поста -->
																					<?php $post_id = get_the_ID();?>
																			<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
																				<h4><?php echo get_the_title()?></h4>
																			</div>
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
						
						</div>
					</div>
				</div>
			</div>

			<div class="btn-wrapp">
				<a href="http://museum/sobytiya/" class="slider-btn btn-white">Вся афиша</a>
			</div>
		
		</div>
	</section>

	<section class="programs">
		<div class="container">
			<h2>Образовательные программы</h2>
			<div class="slider-wrapp">
				<div class="swiper-container programs-slider">
					<div class="swiper-wrapper">

					<?php		
						$args = array(
							'post_type' => 'programm',
							'order'       => 'ASC',
							
							// 'posts_per_page' => 7,	
						);
						global $post;
						$query = new WP_Query( $args );
					
					
						$post_num = 0;
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();				

					?>
					<?php $post_num++; ?>
					<div class="swiper-slide" data-num="<?= $post_num; ?>">
				
					<img  src="	<?php 
													//должно находится внутри цикла
													if( has_post_thumbnail() ) {
														echo get_the_post_thumbnail_url();
													}
													else {
														echo get_template_directory_uri().'/assets/img/img-default.png';
													}
													?>">
							<div class="programs-slide-text">
								<h3><?php the_title()?></h3>
								<?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '')?>
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
					<div class="swiper-button_arrows">
						<div class="swiper-button-prev"></div>
						<div class="swiper-button_arrows_num">
							<span class="swiper-num-area">1/</span>
							<?php $published_posts = wp_count_posts('programm')->publish;?>
						<!-- выводим кол-во в спан -->
						<span><?php echo $published_posts  ; ?></span>
						</div>
						<div class="swiper-button-next"></div>
					</div>

				</div>
			</div>
			<div class="btn-wrapp">
				<a href="http://museum/__trashed/" class="slider-btn btn-white">Все программы</a>
			</div>

		</div>
	</section>


	<section class="news">
		<div class="container">
			<h2>События</h2>
			<div class="news-wrapp">
				<div class="row">
				<?php		
				global $post;
				// формируем запрос в БД
				$args = array(
					'post_type' => 'event',					
					'type'    => 'poster',
					'posts_per_page' => 3,	
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
											
								<div class="col-xs-12 col-sm-12	col-md-8 col-lg-8">
									<div class="news-wrapp_block">
									<a href="<?php the_permalink() ?>"><img  src="	<?php 
												//должно находится внутри цикла
												if( has_post_thumbnail() ) {
													echo get_the_post_thumbnail_url();
												}
												else {
													echo get_template_directory_uri().'/assets/img/img-default.png';
												}
												?>"></a>
										<?php $post_id = get_the_ID();?>
										<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
										<a href="<?php the_permalink() ?>"><h4><?php the_title()?></h4></a>
										<?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '')?>
									</div>
								</div>
								<?php 
								break;
							// выводи второй пост
								case '2':
									?>
											<div class="col-xs-12 col-sm-12	col-md-4 col-lg-4 news-last-block">
											<div class="news-wrapp_block">

											<a href="<?php the_permalink() ?>"><img  src="	<?php 
												//должно находится внутри цикла
												if( has_post_thumbnail() ) {
													echo get_the_post_thumbnail_url();
												}
												else {
													echo get_template_directory_uri().'/assets/img/img-default.png';
												}
												?>"></a>
										<?php $post_id = get_the_ID();?>
										<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
										<a href="<?php the_permalink() ?>"><h4><?php the_title()?></h4></a>
											</div>
										
								
									<?php 	
								break;
							// выводи  третий пост	
							case '3':
								?>
								
										<div class="news-wrapp_block">

										<a href="<?php the_permalink() ?>"><img  src="	<?php 
												//должно находится внутри цикла
												if( has_post_thumbnail() ) {
													echo get_the_post_thumbnail_url();
												}
												else {
													echo get_template_directory_uri().'/assets/img/img-default.png';
												}
												?>"></a>
										<?php $post_id = get_the_ID();?>
										<span> <?php echo get_post_meta($post_id, 'date', true);?></span>
										<a href="<?php the_permalink() ?>"><h4><?php the_title()?></h4></a>
										</div>
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
			<div class="btn-wrapp">
				<a href="http://museum/sobytiya/" class="slider-btn btn-white">Все СОБЫТИЯ</a>
			</div>

		</div>
	</section>



<?php
// get_sidebar();
get_footer();



