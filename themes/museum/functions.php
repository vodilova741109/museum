<?php
/**
 * museum functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package museum
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
//если функция не существует
if ( ! function_exists( 'museum_setup' ) ) :
	/**
     * то создадим ее
	 */

	function museum_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on museum, use a find and replace
		 * to change 'museum' to the name of your theme in all the template files.
		 */
		// подключение файлов перевода
		load_theme_textdomain( 'museum', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
	// регистрация миниатюры
		add_theme_support( 'post-thumbnails' );					
		add_image_size( 'post-thumb', 850, 480, true );
	
		

		## отключаем создание миниатюр файлов для указанных размеров
		add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
		function delete_intermediate_image_sizes( $sizes ){
			// размеры которые нужно удалить
			return array_diff( $sizes, [
				'1536x1536',
				'2048x2048',
			] );
		}

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus([

			'header_menu' => 'Меню в шапке',
			'footer_menu' => 'Меню в подвале',
			'footer_menu_second' => 'Меню в подвале 2',
			
		]);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'museum_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
				add_theme_support(
					'custom-logo',
					array(
						'height'      => 250,
						'width'       => 250,
						'flex-width'  => true,
						'flex-height' => true,
					)	
				
				);
				
		// регистрация дополнительных двух логотипов (вывела один)
		add_action( 'customize_register', 'custom_logo_uploader' );
		function custom_logo_uploader($wp_customize) {

						$wp_customize->add_section( 'upload_custom_logo', array(
										'title'          => __('Custom logo', 'museum'),
										'description'    =>  __('Display a custom logo?', 'museum'),
										'priority'       => 25,
						) );

						$wp_customize->add_setting( 'custom_logo1', array(
										'default'        => '',
						) );
					// настраивает класс управления изображением
						$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo1', array(
										'label'   => __('Custom logo', 'museum'), 
										'section' => 'upload_custom_logo',
										'settings'   => 'custom_logo1',
						) ) );

						$wp_customize->add_setting( 'custom_logo2', array(
										'default'        => '',
						) );

						$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo2', array(
										'label'   => __('Custom logo', 'museum'), 
										'section' => 'upload_custom_logo', // put the name of whatever section you want to add your settings
										'settings'   => 'custom_logo2',
						) ) );
		}
