<? //начало документа

//Собираю полезные WORDPRESS Функции
//Кидайте PR 



//запретить вывод информации о версии вашей платформы 
remove_action('wp_head', 'wp_generator');



//отключение обновлений плагинов
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
wp_clear_scheduled_hook( 'wp_update_plugins' );



//Произвольная таксономия
function portfolio_init() {
	$args = array(
	'label' => 'Портфолио',
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => array('slug' => 'portfolio'),
	'query_var' => true,
	'menu_icon' => 'dashicons-images-alt2',
	'supports' => array(
	'title',
	'editor',
	'thumbnail',
	'page-attributes',)
	);
	register_post_type( 'portfolio', $args );
	flush_rewrite_rules();
	}
	add_action( 'init', 'portfolio_init' );
	register_taxonomy("portfolios", array("portfolio"), array("hierarchical" => true, "label" => "Категории", "singular_label" => "portfolio item", "rewrite" => true));
	function true_custom_fields() {
		add_post_type_support( 'portfolio', 'custom-fields'); // в качестве первого параметра укажите название типа поста
	}
	 
add_action('init', 'true_custom_fields');
add_action( 'admin_init', 'add_portfloio_tax' );

function add_portfloio_tax() 
{
    add_post_type_support( 'portfolio', 'page-attributes' );
}



//поддержка  webp
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');



//Регистрация доп сайдбара
function new_widgets_init() {
	register_sidebar( array(
	   'name' => 'Сайдбар в блоге',
	   'id' => 'blog-sidebar',
	   'description'   => 'Сайдбар в блоге',
	   'before_widget' => '<aside style="background: #fbf9ff;padding: 30px;margin-bottom: 30px;" id="%1$s" class="widget %2$s">',
	   'after_widget'  => '</aside>',
	   'before_title'  => '<h2 class="widgettitle">',
	   'after_title'   => '</h2>',
	) );
 }
add_action( 'widgets_init', 'new_widgets_init' );



//замена лого в админке
function my_login_logo_one() { 
?> 
<style type="text/css">
    body.login div#login h1 a {
        background-image: url(/wp-content/themes/themename/wlogo.png);  //Add your own logo image in this url 
        padding-bottom: 30px; 
    }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo_one' );



// регистрация новый разрешений
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'custom-thumb', 50, 50 ); 
}
add_image_size( 'mytheme-mini', 500, 300, true );



//вставка критического CSS
function critical_css() {
    ?>
           <style>
           /* Критический CSS*/
           
           </style>
    <?php
}
add_action('wp_head', 'critical_css');



//подключение JQuery 
function jquery_register() {
	if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', ( 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' ), false, null, true );
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'init', 'jquery_register' );



// правильный способ подключить стили и скрипты
function theme_name_scripts() {	
	wp_enqueue_style( 'style-name', get_template_directory_uri() . '/dist/css/style-name.min.css' );
	wp_enqueue_script( 'script-name', get_template_directory_uri() . '/dist/js/script-name.min.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );



//отключить стили на конкретной странице
function my_deregister_style () {
	if ( is_page ('35') ) {//указать номер сраницы
		wp_deregister_style ( 'style-name' );		
		wp_deregister_script ( 'script-name' );
	
    }
}
add_action ( 'wp_print_styles', 'my_deregister_style', 100 );









//woocommerce


//показавыть цену у вариативных товаров даже если она равна между собой
add_filter('woocommerce_show_variation_price', function() {
    return true;
});



//отключить зум в woocommerce
function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );



//конец документа
?>