/*
				*Custom_logo без циклической ссылки на главной не работает для кастомных лого
		*/
		function nanima_logo() {
			// объявляем переменную для получения пути к картинке
			// get_theme_mod- Получает значение указанной опции (настройки) текущей темы.
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			// если это домашняя страница, то выводим путь картинке без ссылки на главную
			if(is_home()){
				//  wp_get_attachment_image - получает тег к картинке
			$html = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
			'class' => 'custom-logo',
			'itemprop' => 'url image',
			'alt' => get_bloginfo('name')
			) );}
			else {
			$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" title="'. get_bloginfo('name') .'" itemprop="url">%2$s</a>',
			esc_url( home_url( '/' ) ),
			wp_get_attachment_image( $custom_logo_id, 'full', false, array(
			'class' => 'custom-logo',
			'itemprop' => 'url image',
			'alt' => get_bloginfo('name'))
			) );}
			
			return $html;
			}
			add_filter( 'get_custom_logo', 'nanima_logo' );			

	}

	// Регистрация произвольного типа записей
		add_action( 'init', 'register_post_types' );
		function register_post_types(){
			register_post_type( 'event', [
				'label'  => null,
				'labels' => [
					'name'               => __('Events', 'museum'),  // основное название для типа записи
					'singular_name'      => __('Event', 'museum' ), // название для одной записи этого типа
					'add_new'            => __('Add event', 'museum' ), // для добавления новой записи
					'add_new_item'       => __('Adding a event', 'museum' ), // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => __('Editing a event', 'museum' ), // для редактирования типа записи
					'new_item'           => __('New event', 'museum' ), // текст новой записи
					'view_item'          => __('Watch events', 'museum' ), // для просмотра записи этого типа.
					'search_items'       => __('Search for events', 'museum' ), // для поиска по этим типам записи
					'not_found'          => __('Not found', 'museum' ), // если в результате поиска ничего не было найдено
					'not_found_in_trash' => __('Not found in cart', 'museum' ), // если не было найдено в корзине
					'parent_item_colon'  => '', // для родителей (у древовидных типов)
					'menu_name'          => __('Event', 'museum' ), // название меню
				],
				'description'         => __('Events section', 'museum' ),
				'public'              => true,
				// 'publicly_queryable'  => null, // зависит от public
				// 'exclude_from_search' => null, // зависит от public
				// 'show_ui'             => null, // зависит от public
				// 'show_in_nav_menus'   => null, // зависит от public
				'show_in_menu'        => true, // показывать ли в меню адмнки
				// 'show_in_admin_bar'   => null, // зависит от show_in_menu
				'show_in_rest'        => true, // добавить в REST API. C WP 4.7 Редактировать запись в админке
				'rest_base'           => null, // $post_type. C WP 4.7
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-calendar-alt',
				'capability_type'   => 'post',
				//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
				//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
				'hierarchical'        => false,
				'supports'            => [ 'title', 'editor', 'excerpt','thumbnail','custom-fields','page-attributes', ], // 'title','editor','author','excerpt','trackbacks','comments','revisions','page-attributes','post-formats'
				'taxonomies'          => [],
				'has_archive'         => true,
				'rewrite'             => true,
				'query_var'           => true,
				'preview'             => true,
			] );
			
			
		}
		// хук, через который подключается функция
			// регистрирующая новые таксономии (create_event_taxonomies)
			add_action( 'init', 'create_event_taxonomies' );

			// функция, создающая 2 новые таксономии "types" и "citys" для постов типа "event"
			function create_event_taxonomies(){

				// Добавляем древовидную таксономию 'type' (как категории)
				register_taxonomy('type', array('event'), array(
					'hierarchical'  => true,
					'labels'        => array(
						'name'              => _x( 'Types', 'taxonomy general name', 'museum' ),
						'singular_name'     => _x( 'Type', 'taxonomy singular name', 'museum' ),
						'search_items'      =>  __( 'Search Types', 'museum' ),
						'all_items'         => __( 'All Types', 'museum' ),
						'parent_item'       => __( 'Parent Type', 'museum' ),
						'parent_item_colon' => __( 'Parent Type:', 'museum' ),
						'edit_item'         => __( 'Edit Type', 'museum' ),
						'update_item'       => __( 'Update Type', 'museum' ),
						'add_new_item'      => __( 'Add New Type', 'museum' ),
						'new_item_name'     => __( 'New Type Name', 'museum' ),
						'menu_name'         => __( 'Type', 'museum' ),
					),
					'show_ui'       => true,
					'query_var'     => true,
					'rewrite'       => array( 'slug' => 'the_type' ), // свой слаг в URL
				));

				// Добавляем НЕ древовидную таксономию 'painter' (как метки)
				register_taxonomy('painter', 'event',array(
					'hierarchical'  => false,
					'labels'        => array(
						'name'                        => _x( 'Painters', 'taxonomy general name', 'museum' ),
						'singular_name'               => _x( 'Painter', 'taxonomy singular name', 'museum' ),
						'search_items'                =>  __( 'Search Painters', 'museum' ),
						'popular_items'               => __( 'Popular Painters', 'museum' ),
						'all_items'                   => __( 'All Painters', 'museum' ),
						'parent_item'                 => null,
						'parent_item_colon'           => null,
						'edit_item'                   => __( 'Edit Painter', 'museum' ),
						'update_item'                 => __( 'Update Painter', 'museum' ),
						'add_new_item'                => __( 'Add New Painter', 'museum' ),
						'new_item_name'               => __( 'New Painter Name', 'museum' ),
						'separate_items_with_commas'  => __( 'Separate Painters with commas', 'museum' ),
						'add_or_remove_items'         => __( 'Add or remove Painters', 'museum' ),
						'choose_from_most_used'       => __( 'Choose from the most used Painters', 'museum' ),
						'menu_name'                   => __( 'Painters', 'museum' ),
					),
					'show_ui'       => true,
					'query_var'     => true,
					//'rewrite'       => array( 'slug' => 'the_painter' ), // свой слаг в URL
				));
								// Добавляем НЕ древовидную таксономию 'period' (как метки)
								register_taxonomy('period', 'event',array(
									'hierarchical'  => false,
									'labels'        => array(
										'name'                        => _x( 'Periods', 'taxonomy general name', 'museum' ),
										'singular_name'               => _x( 'Period', 'taxonomy singular name', 'museum' ),
										'search_items'                =>  __( 'Search Period', 'museum' ),
										'popular_items'               => __( 'Popular Period', 'museum' ),
										'all_items'                   => __( 'All Periods', 'museum' ),
										'parent_item'                 => null,
										'parent_item_colon'           => null,
										'edit_item'                   => __( 'Edit Period', 'museum' ),
										'update_item'                 => __( 'Update Period', 'museum' ),
										'add_new_item'                => __( 'Add New Period', 'museum' ),
										'new_item_name'               => __( 'New Period Name', 'museum' ),
										'separate_items_with_commas'  => __( 'Separate Periods with commas', 'museum' ),
										'add_or_remove_items'         => __( 'Add or remove Periods', 'museum' ),
										'choose_from_most_used'       => __( 'Choose from the most used Periods', 'museum' ),
										'menu_name'                   => __( 'Periods', 'museum' ),
									),
									'show_ui'       => true,
									'query_var'     => true,
									//'rewrite'       => array( 'slug' => 'the_periode' ), // свой слаг в URL
								));
				
				

		}

	// Регистрация произвольного типа записей programm
	add_action( 'init', 'register_post_types_programm' );
	function register_post_types_programm(){
		register_post_type( 'programm', [
			'label'  => null,
			'labels' => [
				'name'               => __('Educational programs', 'museum' ),  // основное название для типа записи
				'singular_name'      => __('Educational program', 'museum' ), // название для одной записи этого типа
				'add_new'            => __('Add programm', 'museum' ), // для добавления новой записи
				'add_new_item'       => __('Adding a programm', 'museum' ), // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => __('Editing a programm', 'museum' ), // для редактирования типа записи
				'new_item'           => __('New programm', 'museum' ), // текст новой записи
				'view_item'          => __('Watch programms', 'museum' ), // для просмотра записи этого типа.
				'search_items'       => __('Search for programms', 'museum' ), // для поиска по этим типам записи
				'not_found'          => __('Not found', 'museum' ), // если в результате поиска ничего не было найдено
				'not_found_in_trash' => __('Not found in cart', 'museum' ), // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => __('Educational program', 'museum' ), // название меню
			],
			'description'         => __('Section with programs', 'museum' ),
			'public'              => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			// 'show_ui'             => null, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => true, // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => true, // добавить в REST API. C WP 4.7 Редактировать запись в админке
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => [ 'title', 'editor', 'thumbnail','custom-fields' ], // 'title','editor','author','excerpt','trackbacks','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => [],
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		] );
	}

		

endif;
add_action( 'after_setup_theme', 'museum_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function museum_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'museum_content_width', 640 );
}
add_action( 'after_setup_theme', 'museum_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function museum_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'museum' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'museum' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'museum_widgets_init' );

/**
 * // правильный способ подключить стили и скрипты
 * Enqueue scripts and styles.
 */
function museum_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri(). '/assets/css/bootstrap.min.css', 'style', time());
	wp_enqueue_style( 'swiper-slider', get_template_directory_uri(). '/assets/css/swiper.min.css', 'style', time());
	wp_enqueue_style( 'museum-theme', get_stylesheet_directory_uri() . '/assets/css/style.css', 'style', time());
   
	wp_enqueue_style('Open-Sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&family=Roboto:wght@300;400;500;700;900&display=swap');
	wp_enqueue_style('Lato', 'https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap');
	wp_enqueue_style('Playfair', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js');
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script('swiper', get_template_directory_uri() . '/js/swiper.min.js', null, time(), true);
	wp_enqueue_script('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js' , 'jquery', null, true);
	wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', null, time(), true);

	wp_enqueue_script( 'museum-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
	
   
	

add_action( 'wp_enqueue_scripts', 'museum_scripts' );

/**
 * Подключаем стиль в footere.
 */

function min_add_footer_styles() {

	wp_enqueue_style('min-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css');	
};
add_action( 'wp_footer', 'min_add_footer_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



/**
 * Подключение сайдбара
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// 1-й сайдбар
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar on the main',  'museum' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'museum' ),
			'before_widget' => '<div class="article-socials">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="share">',
			'after_title'   => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar in footer', 'museum' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'museum' ),
			'before_widget' => '<div class="footer-block">	<p class="footer-work-time header-work-time">
			<img  src="' . get_template_directory_uri() . '/assets/img/icons/clock-i.svg">',
			'after_widget'  => '</p></div>',
			'before_title'  => '',
			'after_title'   => '<br>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar second in footer', 'museum' ),
			'id'            => 'footer-sidebar2',
			'description'   => esc_html__( 'Add widgets here.', 'museum' ),
			'before_widget' => '<p class="footer-phone-contact header-phone-contact">
			<img  src="' . get_template_directory_uri() . '/assets/img/icons/phone-i.svg">',
			'after_widget'  => '</p>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar third in footer', 'museum' ),
			'id'            => 'footer-sidebar3',
			'description'   => esc_html__( 'Add widgets here.', 'museum' ),
			'before_widget' => '		<div class="footer-socials">
			<div class="social-links">',
			'after_widget'  => '</div>
			</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar fourth in footer', 'museum' ),
			'id'            => 'footer-sidebar4',
			'description'   => esc_html__( 'Add widgets here.', 'museum' ),
			'before_widget' => '<div class="footer-bottom">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	
}

add_action( 'widgets_init', 'universal_theme_widgets_init' );

/**
 * Добавление нового виджета Networks_Widget.
 */
class Networks_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'networks_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: networks_Widget
			'Социальные сети',
			array( 'description' => 'Поделиться в соцсети', 'classname' => 'widget-networks', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
	
			add_action('wp_head', array( $this, 'add_networks_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'] ;		
		$link_1= $instance['link_1'] ;
		$link_2= $instance['link_2'] ;
		$link_3= $instance['link_3'] ;
		$link_4= $instance['link_4'] ;
		$link_5= $instance['link_5'] ;
	

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		
		<?php
		if ( ! empty( $link_1) ) {
			echo '<a target="_blank" href="' .$link_1 . '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets\img\article\socials\vk.svg">
			</a>';
		}
		if ( ! empty( $link_2) ) {
			echo '<a target="_blank" href="' .$link_2 . '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets\img\article\socials\instagram.svg">
			</a>';
		}
	
		if ( ! empty( $link_3) ) {
			echo '<a target="_blank" href="' .$link_3. '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets\img\article\socials\telegram.svg">
			</a>';
		}
		if ( ! empty( $link_4) ) {
			echo '<a target="_blank" href="' .$link_4. '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets\img\article\socials\facebook.svg">
			</a>';
		}
		if ( ! empty( $link_5) ) {
			echo '<a target="_blank" href="' .$link_5. '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets\img\article\socials\whatsapp.svg">
			</a>';
		}
			
		// if ( ! empty( $link) ) {
		// 	echo '<a target="_blank" href="' .$link. '">
		// 	<img    src=" ' . get_template_directory_uri(  ). '/assets/img/article/social/fb.svg">
		// 	</a>';
		// }


	
	
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Поделиться';		
		$link_1  = @ $instance['link_1'] ?: 'https://vk.ru';
		$link_2  = @ $instance['link_2'] ?: 'https://instagram.com';
		$link_3  = @ $instance['link_3'] ?: 'https://telegram.com';
		$link_4  = @ $instance['link_4'] ?: 'https://facebook.com';
		$link_5  = @ $instance['link_5'] ?: 'https://whatsapp.com';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'link_1' ); ?>"><?php _e( 'Link to на vk:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_1' ); ?>" name="<?php echo $this->get_field_name( 'link_1' ); ?>" type="text" value="<?php echo esc_attr( $link_1 ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link_2' ); ?>"><?php _e( 'Link to на instagram:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_2' ); ?>" name="<?php echo $this->get_field_name( 'link_2' ); ?>" type="text" value="<?php echo esc_attr( $link_2 ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link_3' ); ?>"><?php _e( 'Link to на telegram:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_3' ); ?>" name="<?php echo $this->get_field_name( 'link_3' ); ?>" type="text" value="<?php echo esc_attr( $link_3 ); ?>">
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'link_4' ); ?>"><?php _e( 'Link to на facebook:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_4' ); ?>" name="<?php echo $this->get_field_name( 'link_4' ); ?>" type="text" value="<?php echo esc_attr( $link_4 ); ?>">
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'link_5' ); ?>"><?php _e( 'Link to на whatsapp:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_5' ); ?>" name="<?php echo $this->get_field_name( 'link_5' ); ?>" type="text" value="<?php echo esc_attr( $link_5 ); ?>">
			</p>



	
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		
		$instance['link_1'] = ( ! empty( $new_instance['link_1'] ) ) ? strip_tags( $new_instance['link_1'] ) : '';
		$instance['link_2'] = ( ! empty( $new_instance['link_2'] ) ) ? strip_tags( $new_instance['link_2'] ) : '';
		$instance['link_3'] = ( ! empty( $new_instance['link_3'] ) ) ? strip_tags( $new_instance['link_3'] ) : '';
		$instance['link_4'] = ( ! empty( $new_instance['link_4'] ) ) ? strip_tags( $new_instance['link_4'] ) : '';
		$instance['link_5'] = ( ! empty( $new_instance['link_5'] ) ) ? strip_tags( $new_instance['link_5'] ) : '';




		return $instance;
	}

	// скрипт виджета
	function add_networks_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_networks_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Networks_Widget

// регистрация schedule_widget в WordPress
function register_networks_widget() {
	register_widget( 'Networks_Widget' );
}
add_action( 'widgets_init', 'register_networks_widget' );

// окончание регистрации виджета




/**
 * Добавление нового виджета Schedule - График.
 */
class Schedule_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'schedule_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: Schedule_Widget
			'Рабочее время',
			array( 'description' => 'График работы', 'classname' => 'widget-schedule', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
	
			add_action('wp_head', array( $this, 'add_schedule_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'] ;		
		$output= $instance['output'] ;
		$work_time= $instance['work_time'] ;
	
	 

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		
		<?php
		if ( ! empty($output) ) {
			echo '<span>' .	$output . '</span>';
		}
		if ( ! empty($work_time) ) {
			echo '<span>' .	$work_time . '</span>';
		}	
	
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = $instance['title'] ?: 	'График работы';		
		$output= $instance['output'] ?: 'ПН: выходной';		
		$work_time= $instance['work_time']?: 'ВТ-ВС: 12:00–20:00';	
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'output' ); ?>"><?php _e( 'Enter holiday time:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'output' ); ?>" name="<?php echo $this->get_field_name( 'output' ); ?>" type="text" value="<?php echo esc_attr( $output ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'work_time' ); ?>"><?php _e( 'Enter business hours:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'work_time' ); ?>" name="<?php echo $this->get_field_name( 'work_time'); ?>" type="text" value="<?php echo esc_attr( $work_time ); ?>">
			</p>
			
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		
		$instance['output'] = ( ! empty( $new_instance['output'] ) ) ? strip_tags( $new_instance['output'] ) : '';
		$instance['work_time'] = ( ! empty( $new_instance['work_time'] ) ) ? strip_tags( $new_instance['work_time'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_schedule_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_schedule_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Schedule_Widget

// регистрация schedule__widget в WordPress
function register_schedule__widget() {
	register_widget( 'Schedule_Widget' );
}
add_action( 'widgets_init', 'register_schedule__widget' );

// окончание регистрации виджета




// регистрация phone_widget в WordPress
function register_phone_widget() {
	register_widget( 'Phone_Widget' );
}
add_action( 'widgets_init', 'register_phone_widget' );

// окончание регистрации виджета


/**
 * Добавление нового виджета Phone - Блок с телефонами.
 */
class Phone_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'phone_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: Phone_Widget
			'Телефон',
			array( 'description' => 'Контакты', 'classname' => 'widget-phone', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
	
			add_action('wp_head', array( $this, 'add_phone_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {	
		$phone_1= $instance['phone_1'] ;
		$phone_2= $instance['phone_2'] ;
	
	 

		echo $args['before_widget'];
		
		if ( ! empty($phone_1) ) {
			echo '<a href="tel:' .$phone_1 .'">' .	$phone_1 . '</a>';
		}
		if ( ! empty($phone_2) ) {
			echo '<a href="tel:+' .$phone_2 .'">' .	$phone_2 . '</a>';
		}	
	
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$phone_1= $instance['phone_1'] ?: 	'+7 911 111–22-33';		
		$phone_2= $instance['phone_2'] ?: '8 816 2 11-22-33';		
		
		?>
	

			<p>
				<label for="<?php echo $this->get_field_id( 'phone_1' ); ?>"><?php _e( 'Enter your mobile phone number:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'phone_1' ); ?>" name="<?php echo $this->get_field_name( 'phone_1' ); ?>" type="text" value="<?php echo esc_attr( $phone_1 ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('phone_2'); ?>"><?php _e( 'Enter your work phone number:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('phone_2'); ?>" name="<?php echo $this->get_field_name('phone_2'); ?>" type="text" value="<?php echo esc_attr( $phone_2 ); ?>">
			</p>
			
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['phone_1'] = ( ! empty( $new_instance['phone_1'] ) ) ? strip_tags( $new_instance['phone_1'] ) : '';		
		$instance['phone_2'] = ( ! empty( $new_instance['phone_2'] ) ) ? strip_tags( $new_instance['phone_2'] ) : '';		
		return $instance;
	}

	// скрипт виджета
	function add_phone_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_phone_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Phone_Widget

// регистрация phone__widget в WordPress
function register_phone__widget() {
	register_widget( 'Phone_Widget' );
}
add_action( 'widgets_init', 'register_phone__widget' );

// окончание регистрации виджета


/**
 * Добавление нового виджета Social_links_Widget.
 */
class Social_Links extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: networks_Widget
			'Социальные ссылки',
			array( 'description' => 'Ссылки на соцсети', 'classname' => 'widget-networks', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
	
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {	
		$link_1= $instance['link_1'] ;
		$link_2= $instance['link_2'] ;
		$link_3= $instance['link_3'] ;
	
	

		echo $args['before_widget'];

		if ( ! empty( $link_1) ) {
			echo '<a target="_blank" href="' .$link_1 . '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets/img/icons/vk-i.svg">
			</a>';
		}
		if ( ! empty( $link_2) ) {
			echo '<a target="_blank" href="' .$link_2 . '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets/img/icons/instagram-i.svg">
			</a>';
		}
	
		if ( ! empty( $link_3) ) {
			echo '<a target="_blank" href="' .$link_3. '">
			<img    src=" ' . get_template_directory_uri(  ). '/assets/img/icons/facebook-i.svg">
			</a>';
		}	
	
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {			
		$link_1  = @ $instance['link_1'] ?: 'https://vk.ru';
		$link_2  = @ $instance['link_2'] ?: 'https://instagram.com';		
		$link_3  = @ $instance['link_3'] ?: 'https://facebook.com';		
		?>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'link_1' ); ?>"><?php _e( 'Link to на vk:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_1' ); ?>" name="<?php echo $this->get_field_name( 'link_1' ); ?>" type="text" value="<?php echo esc_attr( $link_1 ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link_2' ); ?>"><?php _e( 'Link to на instagram:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_2' ); ?>" name="<?php echo $this->get_field_name( 'link_2' ); ?>" type="text" value="<?php echo esc_attr( $link_2 ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link_3' ); ?>"><?php _e( 'Link to на facebook:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_3' ); ?>" name="<?php echo $this->get_field_name( 'link_3' ); ?>" type="text" value="<?php echo esc_attr( $link_3 ); ?>">
			</p>	
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['link_1'] = ( ! empty( $new_instance['link_1'] ) ) ? strip_tags( $new_instance['link_1'] ) : '';
		$instance['link_2'] = ( ! empty( $new_instance['link_2'] ) ) ? strip_tags( $new_instance['link_2'] ) : '';
		$instance['link_3'] = ( ! empty( $new_instance['link_3'] ) ) ? strip_tags( $new_instance['link_3'] ) : '';	
		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Links

// регистрация schedule_widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Links' );
}
add_action( 'widgets_init', 'register_social_widget' );

// окончание регистрации виджета


/**
 * Добавление нового виджета Сopyright.
 */
class Сopyright_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'сopyright_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: Сopyright_Widget
			'Копирайт',
			array( 'description' => 'Текстовый виджет', 'classname' => 'widget-сopyright', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
	
			add_action('wp_head', array( $this, 'add_сopyright_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {	
		$сopyright_1= $instance['сopyright_1'] ;
		$сopyright_2= $instance['сopyright_2'] ;
	
	 

		echo $args['before_widget'];
		
		if ( ! empty($сopyright_1) ) {
			echo '<span class="footer-copyright">'  .	$сopyright_1 . ' &copy; ' . get_the_date('Y.') . '</span> ';
		}
		if ( ! empty($сopyright_2) ) {
			echo '<span>' .	$сopyright_2 . '</span>	';
		}	
	
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$сopyright_1= $instance['сopyright_1'] ?: 	'Мастерская-музей реалистичной живописи Александра Николаева';		
		$сopyright_2= $instance['сopyright_2'] ?: 'Сайт выполнен в учебных целях и не является коммерческим проектом. Название вымышлено.';		
		
		?>
	

			<p>
				<label for="<?php echo $this->get_field_id( 'сopyright_1' ); ?>"><?php _e( 'Enter site name:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'сopyright_1' ); ?>" name="<?php echo $this->get_field_name( 'сopyright_1' ); ?>" type="text" value="<?php echo esc_attr( $сopyright_1 ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('сopyright_2'); ?>"><?php _e( 'Enter text:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('сopyright_2'); ?>" name="<?php echo $this->get_field_name('сopyright_2'); ?>" type="text" value="<?php echo esc_attr( $сopyright_2 ); ?>">
			</p>
			
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['сopyright_1'] = ( ! empty( $new_instance['сopyright_1'] ) ) ? strip_tags( $new_instance['сopyright_1'] ) : '';		
		$instance['сopyright_2'] = ( ! empty( $new_instance['сopyright_2'] ) ) ? strip_tags( $new_instance['сopyright_2'] ) : '';		
		return $instance;
	}

	// скрипт виджета
	function add_сopyright_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_сopyright_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Сopyright_Widget

// регистрация сopyright__widget в WordPress
function register_сopyright__widget() {
	register_widget( 'Сopyright_Widget' );
}
add_action( 'widgets_init', 'register_сopyright__widget' );

// окончание регистрации виджета





// определяем количество просмотров записи
/* количество просмотров */
 
function getPostViews($postID){
 $count_key = 'post_views_count';
 $count = get_post_meta($postID, $count_key, true);
 if($count==''){
 delete_post_meta($postID, $count_key);
 add_post_meta($postID, $count_key, '0');
 return "0 просмотров";
 }
 return ' Просмотров: '.$count;
 }
 function setPostViews($postID) {
 $count_key = 'post_views_count';
 $count = get_post_meta($postID, $count_key, true);
 if($count==''){
 $count = 0;
 delete_post_meta($postID, $count_key);
 add_post_meta($postID, $count_key, '0');
 }else{
 $count++;
 update_post_meta($postID, $count_key, $count);
 }
	}
	
	// 1. обрезает цитату до кол-во слов
add_filter( 'get_the_excerpt', 'echo_the_excerpt');
function echo_the_excerpt($excerpt){
	return wp_trim_words( $excerpt, 20) .'';
} ;

// 2. обрезает загологовок до кол-во символов пример урока превращаем в функцию
add_filter( 'the_title', 'strimwidth_the_title');
function strimwidth_the_title($title){
	return mb_strimwidth ($title, 0, 70, '...') ;
} ;

/*
 * "Хлебные крошки" для WordPress
 * автор: Dimox
 * версия: 2019.03.03
 * лицензия: MIT
*/
function the_breadcrumbs() {

	/* === ОПЦИИ === */
	$text['home']     = 'Главная'; // текст ссылки "Главная"
	// $text['cat_parent']     = 'Категории'; // текст ссылки "Категории"
	$text['category'] = '%s'; // текст для страницы рубрики
	$text['search']   = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
	$text['tag']      = 'Записи с тегом "%s"'; // текст для страницы тега
	$text['author']   = 'Статьи автора %s'; // текст для страницы автора
	$text['404']      = 'Ошибка 404'; // текст для страницы 404
	$text['page']     = 'Страница %s'; // текст 'Страница N'
	$text['cpage']    = 'Страница комментариев %s'; // текст 'Страница комментариев N'

	$wrap_before    = '<div class="bread-crumbs_wrapp" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
		$wrap_after     = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
		$sep            = '<span class="breadcrumbs__separator"></span>'; // разделитель между "крошками"
		$before         = '<div class="bread-crumbs-item">'; // тег перед текущей "крошкой"
		$after          = '</div>'; // тег после текущей "крошки"

	$show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
	$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
	$show_current   = 1; // 1 - показывать название текущей страницы, 0 - не показывать
	$show_last_sep  = 1; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
	/* === КОНЕЦ ОПЦИЙ === */
	
	global $post;
	$home_url       = home_url('/');	
	$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link          .= '<meta itemprop="position" content="%3$s" />';
	$link          .= '</span>';
	$parent_id      = ( $post ) ? $post->post_parent : '';
	$home_link      = sprintf( $link, $home_url, $text['home'], 1 );

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;

	} else {

		$position = 0;

		echo $wrap_before;

		if ( $show_home_link ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() ) {
			$parents = get_ancestors( get_query_var('cat'), 'category' );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $tax;
				echo $sep;
				echo $before . sprintf( $text['cat_parent']) . $after;
				echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat = get_query_var('cat');
				echo $before . sprintf( $text['cat_parent']) . $after;
				echo $sep;
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					// echo get_the_archive_title();
					echo $before . sprintf( $text['cat_parent']) . $after;
					echo $sep;
					echo $before . sprintf( $text['category'], single_cat_title( '', true ) ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) echo $sep;
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_time('Y') . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_month() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_day() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_single() && ! is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$position += 1;
				$post_type = get_post_type_object( get_post_type() );
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} else {
				$cat = get_the_category(); $catID = $cat[0]->cat_ID;
				$parents = get_ancestors( $catID, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current ) echo $sep . $before . get_the_title() . $after;
					elseif ( $show_last_sep ) echo $sep;
				}
			}

		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . $post_type->label . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_attachment() ) {
			$parent = get_post( $parent_id );
			$cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
			$parents = get_ancestors( $catID, 'category' );
			$parents = array_reverse( $parents );
			$parents[] = $catID;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_page() && ! $parent_id ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_title() . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_page() && $parent_id ) {
			$parents = get_post_ancestors( get_the_ID() );
			foreach ( array_reverse( $parents ) as $pageID ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
			}
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tagID = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . $text['404'] . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;

	}
} // end of the_breadcrumbs()
// * Конец "Хлебные крошки" для WordPress

// оптимизация скорости загрузки


// Отключаем jquery-migrate.js
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
// отменяем зарегистрированный jQuery
wp_deregister_script('jquery-core');
wp_deregister_script('jquery');

// регистрируем
wp_register_script( 'jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, null, true );
wp_register_script( 'jquery', false, array('jquery-core'), null, true );

// подключаем
wp_enqueue_script( 'jquery' );
}